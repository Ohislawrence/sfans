<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliatelink;
use App\Models\Chatbot;
use App\Models\Conversation;
use App\Models\User;
use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class ChatController extends Controller
{
    protected $chatbotService;
    
    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function train($username)
    {
        $bot = User::where('username', $username)->firstOrFail();
        return view('admin.chat.train', compact('bot'));
    }
    
    public function create(Request $request, $username)
    {
        $request->validate([
            'intents' => 'required|file|mimes:json|max:2048'
        ]);

        try {
            // Read and validate the uploaded JSON file
            $intents = json_decode(file_get_contents($request->file('intents')->getRealPath()), true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON file');
            }

            if (!isset($intents['intents']) || !is_array($intents['intents'])) {
                throw new \Exception('JSON must contain "intents" array');
            }

            // Validate each intent
            foreach ($intents['intents'] as $intent) {
                if (!isset($intent['tag']) || !isset($intent['patterns']) || !isset($intent['responses'])) {
                    throw new \Exception('Each intent must have tag, patterns and responses');
                }
            }

            // Generate unique filenames
            $timestamp = now()->timestamp;
            $intentsFilename = "chatbot_intents/intents_{$username}_{$timestamp}.json";
            $modelFilename = "chatbot_models/model_{$username}_{$timestamp}.model";

            // Store the intents JSON file
            Storage::disk('local')->put($intentsFilename, json_encode($intents));
            
            // Train the model
            $trainedModel = $this->chatbotService->train($intents);
            
            // Store the trained model file
            Storage::disk('local')->put($modelFilename, serialize($trainedModel));

            // Verify both files were created
            if (!Storage::disk('local')->exists($intentsFilename) || !Storage::disk('local')->exists($modelFilename)) {
                throw new \Exception('Failed to save training files');
            }

            // Save the chatbot with file references
            $chatbot = Chatbot::updateOrCreate(
                ['username' => $username],
                [
                    'name' => $username,
                    'intents_data' => $intentsFilename, // Store file path
                    'trained_data' => $modelFilename,   // Store file path
                    'last_trained_at' => now(),
                    'training_version' => $timestamp   // Track version
                ]
            );

            // Clean up previous versions if needed
            $this->cleanupOldTrainingFiles($username, $timestamp);

            return back()->with('success', 'Chatbot trained successfully');

        } catch (\Exception $e) {
            // Clean up any created files if operation failed
            if (isset($intentsFilename) && Storage::disk('local')->exists($intentsFilename)) {
                Storage::disk('local')->delete($intentsFilename);
            }
            if (isset($modelFilename) && Storage::disk('local')->exists($modelFilename)) {
                Storage::disk('local')->delete($modelFilename);
            }
            
            return back()
                ->withInput()
                ->with('error', 'Training failed: ' . $e->getMessage());
        }
    }

    private function cleanupOldTrainingFiles($username, $currentTimestamp)
    {
        try {
            // Delete old intent files (keep last 3 versions)
            $intentsFiles = Storage::disk('local')->files("chatbot_intents");
            $oldIntents = array_filter($intentsFiles, function($file) use ($username, $currentTimestamp) {
                return str_contains($file, "intents_{$username}_") && 
                    !str_contains($file, "_{$currentTimestamp}.json");
            });
            
            // Sort by timestamp (newest first)
            usort($oldIntents, function($a, $b) {
                return Storage::disk('local')->lastModified($b) <=> Storage::disk('local')->lastModified($a);
            });
            
            // Keep only the 3 most recent files
            foreach (array_slice($oldIntents, 3) as $file) {
                Storage::disk('local')->delete($file);
            }

            // Same for model files
            $modelFiles = Storage::disk('local')->files("chatbot_models");
            $oldModels = array_filter($modelFiles, function($file) use ($username, $currentTimestamp) {
                return str_contains($file, "model_{$username}_") && 
                    !str_contains($file, "_{$currentTimestamp}.model");
            });
            
            usort($oldModels, function($a, $b) {
                return Storage::disk('local')->lastModified($b) <=> Storage::disk('local')->lastModified($a);
            });
            
            foreach (array_slice($oldModels, 3) as $file) {
                Storage::disk('local')->delete($file);
            }
        } catch (\Exception $e) {
            Log::error("Failed to clean up old training files: " . $e->getMessage());
        }
    }
    
    public function chat(Request $request, $botUserId)
    {
        try {
            $request->validate(['message' => 'required|string|max:500']);

            $chatbot = Chatbot::where('username', $botUserId)->firstOrFail();
            
            if (!$chatbot->trained_data || !$chatbot->intents_data) {
            throw new \Exception("Chatbot is not properly trained");
        }

        // Verify both files exist
        if (!Storage::disk('local')->exists($chatbot->trained_data) || 
            !Storage::disk('local')->exists($chatbot->intents_data)) {
            throw new \Exception("Training files not found");
        }

        // Load the trained model
        $modelData = Storage::disk('local')->get($chatbot->trained_data);
        $model = unserialize($modelData);
        
        // Load intents data (for debugging or other purposes)
        $intentsData = json_decode(Storage::disk('local')->get($chatbot->intents_data), true);

            $prediction = $this->chatbotService->predictWithConfidence(
                $request->message, 
                $model
            );

            $confidenceThreshold = 0.7;
            $fallbackThreshold = 0.6;
            
            // Determine response based on confidence
            if ($prediction['confidence'] < $confidenceThreshold) {
                $defaultResponses = [
                    "I'm not sure I understand. Could you rephrase that?",
                    "I don't have a good answer for that. Try asking something else.",
                    "Could you ask that differently? I didn't quite get it."
                ];
                $response = $defaultResponses[array_rand($defaultResponses)];
            } else {
                $response = $prediction['response'];
            }
            //additional mgs
            $moreResponse = $this->addMoreMsg($prediction['tag']) ?? '';

            // Save conversation
            Conversation::create([
                'user_id' => auth()->id(),
                'chatbot_id' => $chatbot->id,
                'message' => $request->message,
                'intent-tag' =>$prediction['tag'],
                'response' => $response . $moreResponse ,
                'confidence' => $prediction['confidence'],
                'is_fallback' => $prediction['confidence'] < $fallbackThreshold,
            ]);

            return response()->json([
                'response' => $response . $moreResponse
            ]);

        } catch (\Exception $e) {
            Log::error("Chat error: " . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred',
                'response' => "I'm having trouble responding right now, chat later."
            ], 500);
        }
    }
    
    public function addMoreMsg($tag)
    {
        // First check if tag is empty
        if (empty($tag)) {
            return '';
        }

        // Find a random affiliate link that contains the tag
        $affiliateLink = Affiliatelink::whereRaw('LOWER(tags) LIKE ?', ['%'.strtolower($tag).'%'])
            ->inRandomOrder()
            ->take(10)
            ->first();

        // Handle case where no link is found
        if (!$affiliateLink) {
            return '';
        }

        // Sanitize the link for HTML output
        $safeLink = e($affiliateLink->link);
        $username = e(auth()->user()->username);

        // Build the message with proper HTML escaping
        $message = sprintf(
            'Well %s, to see more of me <a href="%s" target="_blank" rel="noopener noreferrer"><b>Click here,</b></a> I will be waiting',
            $username,
            $safeLink
        );

        return '<br/>' . $message;
    }
}
