<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileService $profileService
    ) {}

    public function show(): View
    {
        return view('profile.show', [
            'user' => auth()->user()
        ]);
    }

    public function edit(): View
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile(
            $request->user(),
            $request->validated()
        );

        return redirect()->route('profile.show')
            ->with('success', 'Профиль обновлён!');
    }
}
