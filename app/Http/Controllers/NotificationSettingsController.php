<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationSettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('settings.notifications', [
            'user' => $user,
            'settings' => $user->notificationSettings ?? [
                'email_notifications' => true,
                'withdrawal_notifications' => true,
                'security_notifications' => true,
            ]
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'withdrawal_notifications' => 'boolean',
            'security_notifications' => 'boolean',
        ]);

        $user = Auth::user();
        $user->notificationSettings = [
            'email_notifications' => $request->boolean('email_notifications'),
            'withdrawal_notifications' => $request->boolean('withdrawal_notifications'),
            'security_notifications' => $request->boolean('security_notifications'),
        ];
        $user->save();

        return redirect()->route('notifications.settings')
            ->with('status', 'notification-settings-updated');
    }
} 