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
            'phone' => [
                'nullable',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/[^0-9+]/', '', $value);

                    // Проверяем начало номера
                    if (!preg_match('/^(\+7|8)/', $digits)) {
                        $fail('Номер должен начинаться с +7 или 8.');
                    }

                    // Проверяем длину номера (11 цифр с кодом)
                    if (strlen($digits) !== 11) {
                        $fail('Номер телефона должен содержать 11 цифр.');
                    }
                },
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($data['phone'])) {
            $phone = preg_replace('/[^0-9+]/', '', $data['phone']);
            if (strpos($phone, '8') === 0) {
                $phone = '+7' . substr($phone, 1);
            }
            $data['phone'] = $phone;
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'] ?? null;

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Профиль обновлён!');
    }
}
