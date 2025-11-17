@component('mail::message')
# {{ $review->is_positive ? '⭐ Nova Avaliação Positiva' : '⚠️ Nova Avaliação Negativa' }}

Olá, **{{ $company->name }}**!

Você recebeu uma nova avaliação:

@component('mail::panel')
**Nota:** {{ $review->rating_stars }} ({{ $review->rating }}/5)

**WhatsApp:** {{ $review->whatsapp }}

@if($review->comment)
**Comentário:**
{{ $review->comment }}
@endif

**Data:** {{ $review->created_at->format('d/m/Y H:i') }}
@endcomponent

@if($review->is_positive)
@component('mail::button', ['url' => $company->google_review_url, 'color' => 'success'])
Ver no Google Reviews
@endcomponent

✅ O cliente foi redirecionado automaticamente para avaliar no Google!
@else
⚠️ **Esta é uma avaliação negativa.** Recomendamos entrar em contato com o cliente o mais breve possível.

@component('mail::button', ['url' => route('admin.reviews.negatives')])
Ver Todas as Avaliações Negativas
@endcomponent
@endif

---

Atenciosamente,
{{ config('app.name') }}
@endcomponent





