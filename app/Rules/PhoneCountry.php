<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneCountry implements Rule
{
    protected $countryCode;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        switch ($this->countryCode) {
            case "55":
                if(strlen($value) != 11){
                    return false;
                }
                break;
            case "51":
                if(strlen($value) != 9){
                    return false;
                }
                break;
            default:
                return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone format is incorrect.';
    }
}
