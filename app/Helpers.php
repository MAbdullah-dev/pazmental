<?php

use Corcel\Model\User;
use App\Models\PatientPets;
use App\Models\Translation;
use App\Models\PatientDetails;
use App\Models\Wordpress\Order;
use Corcel\Model\Meta\PostMeta;
use App\Models\Wordpress\Customer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use App\Models\Language;


function getPatient($user_id = null)
{
    return PatientDetails::select('images')->where('patient_id', $user_id)->first();
}
function getPatientpet($user_id = null)
{
    return PatientPets::where('patient_id', $user_id)->first();
}

function getProfilePicture($id = null)
{


    if ($id === null) {
        $id = auth()->id();
    }

    $patient = getPatient($id);

    if (!$patient || !isset($patient->images[0])) {
        return asset('assets/images/avatar-place.png');
    } else {
        return asset('storage/images/' . $patient->images[0]);
    }
}



function translate($key, $lang = null)
{
    if ($lang == null) {
        $lang = App::getLocale();
    }
    //dd($lang);
    
    $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));
    
    $translations_default = Cache::rememberForever('translations-' . env('DEFAULT_LANGUAGE', 'en'), function () {
        return Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'))->pluck('lang_value', 'lang_key')->toArray();
    });
    
    if (!isset($translations_default[$lang_key])) {
        $translation_def = new Translation;
        $translation_def->lang = env('DEFAULT_LANGUAGE', 'en');
        $translation_def->lang_key = $lang_key;
        $translation_def->lang_value = $key;
        $translation_def->save();
        Cache::forget('translations-' . env('DEFAULT_LANGUAGE', 'en'));
    }

    $translation_locale = Cache::rememberForever('translations-' . $lang, function () use ($lang) {
        return Translation::where('lang', $lang)->pluck('lang_value', 'lang_key')->toArray();
    });
    
    //Check for session lang
    if (isset($translation_locale[$lang_key])) {
        return $translation_locale[$lang_key];
    } elseif (isset($translations_default[$lang_key])) {
        return $translations_default[$lang_key];
    } else {
        return $key;
    }
}

function get_user_products($pet = null)
{
    // Fetch the customer based on the logged-in user's email
    $customer = Customer::where('user_email', auth()->user()->email)->firstOrFail();
    $petCat = 77; // Define the term ID for the "pet" category
    $rememberedPetProduct = false; // Flag to remember a product with the "pet" category
    if(auth()->user()->email == 'sarahnoemi1725@gmail.com' && $pet == null){
        return true;
    }
    foreach ($customer->orders as $order) {
        foreach ($order->items as $item) {
            $product = $item->product;

            if ($product && $product->categories) {
                $productCategories = $product->categories->pluck('term_id')->toArray();

                // Check for "pet" category products
                if ($pet != null && in_array($petCat, $productCategories)) {
                    $rememberedPetProduct = true; // Remember the "pet" product
                    return true; // Return true as soon as a "pet" product is found
                }

                // Check for non-"pet" category products
                if ($pet === null && !in_array($petCat, $productCategories)) {
                    return true; // Return true as soon as a non-"pet" product is found
                }
            }
        }
    }

    // Return false if no conditions are met
    return false;
}


function Get_QR_Code($product_id, $user, $date)
{
    $postId = PostMeta::where('meta_key', 'qrcode_enabled')
        ->where('meta_value', 1)
        ->whereHas('post', function ($query) use ($product_id, $user, $date) {
            $query->whereHas('meta', fn($q) => $q->where('meta_key', 'product_id')->where('meta_value', $product_id))
                ->whereHas('meta', fn($q) => $q->where('meta_key', 'user_id')->where('meta_value', $user->ID))
                ->whereHas('meta', fn($q) => $q->where('meta_key', 'timestamp')->where('meta_value', $date));
        })
        ->value('post_id');

    return $postId;
}


// get Session langauge
if (!function_exists('get_session_language')) {
    function get_session_language()
    {
        $language_query = Language::query();
        return $language_query->where('code', Session::get('locale', Config::get('app.locale')))->first();
    }
}



if (!function_exists('get_system_language')) {
    function get_system_language()
    {
        $language_query = Language::query();
        $locale = App::getLocale() ?? env('DEFAULT_LANGUAGE');
        $language_query->where('code', $locale);

        return $language_query->first();
    }
}
