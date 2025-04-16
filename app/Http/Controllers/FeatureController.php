<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    // Show the first feature record
    public function show()
    {
        $feature = Feature::first();

        // Append full image URLs if available
        if ($feature) {
            $feature->mbl_img1 = $feature->mbl_img1 ? url('uploads/features/' . $feature->mbl_img1) : null;
            $feature->mbl_img2 = $feature->mbl_img2 ? url('uploads/features/' . $feature->mbl_img2) : null;
            $feature->mbl_img3 = $feature->mbl_img3 ? url('uploads/features/' . $feature->mbl_img3) : null;
            $feature->mbl_img4 = $feature->mbl_img4 ? url('uploads/features/' . $feature->mbl_img4) : null;
        }

        return response()->json($feature);
    }

    // Store or update feature data
    public function storeOrUpdate(Request $request)
    {
        $feature = Feature::first();

        // Preserve existing image names if no new files uploaded
        $mbl_img1 = $feature->mbl_img1 ?? null;
        $mbl_img2 = $feature->mbl_img2 ?? null;
        $mbl_img3 = $feature->mbl_img3 ?? null;
        $mbl_img4 = $feature->mbl_img4 ?? null;

        // Handle file uploads
        if ($request->hasFile('mbl_img1')) {
            $file = $request->file('mbl_img1');
            $mbl_img1 = time() . '_mbl_img1.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/features'), $mbl_img1);
        }

        if ($request->hasFile('mbl_img2')) {
            $file = $request->file('mbl_img2');
            $mbl_img2 = time() . '_mbl_img2.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/features'), $mbl_img2);
        }

        if ($request->hasFile('mbl_img3')) {
            $file = $request->file('mbl_img3');
            $mbl_img3 = time() . '_mbl_img3.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/features'), $mbl_img3);
        }

        if ($request->hasFile('mbl_img4')) {
            $file = $request->file('mbl_img4');
            $mbl_img4 = time() . '_mbl_img4.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/features'), $mbl_img4);
        }

        // Prepare the data
        $data = [
            'title1' => $request->input('title1'),
            'title2' => $request->input('title2'),
            'all_mbl_img' => $request->input('all_mbl_img'),
            'mbl_img1' => $mbl_img1,
            'mbl_img2' => $mbl_img2,
            'mbl_img3' => $mbl_img3,
            'mbl_img4' => $mbl_img4,
        ];

        // Save or update the feature
        if ($feature) {
            $feature->update($data);
        } else {
            $feature = Feature::create($data);
        }

        // Append full image URLs before returning
        $feature->mbl_img1 = $feature->mbl_img1 ? url('uploads/features/' . $feature->mbl_img1) : null;
        $feature->mbl_img2 = $feature->mbl_img2 ? url('uploads/features/' . $feature->mbl_img2) : null;
        $feature->mbl_img3 = $feature->mbl_img3 ? url('uploads/features/' . $feature->mbl_img3) : null;
        $feature->mbl_img4 = $feature->mbl_img4 ? url('uploads/features/' . $feature->mbl_img4) : null;

        return response()->json($feature);
    }
}
