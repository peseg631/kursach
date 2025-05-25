<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show()
{
    $user = auth()->user();
    return view('profile.show', compact('user'));
}

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'] ?? null;

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Профиль обновлён!');
    }

    // Удалить отдельное поле
    public function destroyField($field)
    {
        $user = Auth::user();
        $allowed = ['phone']; // Разрешённые к удалению поля

        if (in_array($field, $allowed)) {
            $user->$field = null;
            $user->save();
            return redirect()->route('profile.edit')->with('success', 'Поле удалено.');
        }

        return redirect()->route('profile.edit')->with('error', 'Удаление этого поля запрещено.');
    }
}
