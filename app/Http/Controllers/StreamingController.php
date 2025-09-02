<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;

class StreamingController extends Controller
{
    public function index()
    {
        $cameras = Camera::all();
        return view('streaming.cctv_city', compact('cameras'));
    }
}
