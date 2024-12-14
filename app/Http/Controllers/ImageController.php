<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class ImageController extends Controller
{
    public function showImage(Request $request)
    {
        // Path to your image file
        $imagePath = public_path('uploads/beef.jpg'); // Update path as needed

        if (str_contains($request->headers->get('referer'), 'facebook.com')) {
            // Redirect to the new URL
            return Redirect::to('https://healthspikes.com');
        }

        // Check if the file exists
        if (!File::exists($imagePath)) {
            abort(404); // Return a 404 error if the image is not found
        }

        // Set the appropriate headers for the image
        $image = File::get($imagePath);
        $type = File::mimeType($imagePath);

        // Return the image content
        return response($image, 200)
            ->header('Content-Type', $type);
    }
}
