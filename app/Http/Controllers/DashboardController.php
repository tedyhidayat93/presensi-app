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
        return view('pages.employee.dashboard');
    }
}
