<?php

namespace App\Notifications;

use App\Models\Usaha;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanUsahaBaru extends Notification
{
    public function __construct(
        public Usaha $usaha,
        public string $message
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'usaha_id'   => $this->usaha->id,
            'nama_usaha'=> $this->usaha->nama_usaha,
            'status'    => $this->usaha->status,
            'message'   => $this->message,
        ];
    }
}

