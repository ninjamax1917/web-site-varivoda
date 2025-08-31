<div class="mt-6 text-center">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
            class="w-full py-2 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition">
            Выйти из аккаунта
        </button>
    </form>
</div>