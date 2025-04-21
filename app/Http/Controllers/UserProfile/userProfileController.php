<?php

namespace App\Http\Controllers\UserProfile;

use App\Http\Controllers\Controller;
use App\Service\UserProfile\UserProfileService;
use Illuminate\Http\Request;

class userProfileController extends Controller
{
    // Property to hold the UserProfileService instance
    /**
     * @var UserProfileService
     */
    protected $UserProfileService;

    /**
     * userProfileController constructor.
     */
    // This constructor method is used to inject the UserProfileService into the controller

    public function __construct(UserProfileService $UserProfileService)
    {

        $this->UserProfileService = $UserProfileService;

    }

    // Create Profile Start ************************************
    public function createProfile(Request $request)
    {
        return $this->UserProfileService->createProfile($request);
    }
    // Create Profile End ***************************************

    // Update Profile Start ************************************
    public function updateProfile(Request $request)
    {
        return $this->UserProfileService->updateProfile($request);
    }
    // Update Profile End **************************************

    // Delete Profile Start ************************************
    public function deleteProfile(Request $request)
    {
        return $this->UserProfileService->deleteProfile($request);
    }
    // Delete Profile End ***************************************

    // Get Profile Start ********************************************
    public function getProfile(Request $request)
    {
        return $this->UserProfileService->getProfile($request);
    }
    // Get Profile End **********************************************
}
