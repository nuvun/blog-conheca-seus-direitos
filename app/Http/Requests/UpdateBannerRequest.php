<?php

namespace App\Http\Requests;

use App\Models\Banner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('banner_edit');
    }

    public function rules(): array
    {
        return [
            'type_banner_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'image' => [
                Rule::requiredIf(function () {
                    return $this->get('format') === 'FILE';
                }),
            ],
            'start_at' => [
                'required',
            ],
            'end_at' => [
                'required',
            ],
            'link' => [
                'string',
                'nullable',
            ],
            'position' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'status' => [
                'required',
            ],
        ];
    }
}
