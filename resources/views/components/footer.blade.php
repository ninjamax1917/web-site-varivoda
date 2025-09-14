<footer class="relative bg-gray-100 dark:bg-[#161617] text-gray-700 dark:text-gray-300 py-8 mt-8 shadow-inner">
    <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8 flex flex-col items-center gap-4">
        <!-- Соцсети по центру -->
        @include('components.partials.footer.social-links')
        <!-- Текст по центру под иконками -->
        <div class="text-sm text-center">
            © {{ date('Y') }} — Все права защищены. <span class="font-fira-mono font-poppins text-blue-500 font-semibold">VARIVODA</span>
            <div class="mt-1 text-sm text-gray-600 dark:text-gray-400 flex items-center justify-center gap-2">
                <span class="font-mono text-gray-700 dark:text-gray-300">&lt;/&gt;</span>
                <span>Разработка:</span>
                <a href="https://t.me/+79182547147" class="text-blue-600 dark:text-blue-400 hover:text-red-500 transition duration-200" rel="noopener"
                    target="_blank">ninjamax</a>
            </div>
        </div>

        <!-- Политика конфиденциальности -->
        <div class="text-xs text-center text-gray-600 dark:text-gray-400">
            Используя этот сайт, вы принимаете
            <a href="{{ route('policy') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Политику
                конфиденциальности</a>.
        </div>
    </div>
</footer>
