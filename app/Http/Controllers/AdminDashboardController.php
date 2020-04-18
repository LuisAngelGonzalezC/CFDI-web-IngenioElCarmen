<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin','revalidate']);
    }

    public function index()
    {
        return view('admin');
    }
}
