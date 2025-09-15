<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsPageController extends Controller
{
    public function index()
    {
        return view('tools_page.index');
    }
}