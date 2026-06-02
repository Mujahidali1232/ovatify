<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Handle file uploads (Audio, Video, Image)
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200', // 50MB max for now
            'type' => 'required|string|in:audio,video,image,illustration',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $type = $request->input('type');
            
            // Generate a secure name
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            
            // Define path based on type
            $path = 'uploads/' . $type . 's';
            
            // Store the file
            $storedPath = $file->storeAs($path, $filename, 'public');

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'path' => $storedPath,
                'url' => Storage::url($storedPath),
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'type' => $type
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file was uploaded.'
        ], 400);
    }
}
