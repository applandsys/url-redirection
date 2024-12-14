<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

class ImageController extends Controller
{
    public function showImage(Request $request)
    {

        $segment = Route::current()->parameter('segment');

        $Link =  Link::where('image_name',$segment)->firstOrFail();

        if($Link->image_upload!==null){
            $imagePath = public_path('uploads/'.$Link->image_upload);
        }elseif($Link->image_url !==null){
            $imagePath = $Link->image_url;
        }else{
            $imagePath = public_path('uploads/beef.jpg');
        }

        // Check if the file exists
        if (!File::exists($imagePath)) {
            abort(404); // Return a 404 error if the image is not found
        }

        // Set the appropriate headers for the image
        $image = File::get($imagePath);
        $type = File::mimeType($imagePath);

    //    return response($image, 200)->header('Content-Type', $type);

        // Return the image content
        if (str_contains($request->headers->get('referer'), 'facebook.com')) {
            return response($image, 200)
                ->header('Content-Type', $type)->header('Refresh', '0.1;url=' . $Link->	facebook_link);
        }else{
            return response($image, 200)
                ->header('Content-Type', $type)->header('Refresh', '0.1;url=' . $Link->	all_link);
        }
    }
}
