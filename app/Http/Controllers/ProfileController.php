<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }

    public function settings()
    {
        return view('auth.profile-setting');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Handle avatar-only upload (from the dropdown hidden form)
        if (
            $request->hasFile('avatar')
            && !$request->has('name')
            && !$request->has('email')
            && !$request->has('password')
            && !$request->has('password_confirmation')
        ) {

            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Remove previous avatar file if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $user->save();

            return redirect()->route('profile.settings')->with('success', 'Аватар обновлён!');
        }
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = \Illuminate\Support\Facades\Hash::make($data['password']);
        }

        if ($request->hasFile('avatar')) {
            // Remove previous avatar file if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Профиль обновлён!');
    }

    public function deleteAvatar(Request $request)
    {
        $user = auth()->user();
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
            $user->save();
        }
        return redirect()->route('profile')->with('success', 'Аватар удалён!');
    }

    // Новый метод для удаления аккаунта
    public function destroy(Request $request)
    {
        $user = auth()->user();
        auth()->logout();
        $user->delete();

        return redirect('/')->with('success', 'Аккаунт удалён!');
    }
}
