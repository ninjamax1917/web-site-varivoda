@if (auth()->user()->role === 'admin')
    <div class="mt-8">
        <div class="card bg-gray-200 dark:bg-gray-800 border border-gray-400 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-black dark:text-white">Админ-панель</h2>
                <ul class="menu bg-transparent text-black dark:text-white rounded-box">
                    <li>
                        <a href="{{ route('admin.index') }}" class="btn btn-sm btn-outline btn-primary w-fit">
                            Перейти в админ-панель
                        </a>
                    </li>
                    <li class="mt-2">
                        <a href="{{ route('auth.news.index') }}" class="btn btn-sm btn-outline btn-secondary w-fit">
                            Новости
                        </a>
                    </li>
                    {{-- Добавьте здесь другие админ-ссылки при необходимости --}}
                </ul>
            </div>
        </div>
    </div>
@endif
