<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Chatbot;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Serializers\RBX;
use Rubix\ML\Datasets\Unlabeled;
use Illuminate\Support\Carbon;

class BotController extends Controller
{
    public function index($botId)
    {
        $user = auth()->user();
        $botUser = User::where('username', $botId)->role('slut')->first();
        $chatlist = Conversation::selectRaw('chatbot_id, MAX(updated_at) as last_updated_at')
                    ->groupBy('chatbot_id')
                    ->orderByDesc('last_updated_at')
                    ->get();
                    $oldmessages = Conversation::where('user_id', $user->id)
                    ->where('chatbot_id', $botUser->chatslut->id)
                    ->orderBy('created_at')
                    ->get(['id', 'response', 'message', 'created_at']);

        //dd($oldmessages);

        return view('frontpages.chat.index', compact('botId', 'botUser', 'chatlist','oldmessages'));
    }

    public function chatHistoty($botUsername)
    {
        $slut = Chatbot::where('username', $botUsername)->first();
        $user = auth()->user();
        $messages = Conversation::where('chatbot_id', $slut->id)
                ->where('user_id', $user->id)
                ->orderBy('created_at')
                ->get()
                ->map(function ($msg) {
                    return $this->formatMessage($msg);
                });

            return response()->json($messages);
    }

    protected function formatMessage(Conversation $message): array
    {
        return [
            'id' => $message->id,
            'message' => $message->message,
            'response' => $message->response,
            'is_sent' => true,
            'time' => $message->created_at->format('h:i A'),
            'date' => $message->created_at->format('Y-m-d'),
            'date_display' => $this->getDisplayDate($message->created_at),
            'meta' => [ // Additional metadata if needed
                'is_edited' => $message->is_edited ?? false,
                'is_read' => $message->is_read ?? false
            ]
        ];
    }

    /**
     * Get human-friendly display date
     *
     * @param  Carbon  $date
     * @return string
     */
    protected function getDisplayDate(Carbon $date): string
    {
        if ($date->isToday()) {
            return 'Today';
        }

        if ($date->isYesterday()) {
            return 'Yesterday';
        }

        if ($date->isCurrentYear()) {
            return $date->format('M j'); // May 2
        }

        return $date->format('M j, Y'); // May 2, 2025
    }

    
}
