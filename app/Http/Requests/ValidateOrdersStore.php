<?php

namespace App\Http\Requests;

use App\Enums\CountryOptions;
use Illuminate\Foundation\Http\FormRequest;
use BenSampo\Enum\Rules\EnumValue;

class ValidateOrdersStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => ['required', 'numeric'],
            'product_id'=>['required','numeric'],
            'country'=>['required',new EnumValue(CountryOptions::class)],
        ];
    }
    public function messages()
    {
        return [
            'quantity.required'=>'Cantidad es requerida',
            'product_id.required' => 'Producto es requerida',
            'country.required'  => 'País es requerida',
        ];
    }
}
