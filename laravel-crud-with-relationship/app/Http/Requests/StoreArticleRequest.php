<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'publishing_date'  => 'nullable|date',
            'category_id'      => 'required|exists:categories,id',
            'users'            => 'nullable|array',        // required → nullable (artigo sem autores é válido)
            'users.*'          => 'exists:users,id',       // Valida cada id individualmente
            'cover'            => 'nullable|image|max:2048',
        ];
    }
}
