# Trial Request Email Setup

## Overview
When someone submits a trial request form on the homepage, the system will:
1. Send an email to the admin with all contact details
2. Send a confirmation email to the customer letting them know someone will be in touch

## Email Configuration

### Required Environment Variables

Add these to your `.env` file:

```env
# Admin email to receive trial request notifications
ADMIN_EMAIL=your-admin@email.com

# SMTP Configuration (if not already set)
MAIL_MAILER=smtp
MAIL_HOST=smtp.your-provider.com
MAIL_PORT=587
MAIL_USERNAME=your-smtp-username
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@reviewsplatform.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Testing Email Configuration

To test if emails are working, you can use:

1. **Mailtrap** (for development):
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your-mailtrap-username
   MAIL_PASSWORD=your-mailtrap-password
   MAIL_ENCRYPTION=tls
   ```

2. **Gmail** (for production - use app password):
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-gmail@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_ENCRYPTION=tls
   ```

## Email Templates

### Admin Email
- **File**: `resources/views/emails/trial-request-admin.blade.php`
- **Subject**: "🎯 New Trial Request - [Company Name]"
- **Content**: Contact details, action buttons to WhatsApp/Email customer

### Customer Email
- **File**: `resources/views/emails/trial-request-customer.blade.php`
- **Subject**: "✅ Your Free Trial Request Has Been Received"
- **Content**: Confirmation that someone will be in touch with full details

## Troubleshooting

### Emails not sending?
1. Check your SMTP credentials in `.env`
2. Check Laravel logs: `storage/logs/laravel.log`
3. Make sure your mail server allows connections
4. Test with Mailtrap.io first

### How to change admin email?
Update the `ADMIN_EMAIL` in your `.env` file:
```env
ADMIN_EMAIL=new-admin@email.com
```

## Log Files

All trial requests are logged to:
- **File**: `storage/logs/laravel.log`
- **Format**: Includes contact name, company, email, WhatsApp, IP, timestamp

## Future Enhancements

The system is ready for:
- Saving to database (create `TrialRequest` model)
- CRM integration (Zapier, HubSpot, etc.)
- Multiple admin recipients
- SMS notifications
- Automated follow-up emails

## Support

If you need help setting up emails, contact:
- Email: support@reviewsplatform.com
- WhatsApp: [Your support number]
