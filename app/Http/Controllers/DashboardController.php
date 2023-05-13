<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InOut;
use App\Models\Izin;
use App\Models\Location;
use App\Models\SiteSetting;
use App\Helpers\General;
use Carbon\Carbon;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {     
        $head = [
            'title' => 'Dashboard',
            'head_title_per_page' => "Dashboard",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ]
            ]
        ];
        return view('pages.employee.dashboard', compact('head'));
    }
}
