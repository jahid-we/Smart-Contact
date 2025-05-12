<?php

namespace App\Http\Controllers\Excel;

use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class UserExcelController extends Controller
{
    //  Export User to Excel Start ********************************
    public function export()
    {
        return Excel::download(new UserExport, 'Users.xlsx');
    }
    // Export User to Excel End ***********************************
}
