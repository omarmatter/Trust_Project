<?php

namespace Modules\Menu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Http\Requests\BaseRequest;

class ProductRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' =>'required|unique:products,name' ,
            'name_ar' =>'required|unique:products,name' ,
            'price'=>'required' ,
            'main_image'=>'required',
            'description' =>'required' ,
            'category_id' =>'required|exists:categoreys,id' ,
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
