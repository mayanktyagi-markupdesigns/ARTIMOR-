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
        $data['totalActiveProducts'] = MasterProduct::where('status', 1)->count();
        $data['totalActiveUsers'] = User::where('status', 1)->count();
        $data['totalInactiveUsers'] = User::where('status', 0)->count();
        $data['totalActiveQuotations'] = Quotation::count();

        return view('admin.dashboard', $data);
    }
}
