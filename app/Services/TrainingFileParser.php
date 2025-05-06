<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class TrainingFileParser
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function parse(UploadedFile $file, string $delimiter = '|||')
    {
        $content = $file->get();
        $lines = explode("\n", $content);
        
        $samples = [];
        $labels = [];
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            $parts = explode($delimiter, $line);
            if (count($parts) >= 2) {
                $samples[] = trim($parts[0]);
                $labels[] = trim($parts[1]);
            }
        }
        
        return [
            'samples' => $samples,
            'labels' => $labels,
        ];
    }
}
