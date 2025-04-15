<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Feature;
use App\Models\Footer;
use App\Models\Header;

class FrontendController extends Controller
{
    public function getAllData()
    {
        $data = [
            'home' => Banner::all(),
            'feature' => Feature::all(),
            'footer' => Footer::all(),
            'header' => Header::all(),
            
        ];

        return response()->json($data);
    }
}
