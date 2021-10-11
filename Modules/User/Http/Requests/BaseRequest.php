<?php

namespace Modules\User\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->first();

        $response = coustom_response(false, 'Error Validation', $error, 422);
        throw new HttpResponseException($response);
    }
}
