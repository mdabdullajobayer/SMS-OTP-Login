<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendOTPHelpers{
    public static function sendOTPToPhone($phoneNumber, $otp)
    {
        $apiKey = "01893222770.fd5dabd4-ebb7-4208-86d2-289a09d7c976";  // Your API Key
        $senderId = "8809617613279";  // Sender ID
        $textBody = "Your OTP is: $otp";  // OTP message content

        // API URL
        $url = "https://smsmassdata.massdata.xyz/api/sms/send";

        // Prepare data to be sent in the POST request as JSON
        $postData = [
            'apiKey' => $apiKey,  // API Key
            'contactNumbers' => $phoneNumber,  // Recipient's phone number
            'senderId' => $senderId,  // Sender ID
            'textBody' => $textBody,  // Message body containing the OTP
        ];

        try {
            // Send POST request using Laravel's HTTP client with JSON body
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $postData);

            // Check if the response status is successful (HTTP 200)
            if ($response->successful()) {
                // Return true if the request was successful
                return true;
            } else {
                // Log the error if the response was not successful
                Log::error('SMS API Error: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            // Catch any exceptions and log them
            Log::error('SMS API Exception: ' . $e->getMessage());
            return false;
        }
    }
}