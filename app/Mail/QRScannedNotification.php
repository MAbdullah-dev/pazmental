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
    public $currentUserInfo;
    public $latitude;
    public $longitude;

    public function __construct($userName, $deviceInfo, $ipAddress, $currentUserInfo, $latitude, $longitude)
    {
        $this->userName = $userName;
        $this->deviceInfo = $deviceInfo;
        $this->ipAddress = $ipAddress;
        $this->currentUserInfo = $currentUserInfo;
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        // dd($userName, $deviceInfo, $ipAddress, $currentUserInfo);
    }

    public function build()
    {
        return $this->view('emails.qr-scanned')
            ->subject('Notificación de código QR escaneado');
    }
}
