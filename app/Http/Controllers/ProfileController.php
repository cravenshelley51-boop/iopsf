<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // Handle PIN change if provided
        if ($request->filled(['current_pin', 'new_pin', 'new_pin_confirmation'])) {
            // Validate PIN format
            $request->validate([
                'current_pin' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
                'new_pin' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/', 'different:current_pin'],
                'new_pin_confirmation' => ['required', 'string', 'same:new_pin'],
            ]);

            // Verify current PIN
            if ($request->current_pin !== $request->user()->pin_code) {
                return back()->withErrors(['current_pin' => 'The current PIN is incorrect.']);
            }

            // Update PIN
            $request->user()->pin_code = $request->new_pin;
            $request->user()->pin_changed = true;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updatePin(Request $request)
    {
        $request->validate([
            'current_pin' => ['required', 'string', 'size:4'],
            'new_pin' => ['required', 'string', 'size:4', 'different:current_pin'],
            'new_pin_confirmation' => ['required', 'string', 'same:new_pin'],
        ]);

        $user = $request->user();

        // Verify current PIN
        if ($user->pin_code !== $request->current_pin) {
            return back()->withErrors(['current_pin' => 'The current PIN is incorrect.'], 'updatePin');
        }

        // Update PIN
        $user->update([
            'pin_code' => $request->new_pin,
            'pin_changed' => true
        ]);

        return back()->with('status', 'pin-updated');
    }
}
