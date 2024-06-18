<?php

namespace App\Http\Controllers;

use App\Models\TransTagihan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data = [
            'type_menu'     => 'dashboard',
            'users'         => User::where('role','Siswa')->count(),
            'belumLunas'    => TransTagihan::whereNull('status')->count(),
            'lunas'         => TransTagihan::whereNotNull('status')->count()
        ];
        return view('pages.dashboard.index',$data);
    }
}
