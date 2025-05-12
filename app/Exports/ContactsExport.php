<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Contact::select('name', 'phone', 'email', 'address', 'nationality', 'gender', 'dob', 'designation')->get();
    }

    public function headings(): array
    {
        return ['Name', 'Phone', 'Email', 'Address', 'Nationality', 'Gender', 'Date of Birth', 'Designation'];
    }
}
