<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
            'phone_number' => [
                'string',
                'required',
            ],
            'document_number' => [
                'string',
                'required',
                'unique:users',
            ],
            'birthday_at' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'password' => [
                'required',
            ],
        ];
    }
}
