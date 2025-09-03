<?php

namespace App\Http\Controllers;

use App\Models\ServiceCard;
use App\Models\ServiceCardImage;
use Illuminate\Http\Request;
use App\Services\ServiceList;
use Illuminate\Support\Facades\Storage;

class ServiceCardController extends Controller
{
    public function index()
    {
        $cards = ServiceCard::with('images')->orderBy('page')->orderBy('order')->get();
        return view('auth.service_cards.index', compact('cards'));
    }

    public function create()
    {
        $pages = collect(ServiceList::all());
        return view('auth.service_cards.edit', [
            'card' => new ServiceCard(),
            'pages' => $pages,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'images' => 'array',
            'images.*.path' => 'nullable|string',
            'images.*.file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:8192',
            'images.*.alt' => 'nullable|string',
            'images.*.order' => 'nullable|integer|min:0',
        ]);

        $card = ServiceCard::create([
            'page' => $data['page'],
            'title' => $data['title'],
            'order' => $data['order'] ?? 0,
        ]);

        foreach (($request->input('images') ?? []) as $i => $img) {
            $file = $request->file("images.$i.file");
            $path = $img['path'] ?? null;
            if ($file) {
                $stored = $file->store('service-cards', 'public');
                $path = '/storage/' . $stored;
            }
            if (!$path) {
                // пропускаем пустые элементы
                continue;
            }
            $card->images()->create([
                'path' => $path,
                'alt' => $img['alt'] ?? null,
                'order' => $img['order'] ?? 0,
            ]);
        }

        return redirect()->route('auth.service_cards.index');
    }

    public function edit(ServiceCard $service_card)
    {
        $service_card->load('images');
        $pages = collect(ServiceList::all());
        return view('auth.service_cards.edit', [
            'card' => $service_card,
            'pages' => $pages,
        ]);
    }

    public function update(Request $request, ServiceCard $service_card)
    {
        $data = $request->validate([
            'page' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'images' => 'array',
            'images.*.id' => 'nullable|integer',
            'images.*.path' => 'nullable|string',
            'images.*.file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:8192',
            'images.*.alt' => 'nullable|string',
            'images.*.order' => 'nullable|integer|min:0',
        ]);

        $service_card->update([
            'page' => $data['page'],
            'title' => $data['title'],
            'order' => $data['order'] ?? 0,
        ]);

        // Синхронизация картинок
        $keepIds = [];
        foreach (($request->input('images') ?? []) as $i => $img) {
            $file = $request->file("images.$i.file");
            $path = $img['path'] ?? null;
            if (!empty($img['id'])) {
                $image = ServiceCardImage::find($img['id']);
                if ($image && $image->service_card_id === $service_card->id) {
                    if ($file) {
                        $stored = $file->store('service-cards', 'public');
                        $path = '/storage/' . $stored;
                    }
                    if ($path) {
                        $image->path = $path;
                    }
                    $image->alt = $img['alt'] ?? null;
                    $image->order = $img['order'] ?? 0;
                    $image->save();
                    $keepIds[] = $image->id;
                }
            } else {
                if ($file) {
                    $stored = $file->store('service-cards', 'public');
                    $path = '/storage/' . $stored;
                }
                if (!$path) {
                    continue;
                }
                $created = $service_card->images()->create([
                    'path' => $path,
                    'alt' => $img['alt'] ?? null,
                    'order' => $img['order'] ?? 0,
                ]);
                $keepIds[] = $created->id;
            }
        }
        $service_card->images()->whereNotIn('id', $keepIds)->delete();

        return redirect()->route('auth.service_cards.index');
    }

    public function destroy(ServiceCard $service_card)
    {
        $service_card->delete();
        return redirect()->route('auth.service_cards.index');
    }
}
