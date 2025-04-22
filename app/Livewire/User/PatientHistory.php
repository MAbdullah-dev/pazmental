<?php

namespace App\Livewire\User;

use Twilio;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\PatientPets;
use App\Models\PatientDetails;
use App\Models\Wordpress\Post;
use App\Models\Wordpress\User;
use Corcel\Model\Meta\PostMeta;
use Mary\Traits\Toast;
use App\Mail\QRScannedNotification;
use Illuminate\Support\Facades\Mail;
use Corcel\WooCommerce\Model\Product;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Log;

class PatientHistory extends Component
{
    use Toast;

    #[Locked]
    public $data;
    public $content;
    public $user;
    public $userdata;
    public $useremrgemail;
    public $useremrgemail2;
    public $locationObtained = false;
    public bool $is_pet = false;
    public int $pet_cat_id = 77;

    protected $listeners = [
        'sendEmailNow' => 'sendEmailNow',
    ];

    public function mount($data)
    {
        $data = base64_decode($data);
        $d_explode = explode(",", $data);

        if (count($d_explode) >= 3) {
            $email = $d_explode[0] ?? '';
            $timestamp = $d_explode[1];
            $date = Carbon::createFromTimestamp($timestamp)->toDateTimeString();
            $product_id = $d_explode[2];
        } elseif (count($d_explode) == 2) {
            $user_id = $d_explode[0] ?? '';
            $product_id = $d_explode[1];
            $email = User::where('id', $user_id)->firstOrFail()->user_email;
        } else {
            abort(404);
        }

        $product = Product::findOrFail($product_id);
        $this->user = User::where('user_email', $email)->firstOrFail();
        $this->userdata = PatientDetails::where('patient_id', $this->user->ID)->first();

        if (auth()->check() && auth()->user()->email != $email) {
            auth()->logout();
        }

        $this->handleSubaccountSession();

        if (count($d_explode) >= 3 && Get_QR_Code($product_id, $this->user, $date) == null) {
            abort(404);
        }

        $this->loadContent();

        if ($this->content == null) {
            session()->flash('error', __('Patient Not Found Or Don\'t Have Details. Please login to add details.'));
            return redirect()->route('login')->with('Referer', 'true');
        }

        $this->setupEmergencyEmails();

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
        $this->locationObtained = session('user_location') ? true : false;
        $view = $this->is_pet ? 'livewire.pet-details' : 'livewire.user.medical-history';

        return view($view, ['content' => $this->content]);
    }

    public function sendEmailNow()
    {
        $emails = array_filter([
            str_replace(' ', '', $this->user->user_email),
            str_replace(' ', '', $this->useremrgemail),
            str_replace(' ', '', $this->useremrgemail2),
        ]);

        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->sendEmailNotification($email, $this->user->user_nicename);
            }
        }

        // Reload content after action
        $this->loadContent();
        $this->dispatch('$refresh');
    }

    private function sendEmailNotification($email, $userName)
    {
        $userAgent = request()->header('User-Agent');
        $deviceInfo = "Device information: " . $userAgent;
        $ipAddress = request()->ip();

        if (in_array($ipAddress, ['127.0.0.1', '::1'])) {
            $ipAddress = '8.8.8.8'; // fallback for localhost
        }

        Log::info('Sending email to: ' . $email);

        try {
            Mail::to($email)->send(new QRScannedNotification($userName, $deviceInfo, $ipAddress));
            Log::info('Email successfully sent to: ' . $email);
        } catch (\Exception $e) {
            Log::error('Failed to send email to: ' . $email . '. Error: ' . $e->getMessage());
        }
    }

    private function loadContent()
    {
        if (!$this->user) {
            return;
        }

        $isPetSubaccount = $this->user->meta
            ->where('meta_key', 'subaccount_type')
            ->where('meta_value', 'pet')
            ->isNotEmpty();

        $this->is_pet = $isPetSubaccount || ($this->user->products()->where('term_id', $this->pet_cat_id)->exists());

        if ($this->is_pet) {
            $this->content = PatientPets::where('patient_id', $this->user->ID)->first();
        } else {
            $this->content = PatientDetails::where('patient_id', $this->user->ID)->first();
        }
    }

    private function handleSubaccountSession()
    {
        $isPetSubaccount = $this->user->meta
            ->where('meta_key', 'subaccount_type')
            ->where('meta_value', 'pet')
            ->isNotEmpty();

        if ($isPetSubaccount) {
            $meta = $this->user->meta
                ->where('meta_key', 'subaccount_type')
                ->where('meta_value', 'pet')
                ->first();

            session([
                'petSubAcc' => [
                    'meta_key' => $meta->meta_key,
                    'meta_value' => $meta->meta_value,
                ],
            ]);
        } else {
            session()->forget('petSubAcc');
        }
    }

    private function setupEmergencyEmails()
    {
        if ($this->userdata) {
            $this->useremrgemail = $this->userdata->allow_notification_emrg_email
                ? $this->userdata->emrg_email
                : null;

            $this->useremrgemail2 = $this->userdata->allow_notification_emrg_email2
                ? $this->userdata->emrg_email2
                : null;
        }
    }
}
