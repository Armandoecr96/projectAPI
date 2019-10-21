<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

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
        return [
            'data.type' => 'required',
            'data.attributes.name' => 'required|string',
            'data.attributes.price' => 'required|numeric|major'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $errorMessage = '';
        foreach($errors as $obj) {
            $errorMessage = $obj;
        }
        throw new HttpResponseException(
            response()->json(['errors' => $errorMessage], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    /**
     * Get message validation rules that apply to the request.
     *
     * @return array
     */
    public function messages() 
    {
        return[
            'data.type.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'data.attributes.type.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'data.attributes.name.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'data.attributes.price.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'data.attributes.price.numeric' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'data.attributes.price.major' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity']
        ];
    }
}
