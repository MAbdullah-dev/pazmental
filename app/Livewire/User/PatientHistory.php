<?php
namespace App\Livewire\User;

use Twilio;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\PatientPets;
use Illuminate\Http\Request;
use App\Models\PatientDetails;
use App\Models\Wordpress\User;
use Corcel\Model\Meta\PostMeta;
use Livewire\Attributes\Locked;
use Mary\Traits\Toast;
use App\Mail\QRScannedNotification;
use libphonenumber\PhoneNumberUtil;
use Illuminate\Support\Facades\Mail;
use Corcel\WooCommerce\Model\Product;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Log;

class PatientHistory extends Component
{
    use Toast;
    #[Locked]
    public $data;
    public $content;
    protected bool $is_pet = false;
    public int $pet_cat_id = 77;

    public $lat;
    public $lng;
    public $country_name;
    public $country_code;
    public $region_code;
    public $region_name;
    public $city;
    public $zip_code;

    protected $listeners = ['setLocation'];

    public function setLocation($locationData)
    {
        Log::info('setLocation called:', $locationData);
        $this->lat = $locationData['lat'] ?? null;
        $this->lng = $locationData['lng'] ?? null;
        $this->country_name = $locationData['country_name'] ?? null;
        $this->country_code = $locationData['country_code'] ?? null;
        $this->region_code = $locationData['region_code'] ?? null;
        $this->region_name = $locationData['region_name'] ?? null;
        $this->city = $locationData['city'] ?? null;
        $this->zip_code = $locationData['zip_code'] ?? null;
    }

    public function mount($data, Request $request)
    {
        Log::info('Raw GET:', $_GET);
        Log::info('Request URL:', [$request->fullUrl()]);
        Log::info('Query parameters:', $request->all());

        $data = base64_decode($data);
        $d_explode = explode(",", $data);

        if (count($d_explode) >= 3) {
            $email = $d_explode[0] ?? '';
            $timestamp = $d_explode[1];
            $date = Carbon::createFromTimestamp($timestamp)->toDateTimeString();
            $product_id = $d_explode[2];
        } elseif (count($d_explode) == 2) {
            $user_id = $d_explode[0] ?? '';
            $product_id = $d_explode[1] ?? '';
            $email = User::where('id', $user_id)->firstOrFail()->user_email;
        } else {
            return abort(404);
        }

        $product = Product::findOrFail($product_id);
        $phone_no = '';
        $user = User::where('user_email', $email)->firstOrFail();
        $userdata = PatientDetails::where('patient_id', $user->ID)->first();
        $useremrgemail = $userdata->allow_notification_emrg_email ?? false ? $userdata->emrg_email : null;
        $useremrgemail2 = $userdata->allow_notification_emrg_email2 ?? false ? $userdata->emrg_email2 : null;

        if (auth()->check() && auth()->user()->email != $email) {
            auth()->logout();
        }

        foreach ($user->meta as $metadata) {
            if ($metadata['meta_key'] == 'billing_phone') {
                $phone_no = $metadata['meta_value'];
            }
        }

        if (count($d_explode) >= 3) {
            if (Get_QR_Code($product_id, $user, $date) == null) {
                return abort(404);
            }
        }

        $isPetSubaccount = $user->meta->where('meta_key', 'subaccount_type')->where('meta_value', 'pet')->isNotEmpty();

        if ($product->categories()->where('term_id', $this->pet_cat_id)->first() != null || $isPetSubaccount) {
            $this->content = PatientPets::where('patient_id', $user->ID)->first();
            if ($this->content == null) {
                return redirect()->route('PatientPet', ['data' => base64_encode($user->ID), 'redirectionRoute' => base64_encode($data)]);
            }
            $this->is_pet = true;
        } else {
            $this->content = PatientDetails::where('patient_id', $user->ID)->first();
        }

        // Consolidated email notification logic
        $latitude = $this->lat ?? $request->query('lat');
        $longitude = $this->lng ?? $request->query('lng');
        if (!is_null($latitude) && !is_null($longitude) && !empty($latitude) && !empty($longitude)) {
            Log::info('Sending email notifications with location:', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'country_name' => $this->country_name,
                'country_code' => $this->country_code,
                'region_code' => $this->region_code,
                'region_name' => $this->region_name,
                'city' => $this->city,
                'zip_code' => $this->zip_code
            ]);
            $useremailprimary = str_replace(' ', '', $user->user_email);
            $useremrgemail = str_replace(' ', '', $useremrgemail ?? '');
            $useremrgemail2 = str_replace(' ', '', $useremrgemail2 ?? '');

            if (filter_var($useremailprimary, FILTER_VALIDATE_EMAIL)) {
                $this->sendEmailNotification($useremailprimary, $user->user_nicename, $request);
            }
            if ($useremrgemail && filter_var($useremrgemail, FILTER_VALIDATE_EMAIL)) {
                $this->sendEmailNotification($useremrgemail, $user->user_nicename, $request);
            }
            if ($useremrgemail2 && filter_var($useremrgemail2, FILTER_VALIDATE_EMAIL)) {
                $this->sendEmailNotification($useremrgemail2, $user->user_nicename, $request);
            }

            // Optionally send text notification
            $message = 'PazMental-Alerts: Hello ' . $user->user_nicename . ', Your QR code has been scanned recently in ' . ($this->city ?? 'unknown city') . ', ' . ($this->country_name ?? 'unknown country') . '. Check email for more details. Thank you!';
            // $this->sendTextNotification($phone_no, $message);
        } else {
            Log::info('Skipping email notification due to missing lat/lng', ['latitude' => $latitude, 'longitude' => $longitude]);
        }

        $this->toast(
            type: 'success',
            title: @translate('Screen captures and recordings are restricted.'),
            description: null,
            position: 'toast-bottom toast-start',
            icon: 'o-exclamation-circle',
            css: 'alert-white',
            timeout: 10000,
            redirectTo: null
        );
    }

    public function render()
    {
        $view = $this->is_pet ? 'livewire.pet-details' : 'livewire.user.medical-history';
        return view($view, ['content' => $this->content]);
    }

    public function sendTextNotification($phno, $message)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $numberProto = $phoneUtil->parse($phno, null);
            if ($phoneUtil->isValidNumber($numberProto)) {
                $formattedPhoneNumber = $phoneUtil->format($numberProto, PhoneNumberFormat::E164);
                Twilio::message($formattedPhoneNumber, $message);
            } else {
                session()->flash('error', 'Invalid phone number provided.');
            }
        } catch (NumberParseException $e) {
            session()->flash('error', 'Invalid phone number provided.');
        }
    }

    private function sendEmailNotification($email, $userName, $request)
    {
        $latitude = $this->lat ?? $request->query('lat');
        $longitude = $this->lng ?? $request->query('lng');
        Log::info('Using location data:', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'country_name' => $this->country_name,
            'country_code' => $this->country_code,
            'region_code' => $this->region_code,
            'region_name' => $this->region_name,
            'city' => $this->city,
            'zip_code' => $this->zip_code
        ]);

        if (is_null($latitude) || is_null($longitude) || empty($latitude) || empty($longitude)) {
            Log::info('Email not sent: Latitude or Longitude is missing.', [
                'email' => $email,
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
            return;
        }

        $userAgent = $request->header('User-Agent');
        $deviceInfo = "Device information: " . $userAgent;
        $ipAddress = $request->ip();
        if ($ipAddress === '127.0.0.1' || $ipAddress === '::1') {
            $ipAddress = '8.8.8.8';
        }

        $currentUserInfo = Location::get($ipAddress);
        Mail::to($email)->send(new QRScannedNotification(
            $userName,
            $deviceInfo,
            $ipAddress,
            $currentUserInfo,
            $latitude,
            $longitude,
            $this->country_name,
            $this->country_code,
            $this->region_code,
            $this->region_name,
            $this->city,
            $this->zip_code
        ));
    }
}
