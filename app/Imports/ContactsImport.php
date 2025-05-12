<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contact([
            'name'         => $row['name'],
            'phone'        => $row['phone'],
            'email'        => $row['email'],
            'address'      => $row['address'],
            'nationality'  => $row['nationality'],
            'gender'       => $row['gender'],
            'dob'          => $row['date_of_birth'], // Note: CSV heading should be "Date of Birth"
            'designation'  => $row['designation'],
        ]);
    }
}
