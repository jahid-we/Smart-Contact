<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\User\UserService;
use Illuminate\Http\Request;

class userController extends Controller
{
    //  UserService instance
    protected $UserService;

    // Constructor to bind UserService instance
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    // Get All User Start ************************************
    public function getAllUser(Request $request)
    {
        return $this->UserService->getAllUser($request);
    }
    // Get All User End ************************************

    // Get All Admin Start ************************************
    public function getAllAdmin(Request $request)
    {
        return $this->UserService->getAllAdmin($request);
    }
    // Get All Admin End ************************************

    // Get All Editor Start ************************************
    public function getAllEditor(Request $request)
    {
        return $this->UserService->getAllEditor($request);
    }
    // Get All Editor End ************************************

    // Get All Normal User/ Viewer Start ************************************

    public function getAllNormalUser(Request $request)
    {
        return $this->UserService->getAllNormalUser($request);
    }
    // Get All Normal User/ Viewer End ************************************

    // Count All User Start ************************************
    public function countAllUser(Request $request)
    {
        return $this->UserService->countAllUser($request);
    }
    // Count All User End ************************************

    // Count All Admin Start ************************************
    public function countAllAdmin(Request $request)
    {
        return $this->UserService->countAllAdmin($request);
    }
    // Count All Admin End ************************************

    // Count All Editor Start ************************************
    public function countAllEditor(Request $request)
    {
        return $this->UserService->countAllEditor($request);
    }
    // Count All Editor End ************************************

    // Count All Normal User Start ************************************
    public function countAllNormalUser(Request $request)
    {
        return $this->UserService->countAllNormalUser($request);
    }
    // Count All Normal User End ************************************

    // Create User Start ************************************
    public function createUser(Request $request)
    {
        return $this->UserService->createUser($request);
    }
    // Create User End ************************************

    // Update User Role Start ************************************
    public function updateUserRole(Request $request)
    {
        return $this->UserService->updateUserRole($request);
    }
    // Update User Role End ************************************

    // Delete User Start ************************************
    public function deleteUser(Request $request)
    {
        return $this->UserService->deleteUser($request);
    }
    // Delete User End ************************************
}
