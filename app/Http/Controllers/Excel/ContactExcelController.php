<?php

namespace App\Http\Controllers\Excel;

use Exception;
use Illuminate\Http\Request;
use App\Exports\ContactsExport;
use App\Helpers\ResponseHelper;
use App\Imports\ContactsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ContactExcelController extends Controller
{
    //  Export contacts to Excel Start ********************************
    public function export()
    {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }
    // Export contacts to Excel End ***********************************


    // Import contacts from Excel Start ********************************
     public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);
        try{
            Excel::import(new ContactsImport, $request->file('file'));
            return ResponseHelper::Out(true, 'Contacts Imported Successfully', 200);
        }catch(Exception $e){
            return ResponseHelper::Out(false,'Request Failed', 500);
        }
    }
    // Import contacts from Excel End ***********************************
}
