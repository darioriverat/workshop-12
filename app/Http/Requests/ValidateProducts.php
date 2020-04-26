<?php

namespace App\Http\Requests;

use App\Rules\Currencys;
use Illuminate\Foundation\Http\FormRequest;

class ValidateProducts extends FormRequest
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
            'name' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'price'=>['required','numeric','regex:/^\d+(\.\d{1,2})?$/'],
            'photo'=>['nullable'],
            'category_id'=>['required'],
            'currency'=>['required', new Currencys]
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nombre es requerido',
            'category_id.required' => 'Categoria es requerida',
            'description.required'  => 'Descripción es requerida',
            'price.numeric'=>'Solo números utilize (.) para decimales',
            'price.regex'=>'Máximo dos decimales'
        ];
    }
}
