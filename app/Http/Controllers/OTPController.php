<?php

namespace App\Http\Controllers;

use App\Helpers\SendOTPHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OTPController extends Controller
{
    // Show phone number form
    public function showPhoneForm()
    {
        return view('welcome');
    }

    // Send OTP to the user's phone number
    public function sendOTP(Request $request)
    {
        try {
            // Validate phone number
            $request->validate([
                'phone_number' => 'required|numeric|digits:11', // Ensure the phone number is valid
            ]);

            // Generate OTP
            $otp = rand(100000, 999999);

            // Store the OTP in session for later comparison
            Session::put('otp', $otp);
            Session::put('phone_number', $request->phone_number);

            // Send OTP via SMS API (use the provided API to send the OTP)
            $response = SendOTPHelpers::sendOTPToPhone('88' . $request->phone_number, $otp);

            // Check if the response is successful
            if ($response) {
                return response()->json([
                    'message' => "Successfully sent OTP to " . $request->phone_number,
                    'status' => 'success'
                ]);
            } else {
                return response()->json([
                    'message' => "Failed to send OTP. Please try again.",
                    'status' => 'error'
                ]);
            }
        } catch (\Exception $e) {
            // Catch any errors and return them
            return back()->withErrors(['phone_number' => $e->getMessage()]);
        }
    }
    
    // Show OTP verification form
    public function showOTPForm()
    {
        return view('verify-otp');
    }

    // Verify OTP entered by user
    public function verifyOTP(Request $request)
    {
        // Validate OTP input
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        // Check if the entered OTP matches the stored OTP
        if (Session::get('otp') == $request->otp) {
            // OTP is correct, authenticate the user
            Session::forget('otp'); // Clear OTP from session
            Session::forget('phone_number'); // Clear phone number from session

            return redirect()->route('home'); // Redirect to authenticated route (e.g., home)
        }

        // If OTP is incorrect, show an error
        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }
}
