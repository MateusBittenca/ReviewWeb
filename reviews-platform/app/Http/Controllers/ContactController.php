<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\TrialRequestAdmin;
use App\Mail\TrialRequestCustomer;

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
            $adminEmail = env('ADMIN_EMAIL', 'admin@reviewsplatform.com');
            
            // Send email to admin
            Mail::to($adminEmail)->send(new TrialRequestAdmin($emailData));
            
            // Send confirmation email to customer
            Mail::to($data['email'])->send(
                new TrialRequestCustomer($data['contact_name'], $data['company_name'])
            );
            
            Log::info('Trial request emails sent successfully', [
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

        // TODO: You can add additional functionality here such as:
        // - Save to database (create a TrialRequest model)
        // - Integrate with CRM

        return response()->json([
            'success' => true,
            'message' => 'Trial request submitted successfully'
        ], 200);
    }
}
