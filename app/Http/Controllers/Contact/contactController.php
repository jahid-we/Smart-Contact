<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Service\Contact\ContactService;
use Illuminate\Http\Request;

class contactController extends Controller
{
    // ContactService instance
    protected $ContactService;

    // Constructor to bind ContactService instance
    public function __construct(ContactService $ContactService)
    {
        $this->ContactService = $ContactService;
    }

    // Create Contact Start ************************************
    public function createContact(Request $request)
    {
        return $this->ContactService->createContact($request);
    }
    // Create Contact End ***************************************

    // Contact List Start ************************************
    public function contactList(Request $request)
    {
        return $this->ContactService->contactList($request);
    }
    // Contact List End ***************************************

    // Contact Update Start ************************************
    public function updateContact(Request $request)
    {
        return $this->ContactService->updateContact($request);
    }
    // Contact Update End ***************************************

    // Contact Delete Start ************************************
    public function deleteContact(Request $request)
    {
        return $this->ContactService->deleteContact($request);
    }
    // Contact Delete End ***************************************

    // Delete All Contact Start ************************************
    public function deleteAllContact(Request $request)
    {
        return $this->ContactService->deleteAllContact($request);
    }
    // Delete All Contact End ***************************************

    // Contact List By Id Start ************************************
    public function contactById(Request $request)
    {
        return $this->ContactService->contactById($request);
    }
    // Contact List By Id End ***************************************

    // Get  Latest Contact Start ************************************
    public function getLatestContact(Request $request)
    {
        return $this->ContactService->getLatestContact($request);
    }
    // Get  Latest Contact End ***************************************

    // Contact Count Start ************************************
    public function contactCount(Request $request)
    {
        return $this->ContactService->contactCount($request);
    }
    // Contact Count End ***************************************
}
