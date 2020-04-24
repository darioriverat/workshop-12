<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Currencys implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $currencys=['COP','USD'];
    public function __construct()
    {
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
        //
        return in_array($value,$this->currencys );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute no se encuentra en las opciones';
    }
}
