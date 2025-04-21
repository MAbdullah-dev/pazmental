<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QRScannedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $deviceInfo;
    public $ipAddress;
    public $locationData;

    public function __construct($userName, $deviceInfo, $ipAddress)
    {
        $this->userName = $userName;
        $this->deviceInfo = $deviceInfo;
        $this->ipAddress = $ipAddress;

        $sessionLocation = session('user_location', []);

        $this->locationData = [
            'lat' => $sessionLocation['lat'] ?? null,
            'lng' => $sessionLocation['lng'] ?? null,
            'city' => $sessionLocation['city'] ?? null,
            'country' => $sessionLocation['country'] ?? null,
        ];
    }

    public function build()
    {
        return $this->view('emails.qr-scanned')
                    ->subject('Notificación de código QR escaneado');
    }
}
