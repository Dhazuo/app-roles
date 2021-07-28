<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ];
    }

    public function messages()
    {
        return [
          'name.required' => 'El nombre del producto es requerido.',
          'description.required' => 'Una descripción es requerida.',
          'price.required' => 'El precio es requerido',
          'stock.required' => 'El stock es requerido.'
        ];
    }
}
