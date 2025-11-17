<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'background_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'google_review_url' => ['sometimes', 'required', 'url', 'max:500'],
            'positive_threshold' => ['sometimes', 'required', 'integer', 'min:1', 'max:5'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome da empresa é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'logo.image' => 'O arquivo deve ser uma imagem.',
            'logo.max' => 'O logo não pode ter mais de 2MB.',
            'background_image.image' => 'O arquivo deve ser uma imagem.',
            'background_image.max' => 'A imagem de fundo não pode ter mais de 5MB.',
            'google_review_url.required' => 'A URL do Google Reviews é obrigatória.',
            'google_review_url.url' => 'Informe uma URL válida.',
            'positive_threshold.required' => 'Defina o limite de avaliação positiva.',
            'positive_threshold.min' => 'O limite deve ser no mínimo 1 estrela.',
            'positive_threshold.max' => 'O limite deve ser no máximo 5 estrelas.',
        ];
    }
}





