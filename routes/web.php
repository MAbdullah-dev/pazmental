<?php

use App\Livewire\Dashboard;
use App\Livewire\ErrorPage;
use App\Livewire\User\Faqs;
use App\Livewire\Adminlogin;
use App\Livewire\NoticePage;
use App\Livewire\PatientPet;
use App\Livewire\PetDetails;
use App\Livewire\WizardForm;
use App\Livewire\Translations;
use App\Livewire\ManageLanguage;
use App\Livewire\User\DetailsView;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Http\Controllers\Auth\LoginQrController;
use App\Livewire\Unauthorized;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Livewire\User\{MedicalHistory, PatientHistory};
 /*
    |--------------------------------------------------------------------------
    | Application language bindings
    |--------------------------------------------------------------------------
    |*/
    $locales = env('DEFAULT_LANGUAGE');
    session()->put('locale', $locales);
// Wrap all non-admin routes with 'site_access' middleware
Route::middleware(['site_access'])->group(
    function () {
        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('wizard', WizardForm::class)->name('wizard');
            Route::get('medical-history', MedicalHistory::class)->name('medical-history');
            Route::get('SaveExit', [MedicalHistory::class, 'SaveExit'])->name('SaveExit');
            Route::get('pet-history', PetDetails::class)->name('pet-history');
            Route::get('patient-pet', PatientPet::class)->name('PatientPet');
            Route::get('faqs', Faqs::class)->name('faqs');
            Route::get('/', Dashboard::class)->name('dashboard');
            Route::get('dashboard', Dashboard::class);
        });


    Route::get('patient-details/{data}', PatientHistory::class)->name('patient-details');
    Route::get('pd/{data}', PatientHistory::class)->name('patient-details');
    Route::get('DetailsView/{data}', DetailsView::class)->name('DetailsView');
    }
);

Route::get('suspenedqr', NoticePage::class)->name('suspenedqr');
Route::get('unauthorized', Unauthorized::class)->name('unauthorized');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest_admin')->group(function () {
        Route::get('login', Adminlogin::class)->name('login');
    });
    Route::middleware('auth:admin')->group(function () {
        Route::get('/', AdminDashboard::class)->name('dashboard');
        Route::get('manage-language', ManageLanguage::class)->name('language');
        Route::get('editlang/{id}', ManageLanguage::class)->name('editlang');
        Route::delete('deletelang/{id}', [AdminDashboard::class, 'delete'])->name('deletelang');
        Route::get('translations/{id}', Translations::class)->name('languages.show');
    });
});

Route::post('/change-language', [ManageLanguage::class, 'changeLanguage'])->name('language.change');
require __DIR__ . '/auth.php';
// Route::fallback(ErrorPage::class);

Route::get('/test-db-connection', function () {
    try {
        DB::connection('wordpress')->getPdo();
        return 'WordPress database connection is successful!';
    } catch (\Exception $e) {
        Log::error('Error connecting to WordPress database: ' . $e->getMessage());
        return 'Error: ' . $e->getMessage();

    }
});


//location route
Route::post('/save-location', function (Request $request) {
    $data = $request->validate([
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
        'country' => 'nullable|string',
        'city' => 'nullable|string',
    ]);

    session([
        'user_location' => $data
    ]);

    Log::info('Location stored successfully!', $data);

    return response()->json([
        'message' => 'Location stored successfully!',
        'stored' => session('user_location')
    ]);
});


use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Route;

Route::get('/test-wp-hash', function () {
    $plainPassword = '123456789'; // Replace with real password
    $hashedPassword = '$wp$2y$10$Prm4mHVB9ds3TZD5TQHFUO4nzXTGet7nbH1LoHvtr/piqOsCmF52e'; // Replace with real hash from DB
    // Manually strip $wp$ prefix
    if (strpos($hashedPassword, '$wp$') === 0) {
        $hashedPassword = substr($hashedPassword, 4);
    }
    if (password_verify($plainPassword, $hashedPassword)) {
        return ':white_tick: Password matches!';
    } else {
        return ':x: Password does NOT match.';
    }
});
