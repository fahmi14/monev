<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('kegiatan');
    }

    public function dashboard($kegiatan)
    {
    return view('dashboard.' . $kegiatan);
    }
}