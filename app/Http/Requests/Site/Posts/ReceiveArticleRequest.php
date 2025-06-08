<?php

namespace App\Http\Requests\Site\Posts;

use Illuminate\Foundation\Http\FormRequest;

class ReceiveArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'title' => ['required', 'max:255'],
            'file'  => ['required', 'file', 'mimes:pdf,doc,docx', 'max:4960'], // 4MB max
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email'    => 'O e-mail deve ser válido.',
            'title.required' => 'O título é obrigatório.',
            'file.required'  => 'O arquivo é obrigatório.',
            'file.file'      => 'Deve ser um arquivo válido.',
            'file.mimes'     => 'O arquivo deve ser um PDF, DOC ou DOCX.',
            'file.max'       => 'O arquivo não pode exceder 4MB.',
        ];
    }
}
