<?php

namespace App\Http\Requests;

use App\Models\TypeCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTypeCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('type_category_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:type_categories,name,' . request()->route('type_category')->id,
            ],
        ];
    }
}
