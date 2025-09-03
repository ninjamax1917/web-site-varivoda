@extends('layouts.app')

@section('title', 'Добавить камеру')

@section('content')
    <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Добавить камеру</h1>
        <form action="{{ route('admin.cameras.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-1 font-semibold">Название</label>
                <input type="text" name="name" class="input input-bordered w-full" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold">RTSP URL</label>
                <input type="text" name="rtsp_url" class="input input-bordered w-full" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Превью (изображение)</label>
                <input type="file" name="preview" class="file-input file-input-bordered w-full">
            </div>
            <div class="flex gap-2">
                <button class="btn btn-primary">Сохранить</button>
                <a class="btn" href="{{ route('admin.index') }}">Отмена</a>
            </div>
        </form>
    </div>
@endsection
