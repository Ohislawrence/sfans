<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Video;
use Illuminate\Support\Str;

class CsvController extends Controller
{
    public function importVideosFromCSV(Request $request)
{
    $validator = Validator::make($request->all(), [
        'csv_file' => 'required|file|mimes:csv,txt'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Get the uploaded file
    $file = $request->file('csv_file');
    $filePath = $file->getRealPath();

    // Open the file
    $handle = fopen($filePath, 'r');
    
    // Skip the header row if your CSV has one
    $header = fgetcsv($handle);
    
    $importedCount = 0;
    $failedRows = [];

    // Process each row
    while (($row = fgetcsv($handle)) !== false) {
        try {
            // Map CSV columns to database fields
            $videoData = [
                'link' => $row[0] ?? null,
                'title' => $row[1] ?? null,
                'slug' => Str::slug($row[1]),
                'duration' => $row[3] ?? null,
                'thumbnail' => $row[4] ?? null,
                'iframe' => $row[5] ?? null,
                'tags' => $row[6] ?? null,
                'pornstars' => $row[7] ?? null,
                'numbers' => $row[8] ?? null,
                'category' => $row[9] ?? null,
                'quality' => $row[10] ?? null,
                'channel' => $row[11] ?? null,
                'empty' => $row[12] ?? null,
                'date' => $row[13] ?? now(),
                'media_type' => $row[14] ?? null,
                'likes' => $row[15] ?? 0,
                'comments' => $row[16] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Validate the data before inserting
            $validator = Validator::make($videoData, [
                'link' => 'required|url',
                'title' => 'required|string|max:255|unique:videos,title',
                // Add other validation rules as needed
            ]);

            if ($validator->fails()) {
                $failedRows[] = [
                    'row' => $row,
                    'errors' => $validator->errors()
                ];
                continue;
            }

            // Insert into database
            Video::create($videoData);
            $importedCount++;

        } catch (\Exception $e) {
            $failedRows[] = [
                'row' => $row,
                'error' => $e->getMessage()
            ];
            continue;
        }
    }

    fclose($handle);

    return response()->json([
        'message' => 'CSV import completed',
        'imported_count' => $importedCount,
        'failed_rows' => $failedRows
    ]);
}
}
