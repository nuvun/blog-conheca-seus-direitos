<?php

namespace App\Http\Requests;

use App\Models\Post;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
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
