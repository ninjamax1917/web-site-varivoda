<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-1">Логин</label>
        <div
            class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-[#1A1A1D] px-4 py-3 text-gray-700 dark:text-gray-300 select-text">
            {{ auth()->user()->name }}
        </div>
        <input type="hidden" name="name" value="{{ auth()->user()->name }}">
        <p class="mt-1 text-xs text-gray-500">Изменение логина и email недоступно.</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-1">Email</label>
        <div
            class="w-full rounded-xl border border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-[#1A1A1D] px-4 py-3 text-gray-700 dark:text-gray-300 select-text">
            {{ auth()->user()->email }}
        </div>
        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
    </div>
    <div>
        <label for="password" class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-1">Новый
            пароль</label>
        <input type="password" id="password" name="password" @class([
            'w-full rounded-xl border bg-white dark:bg-[#1A1A1D] px-4 py-3 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:border-[#51A3FF] transition',
            'border-red-500 dark:border-red-500' => $errors->has('password'),
            'border-gray-300 dark:border-white/10' => !$errors->has('password'),
        ]) />
        @error('password')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="password_confirmation"
            class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-1">Подтвердите новый
            пароль</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
            class="w-full rounded-xl border bg-white dark:bg-[#1A1A1D] px-4 py-3 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:border-[#51A3FF] transition border-gray-300 dark:border-white/10" />
    </div>
    <div class="flex flex-col gap-3 mt-6">
        <button type="submit"
            class="btn-glow w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-[#51A3FF] bg-white text-gray-900 dark:bg-[#232325] dark:text-gray-100 hover:bg-[#F0F7FF] dark:hover:bg-[#232325] hover:border-[#51A3FF] shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-[#51A3FF] focus:ring-offset-2 dark:focus:ring-offset-[#18181B] transition font-semibold cursor-pointer">
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
                class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-gray-300 dark:border-white/10 bg-white text-gray-900 dark:bg-[#232325] dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-[#232325] shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 dark:focus:ring-offset-[#18181B] transition font-semibold cursor-pointer">
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
                class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-red-500/80 bg-white text-red-700 dark:bg-[#232325] dark:text-red-300 hover:bg-red-50 dark:hover:bg-[#232325] shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-red-400/60 focus:ring-offset-2 dark:focus:ring-offset-[#18181B] transition font-semibold cursor-pointer"
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
