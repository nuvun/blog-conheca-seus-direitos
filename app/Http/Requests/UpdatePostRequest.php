<?php

namespace App\Http\Requests;

use App\Models\Post;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('post_edit');
    }

    public function rules(): array
    {
        return [
            'categories.*' => [
                'integer',
            ],
            'categories' => [
                'required',
                'array',
            ],
            'title' => [
                'string',
                'required',
            ],
            'subtitle' => [
                'string',
                'nullable',
            ],
            'content' => [
                'sometimes',
            ],
            'source' => [
                'string',
                'nullable',
            ],
            'published_at' => [
                'required',
            ],
            'status' => [
                'required',
            ],
        ];
    }
}
