<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ServiceList;

class PagesController extends Controller
{
    public function cctv()
    {
        return view('pages.cctv');
    }

    public function electricity()
    {
        return view('pages.electricity');
    }

    public function fireAlarm()
    {
        return view('pages.fire_alarm');
    }

    public function network()
    {
        return view('pages.network');
    }

    public function project()
    {
        return view('pages.project');
    }

    public function securityAlarm()
    {
        return view('pages.security_alarm');
    }

    public function showService($service)
    {
        $map = ServiceList::slugToView();

        $view = $map[$service] ?? null;

        if ($view && view()->exists($view)) {
            return view($view);
        }

        abort(404);
    }
}
