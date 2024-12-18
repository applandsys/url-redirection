<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Referrer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


class ImageController extends Controller
{
    public function showImage(Request $request)
    {
        $referrer = $request->header('referer');
        $current_url = url()->full();
        $this->storeReferrer($referrer,$current_url);
        $segment = Route::current()->parameter('segment');


        $Link =  Link::where('image_name',$segment)->first();

        if(!$Link){
            $Link =  Link::first();
        }

        if ($Link !== null && $Link->image_upload !== null) {
            $imagePath = public_path('uploads/' . $Link->image_upload );
        } elseif ($Link !== null && $Link->image_url !== null) {
            $imagePath = file_get_contents($Link->image_url);
        } else {
            $imagePath = public_path('uploads/beef.jpg' );
        }


        if(str_contains($request->headers->get('referer'), 'facebook.com')) {
            $redirect_url =  $Link->facebook_link ;
        }else{
            $redirect_url =  $Link->all_link ;
        }

//       if(!file_exists( $imagePath )){
//           $imagePath = public_path('uploads/beef.jpg' );
//       }

        $extension = pathinfo(parse_url($imagePath, PHP_URL_PATH), PATHINFO_EXTENSION);

        // List of common image extensions
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];


        if (!in_array(strtolower($extension), $imageExtensions)) {
            $imagePath = public_path('uploads/beef.jpg' );
        }

        if (!file_exists($imagePath) || !is_readable($imagePath)) {
            return Redirect::to($redirect_url);
        }


        if (file_exists( $imagePath )) {
            return response()->stream(function() use ($imagePath) {
                echo file_get_contents($imagePath);
            }, 200, [
                'Content-Type' => mime_content_type($imagePath),
                'Content-Disposition' => 'inline; filename="' . basename($imagePath) . '"',
                'Refresh' => '5;url=' . $redirect_url
            ]);
        } else {
            return Redirect::to($redirect_url);
        }
    }

    public function storeReferrer($referrer, $current_url )
    {
        if ($referrer) {
            Referrer::create(['url' => $referrer,'current_url' => $current_url]);
        }
    }

}





//
//echo "<img src='" . $imagePath . "'>";
//        dd($imagePath);


// Check if the file exists
//        if (!File::exists($imagePath)) {
//            abort(404); // Return a 404 error if the image is not found
//        }

// Set the appropriate headers for the image
//  $image = File::get($imagePath);
//  $type = File::mimeType($imagePath);


// $info = pathinfo(  $imagePath );
