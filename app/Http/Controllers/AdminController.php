<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    public function index()
    {
        $cameras = Camera::all();
        return view('auth.admin', compact('cameras'));
    }

    public function create()
    {
        return view('auth.admin-create-camera');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'rtsp_url' => 'required|string|max:255',
            'preview' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('preview')) {
            $data['preview'] = $request->file('preview')->store('previews', 'public');
        }

        Camera::create($data);

        Artisan::call('mediamtx:generate-config');

        return redirect()->route('admin.index')->with('success', 'Камера добавлена!');
    }

    public function destroy(Camera $camera)
    {
        $camera->delete();

        Artisan::call('mediamtx:generate-config');

        return redirect()->route('admin.index')->with('success', 'Камера удалена!');
    }
}
