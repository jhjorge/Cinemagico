<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'query' => ['sometimes', 'string', 'min:2', 'max:255'],
            'page'  => ['sometimes', 'integer', 'min:1', 'max:500'],
        ];
    }
    public function messages(): array
    {
        return [
            'query.required' => 'O campo de busca é obrigatório.',
            'query.min'      => 'A busca deve ter pelo menos :min caracteres.',
            'page.integer'   => 'A página deve ser um número inteiro.',
            'page.max'   => 'A página deve ser um número de no máximo :max.',
            'page.min'   => 'O número da página deve ser no mínimo :min ',
        ];
    }
}
