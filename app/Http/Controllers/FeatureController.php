<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;

class FeatureController extends Controller
{
    // Get the first MobileBanner data
    public function show()
    {
        $feature = Feature::first();

        // Convert image fields to full URLs if available
        if ($feature) {
            foreach (['mbl_img1', 'mbl_img2', 'mbl_img3', 'mbl_img4'] as $imgField) {
                $feature->$imgField = $feature->$imgField ? url('uploads/features/' . $feature->$imgField) : null;
            }
        }

        return response()->json($feature);
    }

    // Store or update the first MobileBanner
    public function storeOrUpdate(Request $request)
    {
        $feature = Feature::first();

        // Prepare image data
        $imgFields = ['mbl_img1', 'mbl_img2', 'mbl_img3', 'mbl_img4'];
        $images = [];

        foreach ($imgFields as $field) {
            $existing = $feature->$field ?? null;
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/features'), $filename);
                $images[$field] = $filename;
            } else {
                $images[$field] = $existing;
            }
        }

        // Process other fields
        $data = [
            'title1' => $request->input('title1'),
            'title2' => $request->input('title2'),
            'all_mbl_img' => $request->input('all_mbl_img'),
        ] + $images;

        if ($feature) {
            $feature->update($data);
        } else {
            $feature = Feature::create($data);
        }

        // Return full image URLs
        foreach ($imgFields as $field) {
            $feature->$field = $feature->$field ? url('uploads/features/' . $feature->$field) : null;
        }

        return response()->json($feature);
    }
}
