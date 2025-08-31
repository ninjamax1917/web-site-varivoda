<div class="absolute bottom-8 right-4 z-10">
    <div class="dropdown dropdown-end lg:dropdown-center">
        <label tabindex="0"
            class="btn btn-circle cursor-pointer border-1 border-gray-500 flex items-center justify-center"
            title="Редактировать">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
        </label>
        <ul tabindex="0"
            class="dropdown-content menu bg-gray-100 dark:bg-gray-800 rounded-box z-1 w-52 p-1 shadow-sm mt-2 border border-gray-400 dark:border-gray-700">
            <li>
                <label for="avatar-upload" class="cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-700">Загрузить</label>
            </li>
            @if (auth()->user()->avatar)
                <li>
                    <form id="avatar-delete-form" action="{{ route('profile.avatar.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full text-left hover:bg-gray-300 dark:hover:bg-gray-700">Удалить</button>
                    </form>
                </li>
            @endif
        </ul>
        <form id="avatar-upload-form" action="{{ route('profile.update') }}" method="POST"
            enctype="multipart/form-data" class="hidden">
            @csrf
            @method('PUT')
            <input type="file" id="avatar-upload" name="avatar" accept="image/*" class="hidden"
                onchange="this.form.submit()">
        </form>
    </div>
</div>
