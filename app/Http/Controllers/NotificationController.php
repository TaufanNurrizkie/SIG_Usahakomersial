<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
public function read($id)
{
    $user = auth()->user();

    $notification = $user->notifications()
        ->where('id', $id)
        ->firstOrFail();

    // tandai sudah dibaca
    $notification->markAsRead();

    $usahaId = $notification->data['usaha_id'];

    // redirect berdasarkan role
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.usaha.show', $usahaId);
    }

    if ($user->hasRole('camat')) {
        return redirect()->route('camat.usaha.show', $usahaId);
    }

    // default: USER / PENGAJU
    return redirect()->route('user.usaha.show', $usahaId);
}

}
