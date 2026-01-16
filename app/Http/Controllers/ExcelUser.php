<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelUser extends Controller
{
    public function export()
    {
        return Excel::download(new UserExport(), 'users.xlsx');
    }
}
