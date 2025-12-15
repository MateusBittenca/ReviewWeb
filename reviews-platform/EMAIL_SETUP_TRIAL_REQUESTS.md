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
ADMIN_EMAIL=your-admin-email@example.com

# SendGrid Web API Configuration (uses HTTP/HTTPS, not SMTP - no blocked ports!)
SENDGRID_API_KEY=your-sendgrid-api-key-here
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="Your App Name"
```

**Important:** This system uses SendGrid's **Web API** (not SMTP) to avoid blocked ports issues. It sends emails via HTTPS (port 443) which is never blocked.

### How It Works

The system uses **SendGrid Web API** instead of SMTP:

✅ **Advantages:**
- No SMTP ports needed (uses HTTPS/port 443)
- Faster delivery
- Better reliability
- No timeout issues
- Works on any server/hosting

🔧 **Technical Details:**
- Uses HTTP POST to `https://api.sendgrid.com/v3/mail/send`
- Authentication via API Key (Bearer token)
- No need for SMTP configuration
- Implemented in `app/Services/SendGridService.php`

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
