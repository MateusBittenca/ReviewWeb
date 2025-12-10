<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Recuperação de Senha</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #111827;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .code-container {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border: 2px dashed #8b5cf6;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .code-label {
            font-size: 14px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .code {
            font-size: 42px;
            font-weight: 800;
            color: #8b5cf6;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            margin: 25px 0;
            border-radius: 6px;
        }
        .warning-text {
            font-size: 14px;
            color: #92400e;
            margin: 0;
        }
        .expires-info {
            text-align: center;
            font-size: 14px;
            color: #9ca3af;
            margin-top: 20px;
        }
        .email-footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text {
            font-size: 13px;
            color: #6b7280;
            margin: 5px 0;
        }
        .footer-link {
            color: #8b5cf6;
            text-decoration: none;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: #ffffff;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            font-size: 16px;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 20px;
                border-radius: 8px;
            }
            .email-header, .email-body, .email-footer {
                padding: 25px 20px;
            }
            .code {
                font-size: 32px;
                letter-spacing: 6px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🔐 Recuperação de Senha</h1>
        </div>
        
        <div class="email-body">
            <div class="greeting">
                Olá, {{ $user->name }}!
            </div>
            
            <div class="message">
                Recebemos uma solicitação para redefinir a senha da sua conta. Use o código abaixo para continuar o processo de recuperação.
            </div>
            
            <div class="code-container">
                <div class="code-label">Seu Código de Verificação</div>
                <div class="code">{{ $code }}</div>
            </div>
            
            <div class="warning">
                <p class="warning-text">
                    <strong>⚠️ Importante:</strong> Este código é válido por apenas <strong>{{ $expiresIn }} minutos</strong>. 
                    Não compartilhe este código com ninguém. Nossa equipe nunca solicitará este código por telefone ou email.
                </p>
            </div>
            
            <div class="expires-info">
                ⏰ Código expira em {{ $expiresIn }} minutos
            </div>
        </div>
        
        <div class="email-footer">
            <p class="footer-text">
                Se você não solicitou esta recuperação de senha, ignore este email.
            </p>
            <p class="footer-text">
                <a href="{{ url('/') }}" class="footer-link">{{ config('app.name') }}</a>
            </p>
            <p class="footer-text" style="margin-top: 15px; font-size: 12px; color: #9ca3af;">
                Este é um email automático, por favor não responda.
            </p>
        </div>
    </div>
</body>
</html>

