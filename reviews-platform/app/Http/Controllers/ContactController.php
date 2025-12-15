<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use GuzzleHttp\Client;

class ContactController extends Controller
{
    public function submitTrialRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        
        // Add additional data for logging and emails
        $emailData = array_merge($data, [
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
        
        // Log the trial request
        Log::channel('single')->info('New Trial Request', $emailData);

        try {
            // Get admin email from environment variable
            $adminEmail = env('ADMIN_EMAIL', 'iagovventura@gmail.com');
            
            // Send email to admin using SendGrid API via HTTP (same as ReviewController)
            $this->sendViaSendGridAPI(
                $adminEmail,
                '🎯 New Trial Request - ' . $data['company_name'],
                'emails.trial-request-admin',
                [
                    'contactName' => $data['contact_name'],
                    'companyName' => $data['company_name'],
                    'email' => $data['email'],
                    'whatsapp' => $data['whatsapp'],
                    'ipAddress' => $emailData['ip_address'],
                    'timestamp' => $emailData['timestamp'],
                ]
            );
            
            // Send confirmation email to customer using SendGrid API via HTTP
            $this->sendViaSendGridAPI(
                $data['email'],
                '✅ Your Free Trial Request Has Been Received',
                'emails.trial-request-customer',
                [
                    'contactName' => $data['contact_name'],
                    'companyName' => $data['company_name'],
                ]
            );
            
            Log::info('✅ Trial request emails sent successfully via SendGrid API (HTTP)', [
                'customer_email' => $data['email'],
                'admin_email' => $adminEmail,
                'status' => 'success'
            ]);
            
        } catch (\Exception $e) {
            // Log the error but don't fail the request
            Log::error('Failed to send trial request emails', [
                'error' => $e->getMessage(),
                'data' => $emailData
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Trial request submitted successfully'
        ], 200);
    }

    /**
     * Send email using SendGrid API via HTTP (using Guzzle)
     * This bypasses SMTP port blocks - same method as ReviewController
     */
    private function sendViaSendGridAPI($toEmail, $subject, $view, $data = [])
    {
        $apiKey = env('SENDGRID_API_KEY');
        
        if (!$apiKey) {
            throw new \Exception('SENDGRID_API_KEY não configurada');
        }

        // Render email HTML using Laravel Views
        $htmlContent = View::make($view, $data)->render();

        // Prepare SendGrid API request using Guzzle
        $client = new Client();
        $response = $client->post('https://api.sendgrid.com/v3/mail/send', [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'personalizations' => [
                    [
                        'to' => [
                            ['email' => $toEmail]
                        ],
                        'subject' => $subject
                    ]
                ],
                'from' => [
                    'email' => env('MAIL_FROM_ADDRESS', 'iagovventura@gmail.com'),
                    'name' => env('MAIL_FROM_NAME', 'Avalie e Ganhe')
                ],
                'content' => [
                    [
                        'type' => 'text/html',
                        'value' => $htmlContent
                    ]
                ]
            ]
        ]);

        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            Log::info('✅ Email enviado com sucesso via SendGrid API (HTTP)', [
                'to' => $toEmail,
                'subject' => $subject,
                'status_code' => $response->getStatusCode()
            ]);
            return true;
        } else {
            throw new \Exception('SendGrid API retornou status: ' . $response->getStatusCode());
        }
    }
}
