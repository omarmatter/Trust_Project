<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Http\Requests\BaseRequest;

class OrdertRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'method_id' =>'required',


        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
