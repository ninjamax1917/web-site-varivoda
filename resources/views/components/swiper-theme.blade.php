<div x-data="{
    isDark: document.documentElement.classList.contains('dark'),
    toggle() {
        this.isDark = !this.isDark;
        document.documentElement.classList.toggle('dark', this.isDark);
        try { localStorage.setItem('theme', this.isDark ? 'dark' : 'light'); } catch (e) {}
    }
}" class="flex justify-center">
    <button @click="toggle()" type="button"
        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-md hover:shadow-lg transition-shadow">
        <svg x-show="!isDark" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4.22 2.03a1 1 0 011.415 1.414l-.708.708a1 1 0 11-1.414-1.414l.707-.708zM17 9a1 1 0 110 2h-1a1 1 0 110-2h1zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zm9.927 5.364a1 1 0 10-1.414 1.414l.707.708a1 1 0 001.415-1.415l-.708-.707zM10 15a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM4.393 4.444a1 1 0 10-1.415 1.414l.708.708A1 1 0 105.1 5.152l-.707-.708zM4.757 15.657a1 1 0 001.415-1.415l-.708-.707a1 1 0 00-1.414 1.414l.707.708zM10 6a4 4 0 100 8 4 4 0 000-8z" />
        </svg>
        <svg x-show="isDark" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.293 13.293A8 8 0 016.707 2.707 8.001 8.001 0 1017.293 13.293z" />
        </svg>
    </button>
</div>
