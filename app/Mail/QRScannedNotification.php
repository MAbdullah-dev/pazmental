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
    public $locationInfo;
    public $latitude;
    public $longitude;
    public $country_name;
    public $country_code;
    public $region_code;
    public $region_name;
    public $city;
    public $zip_code;

    public function __construct(
        $userName,
        $deviceInfo,
        $ipAddress,
        $locationInfo,
        $latitude,
        $longitude,
        $country_name = null,
        $country_code = null,
        $region_code = null,
        $region_name = null,
        $city = null,
        $zip_code = null
    ) {
        $this->userName = $userName;
        $this->deviceInfo = $deviceInfo;
        $this->ipAddress = $ipAddress;
        $this->locationInfo = $locationInfo;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->country_name = $country_name;
        $this->country_code = $country_code;
        $this->region_code = $region_code;
        $this->region_name = $region_name;
        $this->city = $city;
        $this->zip_code = $zip_code;
    }

    public function build()
    {
        return $this->subject('QR Code Scanned Notification')
            ->view('emails.qr_scanned')
            ->with([
                'userName' => $this->userName,
                'deviceInfo' => $this->deviceInfo,
                'ipAddress' => $this->ipAddress,
                'locationInfo' => $this->locationInfo,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'country_name' => $this->country_name ?? 'Unknown',
                'country_code' => $this->country_code ?? 'Unknown',
                'region_code' => $this->region_code ?? 'Unknown',
                'region_name' => $this->region_name ?? 'Unknown',
                'city' => $this->city ?? 'Unknown',
                'zip_code' => $this->zip_code ?? 'Unknown',
            ]);
    }
}
