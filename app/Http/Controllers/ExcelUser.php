<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;

class ExcelUser extends Controller
{
    public function export()
    {
        return (new UserExport())->download('users.xlsx');
    }
}
