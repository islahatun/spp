<?php

namespace App\Http\Controllers;

use App\Models\TransTagihan;
use Carbon\Carbon;

use App\Models\User;
use Illuminate\Http\Request;

class TransTagihanController extends Controller
{
    public function index(){
        return view();
    }

    public function getData(){

    }

    public function saveOrUpdate(Request $request){
        $users      = User::all();
        $startDate  = $request->startDate();
        $endDate    = $request->endDate();
        list($start_year, $start_month, $start_day) = explode('-',$startDate);
        list($end_year, $end_month, $end_day) = explode('-',$endDate);

        $startDate      = Carbon::create($start_year,(int)$start_month, (int)$start_day);
        $endDate        = Carbon::create($end_year,(int)$end_month, (int)$end_day);
        $currentDate    = $startDate->copy();

        foreach($users as $u){
            $dataUser   = [
                'user_id'       => $u->id,
                'kelas'         => $u->kelas,
                'from_date'     => $request->from_date,
                'to_date'       => $request->to_date,
                'billing'       => $request->billing,
                'total_billing' => $request->total_billing
            ];

            TransTagihan::create($dataUser);
        }



    }
}
