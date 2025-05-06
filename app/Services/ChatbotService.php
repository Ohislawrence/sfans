<?php

namespace App\Services;

use App\Models\BotModel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use RuntimeException;
use Throwable;
use Illuminate\Support\Facades\Storage;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;
use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;
use Skyeng\Lemmatizer;
use Phpml\ModelManager;
use Phpml\Classification\NaiveBayes;

class ChatbotService
{
    private $vectorizer;
    private $transformer;
    private $classifier;
    private $lemmatizer;
    private $stopwords;
    
    
    public function __construct()
    {
        $this->vectorizer = new TokenCountVectorizer(new WordTokenizer());
        $this->transformer = new TfIdfTransformer();
        $this->classifier = new NaiveBayes();
        $this->lemmatizer = new Lemmatizer();
        $this->stopwords = $this->loadStopwords();
    }


    protected function loadStopwords()
    {
        return Cache::rememberForever('chatbot_stopwords', function() {
            return [
                'i', 'me', 'my', 'myself', 'we', 'our', 'ours', 'ourselves', 'you', 'your', 'yours',
                'yourself', 'yourselves', 'he', 'him', 'his', 'himself', 'she', 'her', 'hers',
                'herself', 'it', 'its', 'itself', 'they', 'them', 'their', 'theirs', 'themselves',
                'what', 'which', 'who', 'whom', 'this', 'that', 'these', 'those', 'am', 'is', 'are',
                'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'having', 'do', 'does',
                'did', 'doing', 'a', 'an', 'the', 'and', 'but', 'if', 'or', 'because', 'as', 'until',
                'while', 'of', 'at', 'by', 'for', 'with', 'about', 'against', 'between', 'into',
                'through', 'during', 'before', 'after', 'above', 'below', 'to', 'from', 'up', 'down',
                'in', 'out', 'on', 'off', 'over', 'under', 'again', 'further', 'then', 'once', 'here',
                'there', 'when', 'where', 'why', 'how', 'all', 'any', 'both', 'each', 'few', 'more',
                'most', 'other', 'some', 'such', 'no', 'nor', 'not', 'only', 'own', 'same', 'so',
                'than', 'too', 'very', 's', 't', 'can', 'will', 'just', 'don', 'should', 'now'
            ];
        });
    }
    
    public function train(array $intents)
    {
        $cacheKey = 'chatbot_preprocessed_patterns_' . md5(json_encode($intents));
        
        $trainingData = Cache::remember($cacheKey, now()->addDays(30), function() use ($intents) {
            $samples = [];
            $labels = [];
            
            foreach ($intents['intents'] as $intent) {
                foreach ($intent['patterns'] as $pattern) {
                    $processed = $this->preprocessText($pattern);
                    $samples[] = $processed;
                    $labels[] = $intent['tag'];
                }
            }

            $this->vectorizer->fit($samples);
            $this->vectorizer->transform($samples);

            $this->transformer->fit($samples);
            $this->transformer->transform($samples);

            $this->classifier->train($samples, $labels);

            return [
                'vectorizer' => $this->vectorizer,
                'transformer' => $this->transformer,
                'classifier' => $this->classifier,
                'intents' => $intents,
                'vocabulary' => $this->vectorizer->getVocabulary(),
                'preprocessed_samples' => $samples,
                'labels' => $labels
            ];
        });
        
        return $trainingData;
    }
    
    public function predict($text, $model)
    {
        $text = $this->preprocessText($text);
        $samples = [$text];
        
        $model['vectorizer']->transform($samples);
        $model['transformer']->transform($samples);
        
        $tag = $model['classifier']->predict($samples)[0];
        
        foreach ($model['intents']['intents'] as $intent) {
            if ($intent['tag'] === $tag) {
                return [
                    'response' => $intent['responses'][array_rand($intent['responses'])],
                    'tag' => $tag
                ];
            }
        }
        
        return [
            'response' => "I'm not sure how to respond to that.",
            'tag' => null
        ];
    }
    
    private function preprocessText($text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', '', $text);
        $words = explode(' ', $text);
        $lemmatized = [];
        
        foreach ($words as $word) {
            // Skip stopwords
            if (in_array($word, $this->stopwords)) {
                continue;
            }
            
            $lemma = $this->lemmatizer->getOnlyLemmas($word);
            $lemmatized[] = !empty($lemma) ? $lemma[0] : $word;
        }
        
        return implode(' ', $lemmatized);
    }
    
    public function saveModel($model, $path)
    {
        $modelManager = new ModelManager();
        $modelManager->saveToFile($model, $path);
    }
    
    public function loadModel($path)
    {
        $modelManager = new ModelManager();
        return $modelManager->restoreFromFile($path);
    }

    public function predictWithConfidence($text, $model)
    {
        try {
            $text = $this->preprocessText($text);
            $samples = [$text];
            
            if (!isset($model['vectorizer']) || !isset($model['classifier']) || !isset($model['vocabulary'])) {
                throw new \Exception("Invalid model structure");
            }

            $model['vectorizer']->transform($samples);
            $model['transformer']->transform($samples);
            
            $tag = $model['classifier']->predict($samples)[0];
            
            $confidence = $this->calculatePatternSimilarity($text, $tag, $model);
            
            foreach ($model['intents']['intents'] as $intent) {
                if ($intent['tag'] === $tag) {
                    return [
                        'response' => $intent['responses'][array_rand($intent['responses'])],
                        'tag' => $tag,
                        'confidence' => $confidence
                    ];
                }
            }

            return [
                'response' => "I'm not sure how to respond to that.",
                'tag' => null,
                'confidence' => 0
            ];
        } catch (\Exception $e) {
            Log::error("Prediction failed: " . $e->getMessage());
            return [
                'response' => "I'm having trouble understanding that.",
                'tag' => null,
                'confidence' => 0
            ];
        }
    }

    private function calculatePatternSimilarity($text, $tag, $model) 
    {
        if (!isset($model['intents']['intents'])) {
            return 0;
        }

        $patterns = [];
        foreach ($model['intents']['intents'] as $intent) {
            if ($intent['tag'] === $tag) {
                $patterns = $intent['patterns'];
                break;
            }
        }

        if (empty($patterns)) {
            return 0;
        }

        $maxSimilarity = 0;
        foreach ($patterns as $pattern) {
            similar_text($text, $this->preprocessText($pattern), $similarity);
            $maxSimilarity = max($maxSimilarity, $similarity/100);
        }

        return $maxSimilarity;
    }

    public function logConversation($userId, $chatbotId, $message, $response, $intentTag)
    {
        // Store conversation in database
        
        
        // Also cache recent conversations for quick retrieval
        $cacheKey = "recent_conversations_{$userId}_{$chatbotId}";
        $conversations = Cache::get($cacheKey, []);
        $conversations[] = [
            'message' => $message,
            'response' => $response,
            'tag' => $intentTag,
            'timestamp' => now()
        ];
        Cache::put($cacheKey, array_slice($conversations, -10), now()->addHours(1));
    }

    
}