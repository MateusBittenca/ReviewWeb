<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Contatos - {{ $company->name }}</title>
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
        .badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            margin-bottom: 20px;
        }
        .stats {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .stat-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .stat-item:last-child {
            border-bottom: none;
        }
        .stat-label {
            font-weight: bold;
            color: #666;
        }
        .stat-value {
            color: #007bff;
            font-weight: bold;
            font-size: 18px;
        }
        .info-box {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #b3d9ff;
            margin: 20px 0;
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
                <img src="{{ $company->full_logo_url ?? asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" class="logo">
            @endif
            <div class="company-name">{{ $company->name }}</div>
            
            <div class="badge">
                📊 Relatório {{ ucfirst($period) }} de Contatos
            </div>
        </div>

        <div class="info-box">
            <strong>📎 Anexo:</strong> Encontre anexado a este e-mail um arquivo CSV com todos os contatos coletados no período.
            <br><small>O arquivo pode ser aberto no Excel, Google Sheets ou qualquer editor de planilhas.</small>
        </div>

        <div class="stats">
            <div class="stat-item">
                <span class="stat-label">Total de Contatos:</span>
                <span class="stat-value">{{ $contactsCount }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Período:</span>
                <span class="stat-value">{{ ucfirst($period) }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Data do Relatório:</span>
                <span class="stat-value">{{ date('d/m/Y') }}</span>
            </div>
        </div>

        @if($contactsCount > 0)
            <div style="margin: 20px 0;">
                <h3 style="color: #2c3e50; margin-bottom: 15px;">📋 Resumo dos Contatos</h3>
                
                @php
                    $positiveCount = collect($contacts)->where('Tipo', 'Positiva')->count();
                    $negativeCount = collect($contacts)->where('Tipo', 'Negativa')->count();
                    $avgRating = collect($contacts)->avg(function($contact) {
                        return is_numeric($contact['Nota']) ? (int)$contact['Nota'] : 0;
                    });
                @endphp

                <div class="stat-item">
                    <span class="stat-label">Avaliações Positivas:</span>
                    <span style="color: #28a745; font-weight: bold;">{{ $positiveCount }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Avaliações Negativas:</span>
                    <span style="color: #dc3545; font-weight: bold;">{{ $negativeCount }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Nota Média:</span>
                    <span style="color: #ffc107; font-weight: bold;">{{ number_format($avgRating, 1) }} ⭐</span>
                </div>
            </div>
        @else
            <div class="info-box" style="background-color: #fff3cd; border-color: #ffeaa7;">
                <strong>ℹ️ Informação:</strong> Nenhum contato foi coletado neste período.
            </div>
        @endif

        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin: 20px 0;">
            <h4 style="margin-top: 0; color: #2c3e50;">📌 O que está no arquivo CSV?</h4>
            <ul style="margin: 10px 0; padding-left: 20px; color: #666;">
                <li>Data e hora da avaliação</li>
                <li>Nota (estrelas) atribuída</li>
                <li>Número de WhatsApp do cliente</li>
                <li>Comentário deixado (se houver)</li>
                <li>Feedback privado (para avaliações negativas)</li>
                <li>Tipo (Positiva ou Negativa)</li>
            </ul>
        </div>

        <div class="footer">
            <p>Este relatório é enviado automaticamente pelo sistema de avaliações.</p>
            <p>Para mais informações, acesse seu painel administrativo.</p>
            <p><small>Este é um e-mail automático, por favor não responda.</small></p>
        </div>
    </div>
</body>
</html>


