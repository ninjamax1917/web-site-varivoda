<footer class="relative bg-gray-100 dark:bg-[#161617] text-gray-700 dark:text-gray-300 px-4 py-8 mt-8 shadow-inner">
    <div class="max-w-4xl mx-auto flex flex-col items-center gap-4">
        <!-- Соцсети по центру -->
        @include('components.partials.footer.social-links')
        <!-- Текст по центру под иконками -->
        <div class="text-sm text-center">
            © {{ date('Y') }} — Все права защищены. <span class="text-blue-500 font-semibold">Varivoda</span>
        </div>
    </div>
</footer>
