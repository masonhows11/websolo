<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAdminsController extends Controller
{
    //
    public function index()
    {
        return view('dash.admin_admins.index');
    }
}
