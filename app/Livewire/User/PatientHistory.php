<?php
//packages include
namespace App\Livewire\User;

use Twilio;
use Carbon\Carbon;
use Livewire\Component;
use App\Livewire\ErrorPage;
use App\Models\PatientPets;
use Illuminate\Http\Request;
use App\Models\PatientDetails;
use App\Models\Wordpress\Post;
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
Use Illuminate\Support\Facades\Log;

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

    protected $listeners = ['setLocation'];

    public function setLocation($lat, $lng)
    {
        Log::info('setLocation called with lat: ' . $lat . ' and lng: ' . $lng);
        $this->lat = $lat;
        $this->lng = $lng;
    }
    public function mount($data, Request $request)
    {
    Log::info('Raw GET:', $_GET);
    Log::info('Request URL:', [$request->fullUrl()]);
    Log::info('Query parameters:', $request->all());
        // dd($data);
        $data = base64_decode($data);

        $d_explode = explode(",", $data);

        if (count($d_explode) >= 3) {
            // Email address
            $email = $d_explode[0] ?? '';
            // Timestamp
            $timestamp = $d_explode[1];
            $date = Carbon::createFromTimestamp($timestamp);
            $date = $date->toDateTimeString();
            // Product ID
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
    dd($user);
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

        // dd($isPetSubaccount);

        if ($product->categories()->where('term_id', $this->pet_cat_id)->first() != null || $isPetSubaccount)  {
            $this->content = PatientPets::where('patient_id', $user->ID)->first();
            if($this->content == null) {
                return redirect()->route('PatientPet', ['data' => base64_encode($user->ID), 'redirectionRoute' => base64_encode($data)]);
            }
            $this->is_pet = true;
                $latitude =  $this->lat ?? $request->query('lat');
                $longitude = $this->lng ?? $request->query('lng');
                if (!is_null($latitude) && !is_null($longitude) && !empty($latitude) && !empty($longitude)) {
                    Log::info('Sending email notifications with lat/lng:', ['latitude' => $latitude, 'longitude' => $longitude]);
                    // Send email notifications only when parameters are present
                    $useremailprimary = str_replace(' ', '', $user->user_email);
                    $useremrgemail = str_replace(' ', '', $useremrgemail);
                    $useremrgemail2 = str_replace(' ', '', $useremrgemail2);

                    if (filter_var($useremailprimary, FILTER_VALIDATE_EMAIL)) {
                        $this->sendEmailNotification($useremailprimary, $user->display_name, $request);
                    }
                    if (filter_var($useremrgemail, FILTER_VALIDATE_EMAIL)) {
                        $this->sendEmailNotification($useremrgemail, $user->display_name, $request);
                    }
                    if (filter_var($useremrgemail2, FILTER_VALIDATE_EMAIL)) {
                        $this->sendEmailNotification($useremrgemail2, $user->display_name, $request);
                    }
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
        } else {
            $this->content = PatientDetails::where('patient_id', $user->ID)->first();
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

        // if ($this->content == null) {
        // dd("content null condition");

        //     if (env('DEFAULT_LANGUAGE') == 'es') {
        //         session()->flash('error', 'Paciente no encontrado o no tiene detalles Inicie sesión para agregar detalles');
        //     } else {
        //         session()->flash('error', 'Patient Not Fount Or Dont Have Details Please Login To Add Details');
        //     }
        //     $referer = 'true';
        //     redirect()
        //         ->route('login')
        //         ->with(['Referer' => $referer]);
        //     // return redirect('login')->route('login');
        // } else {
            // Send email notification check
            $message = 'PazMental-Alerts:
            Hello ' . $user->user_display_name . ', Your QR code has been scanned recently. Check email for more details. Thank you!';
            //$this->sendTextNotification($phone_no, $message);
            // Remove extra spaces or characters
            $useremailprimary = str_replace(' ', '', $user->user_email);
            $useremrgemail = str_replace(' ', '', $useremrgemail);
            $useremrgemail2 = str_replace(' ', '', $useremrgemail2);
            if (filter_var($useremailprimary, FILTER_VALIDATE_EMAIL)) {
                $this->sendEmailNotification($useremailprimary, $user->display_name, $request);
            }
            if (filter_var($useremrgemail, FILTER_VALIDATE_EMAIL)) {

                $this->sendEmailNotification($useremrgemail, $user->display_name, $request);
            }
            if (filter_var($useremrgemail2, FILTER_VALIDATE_EMAIL)) {
                $this->sendEmailNotification($useremrgemail2, $user->display_name, $request);
            }
        }
    // }

    public function render()
    {
        $view = $this->is_pet ? 'livewire.pet-details' : 'livewire.user.medical-history';

        return view($view, ['content' => $this->content]);
    }



    public function sendTextNotification($phno, $message)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $numberProto = $phoneUtil->parse($phno, null); // Assuming no specific country code
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
    Log::info('Using location data:', ['latitude' => $latitude, 'longitude' => $longitude]);

    if (is_null($latitude) || is_null($longitude) || empty($latitude) || empty($longitude)) {
        Log::info('Email not sent: Latitude or Longitude is missing.', ['email' => $email, 'latitude' => $latitude, 'longitude' => $longitude]);
        return;
    }

    $userAgent = $request->header('User-Agent');
    $deviceInfo = "Device information: " . $userAgent;
    $ipAddress = $request->ip();
    if ($ipAddress === '127.0.0.1' || $ipAddress === '::1') {
        $ipAddress = '8.8.8.8';
    }

    $currentUserInfo = Location::get($ipAddress);
    Mail::to($email)->send(new QRScannedNotification($userName, $deviceInfo, $ipAddress, $currentUserInfo, $latitude, $longitude));
}

}
