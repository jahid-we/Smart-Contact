<?php

namespace App\Service\User;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Exception;
use Illuminate\Validation\ValidationException;

class UserService
{
    // Get All User Start ************************************
    /**
     * Get all users.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUser($request)
    {
        try {
            $role = strtolower($request->header('role'));
            $userEmail = $request->header('email');

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }

            $users= User::where('email','!=',$userEmail)->get();

            return ResponseHelper::Out(true, $users, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }

    }
    // Get All User End ************************************

    // Get All User By Id Start ************************************
    /**
     * Get user by ID.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserById($request)
    {
        try {
            $role = strtolower($request->header('role'));

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }

            $validated = $request->validate([
                'id' => 'required|integer|exists:users,id',
            ]);

            $user = User::find($validated['id']);

            return ResponseHelper::Out(true, $user, 200);
        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Get All User By Id End ************************************

    // Get All Admin Start ************************************
    /**
     * Get all admin users.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllAdmin($request)
    {
        try {
            $role = strtolower($request->header('role'));

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }
            $users = User::where('role', 'admin')->get();

            return ResponseHelper::Out(true, $users, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Get All Admin End ************************************

    // Get All Editor Start ************************************
    /**
     * Get all editor users.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllEditor($request)
    {
        try {
            $role = strtolower($request->header('role'));

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }
            $users = User::where('role', 'editor')->get();

            return ResponseHelper::Out(true, $users, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Get All Editor End ************************************

    // Get All Normal User Start ************************************
    /**
     * Get all normal users.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllNormalUser($request)
    {
        try {
            $role = strtolower($request->header('role'));

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }
            $users = User::where('role', 'user')->get();

            return ResponseHelper::Out(true, $users, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Get All Normal User End ************************************

    // Count All User Start ************************************
    /**
     * Count all users.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function countAllUser($request)
    {
        try {
            $role = strtolower($request->header('role'));

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }
            $count = User::count();

            return ResponseHelper::Out(true, $count, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Count All User End ************************************

    // Count All Admin Start ************************************
    /**
     * Count all admin users.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function countAllAdmin($request)
    {
        try {
            $role = strtolower($request->header('role'));

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }
            $count = User::where('role', 'admin')->count();

            return ResponseHelper::Out(true, $count, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Count All Admin End ************************************

    // Count All Editor Start ************************************
    /**
     * Count all editor users.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function countAllEditor($request)
    {
        try {
            $role = strtolower($request->header('role'));

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }
            $count = User::where('role', 'editor')->count();

            return ResponseHelper::Out(true, $count, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Count All Editor End ************************************

    // Count All Normal User Start ************************************
    /**
     * Count all normal users.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function countAllNormalUser($request)
    {
        try {
            $role = strtolower($request->header('role'));

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }
            $count = User::where('role', 'user')->count();

            return ResponseHelper::Out(true, $count, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Count All Normal User End ************************************

    // Create User Start ************************************
    /**
     * Create a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser($request)
    {
        try {
            $role = strtolower($request->header('role'));
            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }
            $validated = $request->validate([
                'email' => 'required|string|email|unique:users,email',
                'role' => 'required|string|in:admin,editor,user',
            ]);
            $user = User::create([
                'email' => $validated['email'],
                'role' => $validated['role'],
            ]);

            return ResponseHelper::Out(true, 'User created successfully', 200);
        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Create User End ************************************

    // Update User Role Start ************************************
    /**
     * Update the role of a user.
     *
     * Prevents modification of the main admin.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserRole($request)
    {
        try {
            $role = strtolower($request->header('role'));
            $adminEmail = config('admin.email');
            $mainAdmin = User::where('email', $adminEmail)->first();

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }

            $validated = $request->validate([
                'id' => 'required|integer|exists:users,id',
                'role' => 'required|string|in:admin,editor,user',
            ]);

            $user = User::find($validated['id']);

            if ($mainAdmin && $user->id === $mainAdmin->id) {
                return ResponseHelper::Out(false, 'You are not allowed to change the role of the Principal Admin.', 403);
            }

            $user->role = strtolower($validated['role']);
            $user->save();

            return ResponseHelper::Out(true, 'User role updated successfully', 200);

        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Update User Role End ************************************

    // Delete User Start ************************************
    /**
     * Delete a user.
     *
     * Prevents deletion of the main admin.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser($request)
    {
        try {
            $role = strtolower($request->header('role'));
            $adminEmail = config('admin.email');
            $mainAdmin = User::where('email', $adminEmail)->first();

            if ($role !== 'admin') {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }

            $validated = $request->validate([
                'id' => 'required|integer|exists:users,id',
            ]);

            $user = User::find($validated['id']);

            if ($mainAdmin && $user->id === $mainAdmin->id) {
                return ResponseHelper::Out(false, 'You are not allowed to delete the  Principal Admin.', 403);
            }

            $user->delete();

            return ResponseHelper::Out(true, 'User deleted successfully', 200);

        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }
    // Delete User End ************************************

}
