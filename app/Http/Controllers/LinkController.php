<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Referrer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LinkController extends Controller
{
    public function linkPage(Request $request): View
    {
        $links =  Link::get();
        return view('profile.addlink', [
            'links' => $links,
        ]);
    }

    public function linkInsert(Request $request): \Illuminate\Http\RedirectResponse
    {


        $image_name = $request->input('image_name');
        $info = pathinfo( $image_name);
        $image_url = $request->input('image_url');
        $facebook_link = $request->input('facebook_link');
        $all_link = $request->input('all_link');

        $uploaded_image = null;

        if ($request->hasFile('image')) {

             $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,webapp,svg|max:2048',
            ]);

            $image = $request->file('image');

            $imageName = $info['filename'] . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $uploaded_image =  $imageName;
        }

        $Link =  new Link();
        $Link->image_name = $image_name;
        $Link->image_upload = $uploaded_image;
        $Link->image_url =   $image_url ;
        $Link->facebook_link = $facebook_link ;
        $Link->all_link = $all_link;
        $Link->save();

        return back()->with('success', 'Image uploaded successfully');


    }

    public function allLinks(){
        return response()->json(Link::all());
    }


    public function allReferrer(){
        $referrers = Referrer::paginate(1000);
        return response()->json([
            'data' => $referrers->items(),  // Return only the items
            'pagination' => [
                'total' => $referrers->total(),
                'current_page' => $referrers->currentPage(),
                'per_page' => $referrers->perPage(),
                'last_page' => $referrers->lastPage(),
                'from' => $referrers->firstItem(),
                'to' => $referrers->lastItem(),
            ]
        ]);
    }

}
