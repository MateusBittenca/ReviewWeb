<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Página pública
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'whatsapp' => ['required', 'string', 'regex:/^[\d\s\(\)\+\-]+$/', 'min:10', 'max:20'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Por favor, selecione uma nota.',
            'rating.min' => 'A nota deve ser entre 1 e 5 estrelas.',
            'rating.max' => 'A nota deve ser entre 1 e 5 estrelas.',
            'whatsapp.required' => 'Por favor, informe seu WhatsApp.',
            'whatsapp.regex' => 'Informe um número de WhatsApp válido.',
            'whatsapp.min' => 'O número de WhatsApp deve ter no mínimo 10 dígitos.',
            'whatsapp.max' => 'O número de WhatsApp é muito longo.',
            'comment.max' => 'O comentário não pode ter mais de 1000 caracteres.',
        ];
    }

    protected function prepareForValidation()
    {
        // Limpar WhatsApp de caracteres especiais antes da validação
        if ($this->has('whatsapp')) {
            $this->merge([
                'whatsapp' => preg_replace('/[^0-9\+]/', '', $this->whatsapp),
            ]);
        }
    }
}





