<?php

namespace App\Service\authentication;

use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Notifications\OTPNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

/**
 * Class AuthService
 *
 * Handles user authentication using OTP and JWT.
 */
class AuthService
{
    // User Login Part Start ********************************

    /**
     * Send OTP to user email and store OTP with timestamp.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function userLogin($request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|max:255',
            ]);
            $adminEmail = config('admin.email');

            $userEmail = $validated['email'];
            $OTP = rand(111111, 999999);
            $user = User::updateOrCreate(
                ['email' => $userEmail],
                ['otp' => $OTP, 'role' => $adminEmail === $userEmail ? 'admin' : 'user', 'otp_created_at' => now(), 'is_logged_in' => false]
            );
            $user->notify(new OTPNotification($OTP));

            return ResponseHelper::Out(true, 'OTP Sent to your Email', 200);

        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'User Login Failed', 500);
        }
    }

    // User Login Part End **********************************

    // Verify OTP Part Start ********************************

    /**
     * Verify OTP and log the user in if OTP is valid within 2 minutes.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function verifyOTP($request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|max:255',
                'otp' => 'required|string|size:6|regex:/^\d+$/',
            ]);
            $OTP = $validated['otp'];
            $userEmail = $validated['email'];
            $user = User::where('email', $userEmail)->where('otp', $OTP)->first();

            if ($user) {
                if (Carbon::parse($user->otp_created_at)->timezone('UTC')->addMinute(2)->gt(Carbon::now('UTC'))) {
                    User::where('email', $userEmail)
                        ->where('otp', $OTP)
                        ->update(['otp' => '0', 'otp_created_at' => null, 'is_logged_in' => true]);

                    $request->session()->put('email', $userEmail);
                    $request->session()->put('role', $user->role);
                    $request->session()->put('id', $user->id);
                    return ResponseHelper::Out(true, 'OTP Verified', 200);

                } else {
                    return ResponseHelper::Out(false, 'OTP expired. Please request a new one.', 408);
                }
            }

            return ResponseHelper::Out(false, 'Email or OTP Is Incorrect', 400);
        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'OTP Verification Failed', 500);
        }
    }
    // Verify OTP Part End ********************************

    // Logout Part Start ********************************

    /**
     * Logout user by removing token and setting is_logged_in to false.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function logout($request)
    {
        try {
            $user = User::where('email', $request->session()->get('email'))->first();
            if ($user) {
                $user->update(['is_logged_in' => false]);
                $request->session()->forget('email');
                $request->session()->forget('role');
                $request->session()->forget('id');
                return ResponseHelper::Out(true, 'Logout Success', 200);
            }
            return ResponseHelper::Out(false, 'Logout Failed', 500);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Logout Failed', 500);
        }
    }

    // Logout Part End ********************************
}
