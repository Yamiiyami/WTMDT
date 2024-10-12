<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
{

    public function authorize()
    {
        return false;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
