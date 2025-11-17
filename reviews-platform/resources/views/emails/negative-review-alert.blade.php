<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚨 ALERTA: Avaliação Negativa - {{ $company->name }}</title>
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
            border-top: 5px solid #dc3545;
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
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
            background-color: #dc3545;
            color: white;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .review-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #dc3545;
            border: 2px solid #dc3545;
        }
        .rating {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .stars {
            color: #dc3545;
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
        .urgent-notice {
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
            text-align: center;
        }
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .action-button {
            display: inline-block;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 0 10px;
            font-weight: bold;
        }
        .contact-button {
            background-color: #25d366;
            color: white;
        }
        .contact-button:hover {
            background-color: #128c7e;
        }
        .dashboard-button {
            background-color: #007bff;
            color: white;
        }
        .dashboard-button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 12px;
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
            
            <div class="alert-badge">
                🚨 AVALIAÇÃO NEGATIVA - AÇÃO NECESSÁRIA
            </div>
        </div>

        <div class="urgent-notice">
            <h3>⚠️ ATENÇÃO URGENTE</h3>
            <p><strong>Você recebeu uma avaliação negativa que requer sua atenção imediata!</strong></p>
            <p>Recomendamos entrar em contato com o cliente o mais rápido possível para resolver a situação.</p>
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

        <div class="action-buttons">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $review->whatsapp) }}" 
               class="action-button contact-button" target="_blank">
                📱 Entrar em Contato via WhatsApp
            </a>
            <a href="{{ url('/companies') }}" class="action-button dashboard-button">
                📊 Acessar Painel Administrativo
            </a>
        </div>

        <div style="background-color: #d1ecf1; padding: 15px; border-radius: 6px; border: 1px solid #bee5eb; margin: 20px 0;">
            <h4>💡 Dicas para Resolver:</h4>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Entre em contato com o cliente o mais rápido possível</li>
                <li>Seja educado e demonstre interesse em resolver o problema</li>
                <li>Ofereça soluções concretas para a situação</li>
                <li>Peça feedback sobre como melhorar o serviço</li>
            </ul>
        </div>

        <div class="footer">
            <p><strong>🚨 Este é um alerta automático do sistema de avaliações.</strong></p>
            <p>Para mais informações, acesse seu painel administrativo.</p>
        </div>
    </div>
</body>
</html>
