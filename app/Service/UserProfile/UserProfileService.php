<?php

namespace App\Service\UserProfile;

use App\Helpers\ResponseHelper;
use App\Helpers\UploadFileHelper;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserProfileService
{
    // Create Profile Start ************************************

    /**
     * Create a new user profile or update an existing one.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createProfile($request)
    {
        try {
            $email = $request->header('email');
            $userId = $request->header('id');

            // Check if user exists
            $user = User::where('email', $email)->where('id', $userId)->first();
            if (! $user) {
                return ResponseHelper::Out(false, 'User not found', 404);
            }

            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'img' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            ]);

            // Check duplicates manually (optional if validation doesn't cover unique)
            $exists = UserProfile::where('phone', $validated['phone'])->first();
            if ($exists) {
                return ResponseHelper::Out(false, 'Phone number already exists', 400);
            }

            // Handle file upload if image exists
            $img_url = null;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $img_url = UploadFileHelper::uploadFile($img);
            }

            // Create or Update profile
            UserProfile::updateOrCreate(
                ['user_id' => $userId],
                [
                    'name' => $validated['name'],
                    'email' => $user->email,
                    'phone' => $validated['phone'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'img_url' => $img_url,
                ]
            );

            return ResponseHelper::Out(true, 'Profile created successfully', 200);

        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Error occurred while creating profile', 500);
        }
    }
    // Create Profile End ************************************

    // Update Profile Start ************************************

    /**
     * Update an existing user profile.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile($request)
    {
        DB::beginTransaction();
        try {
            $email = $request->header('email');
            $userId = $request->header('id');

            // Check if user exists
            $user = User::where('email', $email)->where('id', $userId)->first();
            if (! $user) {
                return ResponseHelper::Out(false, 'User not found', 404);
            }

            // Check if profile exists
            $profile = UserProfile::where('user_id', $userId)->first();
            if (! $profile) {
                return ResponseHelper::Out(false, 'Profile not found', 404);
            }

            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'img' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            ]);

            // Check phone duplicate
            $exists = UserProfile::where('phone', $validated['phone'])->first();
            if ($exists && $exists->id != $profile->id) {
                return ResponseHelper::Out(false, 'Phone number already exists', 400);
            }

            // Handle image
            $img_url = $profile->img_url;
            if ($request->hasFile('img')) {
                // Delete old image if exists (convert to storage path)
                if ($img_url) {
                    $relativePath = str_replace('/storage/', '', $img_url); // e.g., uploads/abc.jpg
                    if (Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->delete($relativePath);
                    }
                }

                // Upload new image
                $img = $request->file('img');
                $img_url = UploadFileHelper::uploadFile($img); // returns full /storage/... path
            }

            // Update profile info
            $profile->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'img_url' => $img_url,
            ]);

            // Update email if needed
            $emailUpdated = $this->updateEmailIfChanged($user, $validated['email'] ?? null);

            DB::commit();

            if ($emailUpdated) {
                return ResponseHelper::Out(true, 'Email And Profile updated. Please log in again.', 200)
                    ->cookie('token', '', -1);
            }

            return ResponseHelper::Out(true, 'Profile updated successfully', 200);

        } catch (ValidationException $ve) {
            DB::rollBack();
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            DB::rollBack();

            return ResponseHelper::Out(false, 'Error occurred while updating profile', 500);
        }
    }
    // Update Profile End ************************************

    // Email update helper Start ************************************

    /**
     * Update the email address if it was changed and does not already exist.
     *
     * @param  User  $user
     * @param  string|null  $newEmail
     * @return bool
     */
    private function updateEmailIfChanged($user, $newEmail)
    {
        if (! empty($newEmail) && $newEmail !== $user->email) {
            $emailExists = User::where('email', $newEmail)
                ->where('id', '!=', $user->id)
                ->exists();

            if ($emailExists) {
                return false;
            }

            $user->update(['email' => $newEmail]);

            return true;
        }

        return false;
    }
    // Email update helper End ************************************

    // Delete Profile Start ************************************

    /**
     * Delete the user's profile including profile image.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProfile($request)
    {
        try {
            $email = $request->header('email');
            $userId = $request->header('id');

            // Check if user exists
            $user = User::where('email', $email)->where('id', $userId)->first();
            if (! $user) {
                return ResponseHelper::Out(false, 'User not found', 404);
            }

            // Check if profile exists
            $profile = UserProfile::where('user_id', $userId)->first();
            if (! $profile) {
                return ResponseHelper::Out(false, 'Profile not found', 404);
            }

            // Delete image from storage
            $img_url = $profile->img_url;
            if ($img_url) {
                $relativePath = str_replace('/storage/', '', $img_url); // e.g., uploads/abc.jpg
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            }

            // Delete profile from DB
            $profile->delete();

            return ResponseHelper::Out(true, 'Profile deleted successfully', 200);

        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Error occurred while deleting profile', 500);
        }
    }
    // Delete Profile End ************************************

    // Get Profile Start ********************************************

    /**
     * Retrieve the profile of the authenticated user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile($request)
    {
        try {
            $email = $request->header('email');
            $userId = $request->header('id');

            // Check if user exists
            $user = User::where('email', $email)->where('id', $userId)->first();
            if (! $user) {
                return ResponseHelper::Out(false, 'User not found', 404);
            }

            // Check if profile exists
            $profile = UserProfile::where('user_id', $userId)->first();
            if (! $profile) {
                return ResponseHelper::Out(false, 'Profile not found', 404);
            }

            return ResponseHelper::Out(true, $profile, 200);

        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Error occurred while getting profile', 500);
        }
    }
    // Get Profile End ********************************************
}
