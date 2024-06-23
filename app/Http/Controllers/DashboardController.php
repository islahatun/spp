<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TransTagihan;
use App\Models\TransTagihanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(){
        $billing    = TransTagihan::first();
        $totalBL    = TransTagihanDetail::whereNull('payment')->count();
        $totalL    = TransTagihanDetail::whereNotNull('payment')->count();
        $data = [
            'type_menu'     => 'dashboard',
            'users'         => User::where('role','Siswa')->count(),
            'belumLunas'    => TransTagihan::whereNull('status')->count(),
            'totalBL'       => $billing->billing*$totalBL,
            'totalL'        => $billing->billing*$totalL,
            'lunas'         => TransTagihan::whereNotNull('status')->count()
        ];
        return view('pages.dashboard.index',$data);
    }

    public function profile(){
        $data = [
            'type_menu'     => 'dashboard',
            'user'         => User::where('id',Auth::user()->id)->first(),
        ];
        return view('pages.dashboard.profile',$data);
    }
    public function ubahPassword(Request $request){

        $password   = Hash::make($request->password);

        $result = User::where('id',$request->id)->update(['password'=>$password]);

        if($result){
            $message = array(
                'status' => true,
                'message' => 'Data Berhasil diubah'
            );
        }else{
            $message = array(
                'status' => false,
                'message' => 'Data gagal diubah'
            );
        }

        echo json_encode($message);

    }
}
