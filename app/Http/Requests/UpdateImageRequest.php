<?php

namespace App\Http\Requests;

use App\Models\Image;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateImageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('image_edit');
    }

    public function rules()
    {
        return [
            'photo' => [
                'required',
            ],
            'legend' => [
                'string',
                'required',
            ],
            'credit' => [
                'string',
                'nullable',
            ],
            'photographer' => [
                'string',
                'nullable',
            ],
            'local' => [
                'string',
                'nullable',
            ],
        ];
    }
}
