<?php

namespace App\Http\Controllers\Admin;

use JavaScript;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.dashboard');
    }
}
