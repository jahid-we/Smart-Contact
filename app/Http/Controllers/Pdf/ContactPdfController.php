<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Barryvdh\DomPDF\Facade\Pdf;

class ContactPdfController extends Controller
{
    // Export Contact to PDF Start ********************************
    public function exportPdf()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 600);
        $contacts = Contact::all();

        $pdf = Pdf::loadView('pdf.contacts', compact('contacts'));

        // return $pdf->download('contacts.pdf');
        return $pdf->stream('contacts.pdf');
    }
    // Export Contact to PDF End ***********************************
}
