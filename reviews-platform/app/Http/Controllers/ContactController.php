<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\SendGridService;

class ContactController extends Controller
{
    protected $sendGrid;

    public function __construct(SendGridService $sendGrid)
    {
        $this->sendGrid = $sendGrid;
    }

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
            
            // Send email to admin using SendGrid Web API (no SMTP)
            $this->sendGrid->sendFromView(
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
            
            // Send confirmation email to customer using SendGrid Web API
            $this->sendGrid->sendFromView(
                $data['email'],
                '✅ Your Free Trial Request Has Been Received',
                'emails.trial-request-customer',
                [
                    'contactName' => $data['contact_name'],
                    'companyName' => $data['company_name'],
                ]
            );
            
            Log::info('Trial request emails sent successfully via SendGrid API', [
                'customer_email' => $data['email'],
                'admin_email' => $adminEmail
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
}
