<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsAdminController extends Controller
{
    public function index()
    {
        $items = News::orderByDesc('published_at')->orderByDesc('id')->paginate(20);
        return view('auth.news.index', compact('items'));
    }

    public function create()
    {
        $categories = collect(\App\Services\ServiceList::all())->pluck('name');
        return view('auth.news.edit', ['news' => new News(), 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $base = $request->input('slug') ?: $request->input('title');
        $data['slug'] = $this->makeUniqueSlug($base);
        if ($request->hasFile('cover_image_file')) {
            $stored = $request->file('cover_image_file')->store('news', 'public');
            $data['cover_image'] = '/storage/' . $stored;
        } else {
            // Без URL — просто не ставим обложку
            unset($data['cover_image']);
        }

        if (!empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        $news = News::create($data);
        // gallery
        foreach ($request->file('gallery', []) as $i => $file) {
            if (!$file) continue;
            $stored = $file->store('news', 'public');
            $news->images()->create([
                'path' => '/storage/' . $stored,
                'alt' => $request->input("gallery_meta.$i.alt") ?: null,
                'order' => (int) ($request->input("gallery_meta.$i.order") ?? $i),
            ]);
        }
        return redirect()->route('auth.news.edit', $news)->with('status', 'Создано');
    }

    public function edit(News $news)
    {
        $news->load('images');
        $categories = collect(\App\Services\ServiceList::all())->pluck('name');
        return view('auth.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $data = $this->validated($request, $news->id);
        // Не меняем slug при обновлении, чтобы не ломать ссылки
        $data['slug'] = $news->slug;
        if ($request->hasFile('cover_image_file')) {
            $stored = $request->file('cover_image_file')->store('news', 'public');
            $data['cover_image'] = '/storage/' . $stored;
        } else {
            // если URL больше не используем, не трогаем cover_image
            unset($data['cover_image']);
        }

        if (!empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        $news->update($data);

        $keepIds = [];
        $existing = $news->images()->get()->keyBy('id');
        foreach ((array) $request->file('gallery', []) as $i => $file) {
            if ($file) {
                $stored = $file->store('news', 'public');
                $img = $news->images()->create([
                    'path' => '/storage/' . $stored,
                    'alt' => $request->input("gallery_meta.$i.alt") ?: null,
                    'order' => (int) ($request->input("gallery_meta.$i.order") ?? $i),
                ]);
                $keepIds[] = $img->id;
            }
        }
        foreach ((array) $request->input('existing_gallery', []) as $idx => $row) {
            $id = (int) ($row['id'] ?? 0);
            if ($id && isset($existing[$id])) {
                $existing[$id]->alt = $row['alt'] ?? null;
                $existing[$id]->order = (int) ($row['order'] ?? 0);
                $existing[$id]->save();
                $keepIds[] = $id;
            }
        }
        $news->images()->whereNotIn('id', $keepIds)->delete();
        return redirect()->route('auth.news.edit', $news)->with('status', 'Обновлено');
    }

    public function destroy(News $news)
    {
        // Жесткое удаление
        $news->forceDelete();
        return redirect()->route('auth.news.index')->with('status', 'Удалено');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'category' => 'nullable|string|max:100',
            'cover_image' => 'nullable|string|max:500', // оставляем для совместимости, но поле в форме скрыто
            'cover_image_file' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:8192',
            'gallery' => 'nullable|array|max:5',
            'gallery.*' => 'image|mimes:jpeg,jpg,png,webp,gif|max:8192',
            'existing_gallery' => 'array',
            'existing_gallery.*.id' => 'integer',
            'existing_gallery.*.alt' => 'nullable|string',
            'existing_gallery.*.order' => 'nullable|integer|min:0',
            'is_published' => 'sometimes|boolean',
            'published_at' => 'nullable|date',
        ];
        $data = $request->validate($rules);
        // Исключаем технические поля, которые не хранятся в таблице news
        unset($data['cover_image_file'], $data['gallery'], $data['existing_gallery']);
        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        return $data;
    }

    private function makeUniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = Str::slug($base) ?: 'news';
        $original = $slug;
        $i = 2;
        while (\App\Models\News::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $original . '-' . $i;
            $i++;
            if ($i > 1000) { // на всякий случай, чтобы не зациклиться
                $slug = $original . '-' . Str::random(6);
                break;
            }
        }
        return $slug;
    }
}
