<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateCategories extends FormRequest
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
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nombre es requerido',
            'description.required'  => 'Descripción es requerida',
            'name.max' => 'Nombre es requerido',
            'description.max'  => 'Descripción es requerida',
        ];
    }
}
