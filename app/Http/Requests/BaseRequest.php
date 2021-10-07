<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
   
    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->first();

        $response = coustom_response(false, 'Error Validation', $error, 422);
        throw new HttpResponseException($response);
    }
}
