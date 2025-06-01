<?php

namespace App\Http\Requests;

use App\Models\TypeBanner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTypeBannerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('type_banner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:type_banners,id',
        ];
    }
}
