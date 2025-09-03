<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ServiceList;
use App\Models\ServiceCard;

class PagesController extends Controller
{
    public function cctv()
    {
        $cards = ServiceCard::where('page', 'cctv')->with('images')->orderBy('order')->get();
        return view('pages.cctv', compact('cards'));
    }

    public function electricity()
    {
        $cards = ServiceCard::where('page', 'electricity')->with('images')->orderBy('order')->get();
        return view('pages.electricity', compact('cards'));
    }

    public function fireAlarm()
    {
        $cards = ServiceCard::where('page', 'fire-alarm')->with('images')->orderBy('order')->get();
        return view('pages.fire_alarm', compact('cards'));
    }

    public function network()
    {
        $cards = ServiceCard::where('page', 'network')->with('images')->orderBy('order')->get();
        return view('pages.network', compact('cards'));
    }

    public function project()
    {
        $cards = ServiceCard::where('page', 'project')->with('images')->orderBy('order')->get();
        return view('pages.project', compact('cards'));
    }

    public function securityAlarm()
    {
        $cards = ServiceCard::where('page', 'security-alarm')->with('images')->orderBy('order')->get();
        return view('pages.security_alarm', compact('cards'));
    }

    public function showService($service)
    {
        $map = ServiceList::slugToView();

        $view = $map[$service] ?? null;

        if ($view && view()->exists($view)) {
            // Унифицированный рендер страниц услуг через /services/{slug}
            // Передаём $cards согласно slug, чтобы во вью не было ошибки Undefined $cards
            $cards = \App\Models\ServiceCard::where('page', $service)
                ->with('images')
                ->orderBy('order')
                ->get();
            return view($view, compact('cards'));
        }

        abort(404);
    }
}
