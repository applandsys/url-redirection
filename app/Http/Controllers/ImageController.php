<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Referrer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function showImage(Request $request)
    {

        $referrer = $request->header('referer');
        $this->storeReferrer($referrer);

        $segment = Route::current()->parameter('segment');

        $Link =  Link::where('image_name',$segment)->first();

      //  dd( $Link);

        if ($Link !== null && $Link->image_upload !== null) {
            $imagePath = public_path('uploads/' . $Link->image_upload );
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        } elseif ($Link !== null && $Link->image_url !== null) {
            $extension = Str::afterLast(parse_url($Link->image_url , PHP_URL_PATH), '.');
            $imagePath = $Link->image_url;
        } else {
            $extension = "jpeg";
            $imagePath = public_path('uploads/beef.jpg' );
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

        if(isset($extension)){
            $type = "image/".$extension ;
        }else{
            $type = "image/JPEG";
        }

        // dd($info);


    //    return response($image, 200)->header('Content-Type', $type);
        if(str_contains($request->headers->get('referer'), 'facebook.com')) {
            $redirect_url =  $Link->facebook_link ;
        }else{
            $redirect_url =  $Link->all_link ;
        }

        $path = public_path('uploads/' . $Link->image_upload );
        if (file_exists( $imagePath )) {
            return response()->stream(function() use ($path) {
                echo file_get_contents($path);
            }, 200, [
                'Content-Type' => mime_content_type($path),
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
                'Refresh' => '01;url=' . $redirect_url // Add the Refresh header
            ]);
        } else {
            return Redirect::to($redirect_url);
        }


        // Return the image content
//        if(str_contains($request->headers->get('referer'), 'facebook.com')) {
//            return response("https://eduandjobs.com/public/uploads/44.jpeg", 200)
//                ->header('Content-Type', $type);
//
//                //->header('Refresh', '5;url=' . $Link->	facebook_link);
//        }else{
//            return response("https://eduandjobs.com/public/uploads/44.jpeg", 200)
//                ->header('Content-Type', $type);
//                //->header('Refresh', '5;url=' . $Link->	all_link);
//        }
    }

    public function storeReferrer($referrer )
    {
        if ($referrer) {
            Referrer::create(['url' => $referrer]);
        }
    }

}
