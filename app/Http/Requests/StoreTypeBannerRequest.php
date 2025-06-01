<?php

namespace App\Http\Requests;

use App\Models\TypeBanner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTypeBannerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('type_banner_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:type_banners',
            ],
        ];
    }
}
