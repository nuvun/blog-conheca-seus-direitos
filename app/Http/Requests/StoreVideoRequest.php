<?php

namespace App\Http\Requests;

use App\Models\Video;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVideoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('video_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'external_link' => [
                'string',
                'required',
            ],
            'featured_image' => [
                'required',
            ],
            'duration' => [
                'string',
                'nullable',
            ],
        ];
    }
}
