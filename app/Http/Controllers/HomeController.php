<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CertificatesRepository;

class HomeController extends Controller
{
    public function index(CertificatesRepository $repo)
    {
        $certificates = $repo->list();
        return view('home', compact('certificates'));
    }
}
