<?php

namespace App\Service\Contact;

use App\Helpers\ResponseHelper;
use App\Models\Contact;
use Exception;
use Illuminate\Validation\ValidationException;

/**
 * Class ContactService
 *
 * Handles CRUD operations for contacts.
 */
class ContactService
{
    // Create Contact Start ************************************

    /**
     * Create a new contact.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createContact($request)
    {
        try {
            $role = strtolower($request->header('role'));

            if (! in_array($role, ['admin', 'editor'])) {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }

            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'nationality' => 'nullable|string|max:100',
                'gender' => 'nullable|in:male,female,other',
                'dob' => 'nullable|date',
                'designation' => 'nullable|string|max:100',
            ]);

            // Check duplicates manually (optional if validation doesn't cover unique)
            $exists = Contact::where('email', $validated['email'])
                ->orWhere('phone', $validated['phone'])
                ->first();
            if ($exists) {
                return ResponseHelper::Out(false, 'Contact already exists', 400);
            }
            Contact::create($validated);

            return ResponseHelper::Out(true, 'Contact Created Successfully', 200);
        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }

    // Create Contact End ****************************

    // Get Contact List Start ************************************

    /**
     * Get list of all contacts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactList()
    {
        try {
            $contacts = Contact::all();

            return ResponseHelper::Out(true, $contacts, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }

    // Get Contact List End **************************************

    // updateContact Start ************************************

    /**
     * Update an existing contact.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateContact($request)
    {
        try {
            $role = strtolower($request->header('role'));
            if (! in_array($role, ['admin', 'editor'])) {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }
            $contactId = $request->id;

            $contact = Contact::find($contactId);
            if (! $contact) {
                return ResponseHelper::Out(false, 'Contact not found', 404);
            }

            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'nationality' => 'nullable|string|max:100',
                'gender' => 'nullable|in:male,female,other',
                'dob' => 'nullable|date',
                'designation' => 'nullable|string|max:100',
            ]);
            // Check duplicates manually (optional if validation doesn't cover unique)
            $exists = Contact::where('email', $validated['email'])
                ->orWhere('phone', $validated['phone'])
                ->first();
            if ($exists && $exists->id != $contactId) {
                return ResponseHelper::Out(false, 'Contact email or phone already exists', 400);
            }
            Contact::where('id', $contactId)->update($validated);

            return ResponseHelper::Out(true, 'Contact Updated Successfully', 200);
        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }

    // updateContact End ************************************

    // deleteContact Start ************************************

    /**
     * Delete a contact by ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteContact($request)
    {
        try {
            $role = strtolower($request->header('role'));
            if (! in_array($role, ['admin', 'editor'])) {
                return ResponseHelper::Out(false, 'Unauthorized', 401);
            }
            $validated = $request->validate([
                'id' => 'required|integer|exists:contacts,id',
            ]);
            Contact::where('id', $validated['id'])->delete();

            return ResponseHelper::Out(true, 'Contact Deleted Successfully', 200);
        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }

    // deleteContact End ************************************

    // Get Contact By ID Start ************************************

    /**
     * Get contact details by ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactById($request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|integer|exists:contacts,id',
            ]);
            $contact = Contact::where('id', $validated['id'])->first();

            return ResponseHelper::Out(true, $contact, 200);
        } catch (ValidationException $ve) {
            $firstError = collect($ve->validator->errors()->all())->first();

            return ResponseHelper::Out(false, $firstError ?? 'Validation failed', 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }

    // Get Contact By ID End ************************************

    // Get Latest Contact Start ************************************

    /**
     * Get latest 5 contacts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatestContact($request)
    {
        try {
            $contacts = Contact::latest()->take(5)->get();

            return ResponseHelper::Out(true, $contacts->isNotEmpty() ? $contacts : 'No Latest Contact Available', 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }

    // Get Latest Contact End ************************************

    // Get Contact Count Start ************************************

    /**
     * Get total number of contacts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactCount($request)
    {
        try {
            $count = Contact::count();

            return ResponseHelper::Out(true, $count, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Something went wrong', 500);
        }
    }

    // Get Contact Count End ************************************

}
