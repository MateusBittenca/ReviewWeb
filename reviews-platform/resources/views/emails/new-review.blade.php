<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Avaliação - {{ $company->name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }
        .logo {
            max-width: 100px;
            height: auto;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .alert-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .positive-badge {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .negative-badge {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .review-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid {{ $isPositive ? '#28a745' : '#dc3545' }};
        }
        .rating {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .stars {
            color: #ffc107;
            font-size: 20px;
        }
        .whatsapp {
            background-color: #25d366;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            display: inline-block;
            margin: 10px 0;
            font-weight: bold;
        }
        .comment {
            background-color: white;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
            border: 1px solid #dee2e6;
            font-style: italic;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 12px;
        }
        .action-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .action-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($company->logo)
                <img src="{{ $company->full_logo_url }}" alt="{{ $company->name }}" class="logo">
            @endif
            <div class="company-name">{{ $company->name }}</div>
            
            <div class="alert-badge {{ $isPositive ? 'positive-badge' : 'negative-badge' }}">
                @if($isPositive)
                    ⭐ Nova Avaliação Positiva
                @else
                    🚨 Avaliação Negativa - Ação Necessária
                @endif
            </div>
        </div>

        <div class="review-card">
            <div class="rating">
                <strong>Avaliação:</strong>
                <span class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                </span>
                <strong>{{ $review->rating }}/5 estrelas</strong>
            </div>

            <div class="whatsapp">
                📱 WhatsApp: {{ $review->whatsapp }}
            </div>

            @if($review->comment)
                <div class="comment">
                    <strong>Comentário:</strong><br>
                    "{{ $review->comment }}"
                </div>
            @endif

            <div style="margin-top: 15px; font-size: 12px; color: #666;">
                📅 Recebido em: {{ $review->created_at->format('d/m/Y H:i') }}
            </div>
        </div>

        @if($isPositive)
            <div style="text-align: center;">
                <p><strong>🎉 Parabéns!</strong> Você recebeu uma avaliação positiva!</p>
                <p>O cliente será redirecionado para o Google para deixar uma avaliação pública.</p>
            </div>
        @else
            <div style="background-color: #fff3cd; padding: 15px; border-radius: 6px; border: 1px solid #ffeaa7; margin: 20px 0;">
                <strong>⚠️ Atenção:</strong> Esta é uma avaliação negativa que requer sua atenção imediata.
                <br>Recomendamos entrar em contato com o cliente para resolver a situação.
            </div>
        @endif

        <div class="footer">
            <p>Este e-mail foi enviado automaticamente pelo sistema de avaliações.</p>
            <p>Para mais informações, acesse seu painel administrativo.</p>
        </div>
    </div>
</body>
</html>
