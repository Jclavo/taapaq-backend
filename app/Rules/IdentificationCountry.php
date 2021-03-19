<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\PersonType;

class IdentificationCountry implements Rule
{
    protected $countryCode;
    protected $personTypeID;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($countryCode,$personTypeID)
    {
        $this->countryCode = $countryCode;
        $this->personTypeID = $personTypeID;
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
                switch ($this->personTypeID) {
                    case PersonType::getForNatural():
                        if(strlen($value) != 11){
                            return false;
                        }
                        break;
                    case PersonType::getForJuridical():
                        if(strlen($value) != 14){
                            return false;
                        }
                        break;
                    
                    default:
                }
                break;
            case "51":
                switch ($this->personTypeID) {
                    case PersonType::getForNatural():
                        if(strlen($value) != 8){
                            return false;
                        }
                        break;
                    case PersonType::getForJuridical():
                        if(strlen($value) != 10){
                            return false;
                        }
                        break;
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
        return 'The Identification format is incorrect.';
    }
}
