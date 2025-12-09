<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterProduct;
use App\Models\Quotation;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {     
        $data['totalActiveUsers'] = User::count();
        return view('admin.dashboard', $data);
    }
}
