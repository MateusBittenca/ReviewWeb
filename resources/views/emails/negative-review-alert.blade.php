@component('mail::message')
# 🚨 ATENÇÃO: Cliente Insatisfeito - Ação Necessária

Olá, **{{ $company->name }}**!

Um cliente deixou uma avaliação negativa e explicou o motivo da insatisfação.

@component('mail::panel')
**Nota:** {{ $review->rating_stars }} ({{ $review->rating }}/5)

**WhatsApp:** {{ $review->whatsapp }}

**Data:** {{ $review->created_at->format('d/m/Y às H:i') }}
@endcomponent

## 💬 Motivo da Insatisfação:

@component('mail::panel')
{{ $review->feedback }}
@endcomponent

## 📞 Ação Recomendada:

Entre em contato com o cliente **o mais rápido possível** através do WhatsApp informado.

Uma resposta rápida pode transformar essa experiência negativa em uma oportunidade de fidelização!

@component('mail::button', ['url' => 'https://wa.me/' . $review->formatted_whatsapp, 'color' => 'success'])
Contatar pelo WhatsApp
@endcomponent

@component('mail::button', ['url' => route('admin.reviews.negatives')])
Ver Painel de Avaliações
@endcomponent

---

**Dica:** Ao entrar em contato:
- Agradeça pelo feedback
- Demonstre empatia
- Ofereça uma solução concreta
- Convide para uma nova experiência

Atenciosamente,
{{ config('app.name') }}
@endcomponent





