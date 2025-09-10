<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query()->where('is_published', true)->with('images');

        $search = trim((string) $request->get('q'));
        $category = trim((string) $request->get('category'));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        if ($category !== '') {
            $query->where('category', $category);
        }

        $query->orderByDesc('published_at')->orderByDesc('id');

        $news = $query->paginate(9)->withQueryString();

        // категории из ServiceList для единообразия
        $categories = collect(\App\Services\ServiceList::all())->pluck('name');

        return view('news.index', compact('news', 'search', 'category', 'categories'));
    }

    public function show(string $slug)
    {
        $item = News::where('slug', $slug)
            ->where('is_published', true)
            ->with('images')
            ->firstOrFail();

        // Соседние для навигации
        $prev = News::where('is_published', true)
            ->where(function ($q) use ($item) {
                $q->where('published_at', '<', $item->published_at)
                    ->orWhere(function ($q2) use ($item) {
                        $q2->whereNull('published_at')->where('id', '<', $item->id);
                    });
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->first();

        $next = News::where('is_published', true)
            ->where(function ($q) use ($item) {
                $q->where('published_at', '>', $item->published_at)
                    ->orWhere(function ($q2) use ($item) {
                        $q2->whereNull('published_at')->where('id', '>', $item->id);
                    });
            })
            ->orderBy('published_at')
            ->orderBy('id')
            ->first();

        return view('news.show', compact('item', 'prev', 'next'));
    }
}
