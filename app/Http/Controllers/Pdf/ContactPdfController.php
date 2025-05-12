<?php

namespace App\Http\Controllers\Pdf;

use App\Models\Contact;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class ContactPdfController extends Controller
{

// Export Contact to PDF Start ********************************
public function exportPdf()
{
    $contacts = Contact::all();

    $pdf = Pdf::loadView('pdf.contacts', compact('contacts'));

    // return $pdf->download('contacts.pdf');
    return $pdf->stream('contacts.pdf');
}
// Export Contact to PDF End ***********************************
}
