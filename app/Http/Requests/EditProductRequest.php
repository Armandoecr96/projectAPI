<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
            'price' => 'numeric|major',
            'id' => 'exists'
        ];
    }

    /**
     * Get message validation rules that apply to the request.
     *
     * @return array
     */
    public function messages() 
    {
        return[
            'price.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'price.numeric' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'price.major' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity']
        ];
    }
}
