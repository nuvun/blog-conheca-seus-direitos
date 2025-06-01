<?php

namespace App\Http\Requests;

use App\Models\Partner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePartnerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('partner_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:partners,name,' . request()->route('partner')->id,
            ],
            'featured_image' => [
                'required',
            ],
            'external_link' => [
                'string',
                'nullable',
            ],
        ];
    }
}
