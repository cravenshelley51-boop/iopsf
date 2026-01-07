<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    protected $google2fa;

    public function __construct(Google2FA $google2fa)
    {
        $this->google2fa = $google2fa;
    }

    public function showEnableForm()
    {
        $user = Auth::user();
        $secretKey = $this->google2fa->generateSecretKey();
        
        return view('settings.two-factor', [
            'secretKey' => $secretKey,
            'qrCode' => $this->google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $secretKey
            )
        ]);
    }

    public function enable(Request $request)
    {
        $request->validate([
            'secret' => 'required|string',
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();
        $valid = $this->google2fa->verifyKey($request->secret, $request->code);

        if ($valid) {
            $user->two_factor_secret = $request->secret;
            $user->two_factor_enabled = true;
            $user->save();

            return redirect()->route('profile.edit')
                ->with('status', 'two-factor-enabled');
        }

        return back()->withErrors(['code' => 'Invalid verification code.']);
    }

    public function disable(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();
        $valid = $this->google2fa->verifyKey($user->two_factor_secret, $request->code);

        if ($valid) {
            $user->two_factor_secret = null;
            $user->two_factor_enabled = false;
            $user->save();

            return redirect()->route('profile.edit')
                ->with('status', 'two-factor-disabled');
        }

        return back()->withErrors(['code' => 'Invalid verification code.']);
    }
} 