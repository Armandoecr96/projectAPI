<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearProductRequest extends FormRequest
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
        $request = \json_decode($this->getContent());
        var_dump($request->data->type);
        return [
            $request->data->type => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric|major'
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
            'type.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'name.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'price.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'price.numeric' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'price.major' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity']
        ];
    }
}
