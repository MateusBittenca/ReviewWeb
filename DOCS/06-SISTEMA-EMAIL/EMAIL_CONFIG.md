# Email Configuration for Reviews Platform
# Copy these settings to your .env file

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# For development/testing, you can use log driver
# MAIL_MAILER=log

# Alternative SMTP providers:
# Gmail: smtp.gmail.com:587
# Outlook: smtp-mail.outlook.com:587
# Yahoo: smtp.mail.yahoo.com:587
# Custom SMTP: your-smtp-server.com:587
