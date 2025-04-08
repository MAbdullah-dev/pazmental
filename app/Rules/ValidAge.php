<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class ValidAge implements ValidationRule
{
    private $dateOfBirth;

    public function __construct($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dob = Carbon::parse($this->dateOfBirth);
        $currentDate = Carbon::now();
        $calculatedAge = $currentDate->diffInYears($dob);
        $calculatedAge = abs($calculatedAge);
        $calculatedAge = floor($calculatedAge);
        if ($calculatedAge != $value) {
           $fail('The age does not match the date of birth.');
        }
    }
}
