<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PUT')
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Имя</label>
        <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required
            class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('name') border-red-500 dark:border-red-500 @enderror" />
        @error('name')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
            class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('email') border-red-500 dark:border-red-500 @enderror" />
        @error('email')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Новый
            пароль</label>
        <input type="password" id="password" name="password"
            class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('password') border-red-500 dark:border-red-500 @enderror" />
        @error('password')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="password_confirmation"
            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Подтвердите новый
            пароль</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
            class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
    </div>
    <div class="flex flex-col gap-3 mt-6">
        <button type="submit"
            class="w-full flex items-center justify-center gap-2 py-1.5 px-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded transition cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-save-icon lucide-save">
                <path
                    d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                <path d="M7 3v4a1 1 0 0 0 1 1h7" />
            </svg>
            Сохранить
        </button>
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-1.5 px-3 bg-gray-600 hover:bg-gray-800 dark:hover:bg-gray-500 text-white font-semibold rounded transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-log-out-icon lucide-log-out">
                    <path d="m16 17 5-5-5-5" />
                    <path d="M21 12H9" />
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                </svg>
                Выйти из аккаунта
            </button>
        </form>
        @if (auth()->user()->role !== 'admin')
            <!-- Кнопка для открытия модального окна (для не-админов) -->
            <button type="button"
                class="w-full flex items-center justify-center gap-2 py-1.5 px-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded transition cursor-pointer"
                onclick="document.getElementById('deleteAccountModal').showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-trash2-icon lucide-trash-2">
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                    <path d="M3 6h18" />
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                </svg>
                Удалить аккаунт
            </button>
        @endif
    </div>
    @if (auth()->user()->role !== 'admin')
        @include('auth.components-setting.modal-delete-account')
    @endif
