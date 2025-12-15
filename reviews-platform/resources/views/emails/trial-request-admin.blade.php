<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Trial Request - {{ $companyName }}</title>
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
            border-top: 5px solid #8b5cf6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }
        .badge {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
        }
        .info-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #8b5cf6;
        }
        .info-row {
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #666;
            display: inline-block;
            width: 120px;
        }
        .value {
            color: #2c3e50;
        }
        .highlight {
            background-color: #ede9fe;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border: 1px solid #8b5cf6;
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
            margin: 5px;
            font-weight: bold;
            background-color: #8b5cf6;
            color: white;
        }
        .action-button:hover {
            background-color: #7c3aed;
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
            <div class="badge">
                🎯 NEW TRIAL REQUEST
            </div>
            <h2 style="color: #2c3e50; margin: 10px 0;">Someone wants to start a free trial!</h2>
        </div>

        <div class="highlight">
            <h3 style="margin: 0; color: #8b5cf6;">⚡ Action Required</h3>
            <p style="margin: 10px 0;">Contact this potential customer to provide full details and pricing information.</p>
        </div>

        <div class="info-card">
            <h3 style="margin-top: 0; color: #2c3e50;">📋 Contact Information</h3>
            
            <div class="info-row">
                <span class="label">👤 Contact Name:</span>
                <span class="value">{{ $contactName }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">🏢 Company:</span>
                <span class="value">{{ $companyName }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">📧 Email:</span>
                <span class="value"><a href="mailto:{{ $email }}" style="color: #8b5cf6;">{{ $email }}</a></span>
            </div>
            
            <div class="info-row">
                <span class="label">📱 WhatsApp:</span>
                <span class="value">{{ $whatsapp }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">🌐 IP Address:</span>
                <span class="value">{{ $ipAddress }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">🕐 Submitted:</span>
                <span class="value">{{ $timestamp }}</span>
            </div>
        </div>

        <div class="action-buttons">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" 
               class="action-button" target="_blank">
                💬 Contact via WhatsApp
            </a>
            <a href="mailto:{{ $email }}" class="action-button">
                📧 Send Email
            </a>
        </div>

        <div style="background-color: #d1ecf1; padding: 15px; border-radius: 6px; border: 1px solid #bee5eb; margin: 20px 0;">
            <h4 style="margin-top: 0;">💡 Next Steps:</h4>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Contact the customer within 24 hours</li>
                <li>Provide detailed information about features and pricing</li>
                <li>Answer any questions they may have</li>
                <li>Set up their trial account after confirmation</li>
            </ul>
        </div>

        <div class="footer">
            <p><strong>🎯 This is an automated notification from the Reviews Platform.</strong></p>
            <p>A confirmation email has been sent to the customer letting them know someone will be in touch.</p>
        </div>
    </div>
</body>
</html>
