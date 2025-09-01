{{-- Модальное окно --}}
<dialog id="deleteAccountModal" class="modal">
    <div class="modal-box">
        <h3 class="text-lg font-bold mb-2 text-gray-100">Удалить аккаунт?</h3>
        <p class="mb-4 text-gray-100">Вы уверены, что хотите удалить аккаунт? Это действие необратимо!</p>
        <div class="modal-action flex gap-3">
            <form method="dialog">
                <button class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 rounded px-4 py-1"
                    type="submit">Отмена</button>
            </form>
            <form action="{{ route('profile.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="btn bg-red-600 hover:bg-red-700 text-white rounded px-4 py-1 cursor-pointer">
                    Удалить
                </button>
            </form>
        </div>
    </div>
</dialog>
