<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MobileMockUp;
use Illuminate\Http\Request;

class MobileMockUpController extends Controller
{
    public function show()
    {
        $banner = MobileMockUp::first();

        // Optional: Generate full URL for images
        if ($banner) {
            foreach (['back_img', 'mbl_img1', 'mbl_img2'] as $imgField) {
                if ($banner->$imgField) {
                    $banner->$imgField = url('uploads/banners/' . $banner->$imgField);
                }
            }
        }

        return response()->json($banner);
    }

    public function storeOrUpdate(Request $request)
    {
        $banner = MobileMockUp::first();

        $data = $request->all();

        // Handle image uploads
        foreach (['back_img', 'mbl_img1', 'mbl_img2'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . "_{$field}." . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/banners'), $filename);
                $data[$field] = $filename;
            } elseif ($banner) {
                $data[$field] = $banner->$field; // keep old value if not updated
            }
        }

        if ($banner) {
            $banner->update($data);
        } else {
            $banner = MobileMockUp::create($data);
        }

        // Return full image URLs
        foreach (['back_img', 'mbl_img1', 'mbl_img2'] as $imgField) {
            if ($banner->$imgField) {
                $banner->$imgField = url('uploads/mobilemockup/' . $banner->$imgField);
            }
        }

        return response()->json($banner);
    }
}
