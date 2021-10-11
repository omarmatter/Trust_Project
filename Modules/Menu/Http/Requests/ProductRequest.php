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
            'name' =>'required|unique:products,name' ,
            'price'=>'required' ,
            'description' =>'required' ,
            'category_id' =>'required' ,
            'main_image'=>'required' ,
            'image_type'=>'nullable ',
            'image_path' =>'nullable '
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
