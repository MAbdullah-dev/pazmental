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
    protected bool $is_pet = false;
    public int $pet_cat_id = 77;

    protected $listeners = [
        'sendEmailNow' => 'sendEmailNow',
    ];

    public $user;
    public $userdata;
    public $useremrgemail;
    public $useremrgemail2;
    public $locationObtained = false;


    public function mount($data)
    {
        $this->loaddata($data);
    }
    public function loaddata($data)
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
            $product_id = $d_explode[1] ?? '';
            $email = User::where('id', $user_id)->firstOrFail()->user_email;
        } else {
            abort(404);
        }

        $product = Product::findOrFail($product_id);
        $this->user = User::where('user_email', $email)->firstOrFail();
        $this->userdata = PatientDetails::where('patient_id', $this->user->ID)->first();

        $isPetSubaccount = $this->user->meta->where('meta_key', 'subaccount_type')->where('meta_value', 'pet')->isNotEmpty();
// dd(session()->all());
                if ($isPetSubaccount) {
            $meta = $this->user->meta
                ->where('meta_key', 'subaccount_type')
                ->where('meta_value', 'pet')
                ->first();

            session([
                'petSubAcc' => [
                    'meta_key' => $meta->meta_key,
                    'meta_value' => $meta->meta_value,
                ]
            ]);
        } else {
            session()->forget('petSubAcc');
        }

        if ($this->userdata) {
        $this->useremrgemail = $this->userdata->allow_notification_emrg_email ? $this->userdata->emrg_email : null;
        $this->useremrgemail2 = $this->userdata->allow_notification_emrg_email2 ? $this->userdata->emrg_email2 : null;
        }
        if (auth()->check() && auth()->user()->email != $email) {
            auth()->logout();
        }

        if (count($d_explode) >= 3 && Get_QR_Code($product_id, $this->user, $date) == null) {
            abort(404);
        }

        if ($product->categories()->where('term_id', $this->pet_cat_id)->first() != null || $isPetSubaccount) {
            // dd($isPetSubaccount);
            $this->content = PatientPets::where('patient_id', $this->user->ID)->first();
            $this->is_pet = true;
        } else {
            $this->content = PatientDetails::where('patient_id', $this->user->ID)->first();
        }

        if ($this->content == null) {
            session()->flash('error', __('Patient Not Found Or Don\'t Have Details. Please login to add details.'));
            return redirect()->route('login')->with('Referer', 'true');
        } else {
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
    }
    public function render()
    {
        if (session('user_location')) {
        $this->locationObtained = true;
        }else{
            $this->locationObtained = false;
        }
        // dd($this->content);
        $view = $this->is_pet ? 'livewire.pet-details' : 'livewire.user.medical-history';
        return view($view, ['content' => $this->content]);
    }

    public function sendEmailNow()
    {
        $useremailprimary = str_replace(' ', '', $this->user->user_email);
        $useremrgemail = str_replace(' ', '', $this->useremrgemail);
        $useremrgemail2 = str_replace(' ', '', $this->useremrgemail2);

        // Always prioritize sending to primary email first
        $emails = array_filter([
            $useremailprimary,
            $useremrgemail,
            $useremrgemail2,
        ]);

        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->sendEmailNotification($email, $this->user->user_nicename);
            }
        }
    }

    private function sendEmailNotification($email, $userName)
    {
        $userAgent = request()->header('User-Agent');
        $deviceInfo = "Device information: " . $userAgent;
        $ipAddress = request()->ip();

        if ($ipAddress === '127.0.0.1' || $ipAddress === '::1') {
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
}
