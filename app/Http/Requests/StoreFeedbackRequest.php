<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'review_id' => ['required', 'exists:reviews,id'],
            'feedback' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'review_id.required' => 'ID da avaliação não encontrado.',
            'review_id.exists' => 'Avaliação não encontrada.',
            'feedback.required' => 'Por favor, descreva o motivo da sua insatisfação.',
            'feedback.min' => 'Por favor, forneça mais detalhes (mínimo 10 caracteres).',
            'feedback.max' => 'O feedback não pode ter mais de 2000 caracteres.',
        ];
    }
}





