<?php

namespace App\Http\Requests;

use App\Models\TypeCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTypeCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('type_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:type_categories,id',
        ];
    }
}
