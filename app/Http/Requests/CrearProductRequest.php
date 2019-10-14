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
        $request = \json_decode($this->getContent());
        var_dump($request->data->type);
        return [
            $request->data->type => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric|major'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $errorMessage = '';
        foreach($errors as $obj) {
            var_dump($obj);
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
            'type.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'name.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'price.required' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'price.numeric' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity'],
            'price.major' => ['code' => 'ERROR-1', 'title' => 'Unprocessable Entity']
        ];
    }
}
