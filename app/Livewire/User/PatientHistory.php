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
use Illuminate\Support\Facades\Log;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;
use Stevebauman\Location\Facades\Location;

class PatientHistory extends Component
{
    use Toast;
    #[Locked]
    public $data;
    public $content;
    protected bool $is_pet = false;
    public int $pet_cat_id = 77;

    public function mount($data, Request $request)
    {


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
        if ($product->categories()->where('term_id', $this->pet_cat_id)->first() != null) {
            $this->content = PatientPets::where('patient_id', $user->ID)->first();
                        dd("here");
            $this->is_pet = true;
            $this->toast(
                type: 'success',
                title: @translate('Screen captures and recordings are restricted.'),
                description: null,
                position: 'toast-bottom toast-start',
                icon: 'o-exclamation-circle', // Updated icon to exclamation mark
                css: 'alert-white', // Updated background to white
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
                icon: 'o-exclamation-circle', // Updated icon to exclamation mark
                css: 'alert-white', // Updated background to white
                timeout: 10000,
                redirectTo: null
            );
        }

        if ($this->content == null) {
            if (env('DEFAULT_LANGUAGE') == 'es') {
                session()->flash('error', 'Paciente no encontrado o no tiene detalles Inicie sesión para agregar detalles');
            } else {
                session()->flash('error', 'Patient Not Fount Or Dont Have Details Please Login To Add Details');
            }
            $referer = 'true';
            redirect()
                ->route('login')
                ->with(['Referer' => $referer]);
            // return redirect('login')->route('login');
        } else {
            // Send email notification check
            $message = 'PazMental-Alerts:
            Hello ' . $user->user_nicename . ', Your QR code has been scanned recently. Check email for more details. Thank you!';
            //$this->sendTextNotification($phone_no, $message);
            // Remove extra spaces or characters
            $useremailprimary = str_replace(' ', '', $user->user_email);
            $useremrgemail = str_replace(' ', '', $useremrgemail);
            $useremrgemail2 = str_replace(' ', '', $useremrgemail2);
            if (filter_var($useremailprimary, FILTER_VALIDATE_EMAIL)) {
                $this->sendEmailNotification($useremailprimary, $user->user_nicename, $request);
            }
            if (filter_var($useremrgemail, FILTER_VALIDATE_EMAIL)) {

                $this->sendEmailNotification($useremrgemail, $user->user_nicename, $request);
            }
            if (filter_var($useremrgemail2, FILTER_VALIDATE_EMAIL)) {
                $this->sendEmailNotification($useremrgemail2, $user->user_nicename, $request);
            }
        }
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
        $userAgent = $request->header('User-Agent');
        $deviceInfo = "Device information: " . $userAgent;
        $ipAddress = $request->ip();

        if ($ipAddress === '127.0.0.1' || $ipAddress === '::1') {
            $ipAddress = '8.8.8.8';
        }

        $latitude = $request->query('lat');
        $longitude = $request->query('lng');

        // Check if latitude or longitude is null or empty, and stop execution if so
        if (is_null($latitude) || is_null($longitude) || empty($latitude) || empty($longitude)) {
            Log::info('Email not sent: Latitude or Longitude is missing.', [
                'email' => $email,
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
            return; // Exit the function early
        }

        $currentUserInfo = Location::get($ipAddress);

        Mail::to($email)->send(new QRScannedNotification($userName, $deviceInfo, $ipAddress, $currentUserInfo, $latitude, $longitude));
    }
}
