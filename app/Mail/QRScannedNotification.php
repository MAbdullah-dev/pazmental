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

    public function __construct($userName, $deviceInfo, $ipAddress, $currentUserInfo, $latitude, $longitude, $city, $countryCode)
    {
        $this->userName = $userName;
        $this->deviceInfo = $deviceInfo;
        $this->ipAddress = $ipAddress;
        $this->currentUserInfo = $currentUserInfo;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->city = $city;
        $this->countryCode = $countryCode;

        dd($this->latitude, $this->longitude, $this->city, $this->countryCode);
    }

    public function build()
    {
        return $this->view('emails.qr-scanned')
            ->subject('Notificación de código QR escaneado');
    }
}
