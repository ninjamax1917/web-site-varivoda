<div class="max-w-xl mx-auto mt-10 bg-white dark:bg-gray-800 p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Добавить камеру</h2>
    <form action="{{ route('admin.cameras.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-200">Название</label>
            <input type="text" name="name"
                class="input input-bordered w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500"
                required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-200">RTSP URL</label>
            <input type="text" name="rtsp_url"
                class="input input-bordered w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500"
                required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-200">Превью (изображение)</label>
            <input type="file" name="preview"
                class="file-input file-input-bordered w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 focus:border-blue-500 focus:ring-blue-500">
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
</div>
