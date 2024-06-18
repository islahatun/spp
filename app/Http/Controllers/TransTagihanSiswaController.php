<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use PDF;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\TransTagihanDetail;
use Illuminate\Support\Facades\Auth;

class TransTagihanSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data   = [
            'type_menu' => 'Pembayaran'
        ];
        return view('pages.pembayaran.pembayaranStudent', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function page(){
        $result = TransTagihanDetail::with('user', 'TagihanHeader')
            ->where('user_id',Auth::user()->id)->get();

        return DataTables::of($result)
            ->addColumn('status', function ($data) {
                $payment = $data->payment;

                if ($payment != null) {
                    $status = 'Lunas';
                } else {
                    $status = 'Belum Lunas';
                }
                return $status;
            })
            ->addColumn('order_id', function ($data) {
                return $data->order_id;
            })
            ->addColumn('tagihan', function ($data) {
                return $data->TagihanHeader->billing;
            })
            ->addColumn('kelas', function ($data) {
                return $data->TagihanHeader->kelas;
            })
            ->addColumn('username', function ($data) {
                return $data->user->username;
            })
            ->addColumn('name', function ($data) {
                return $data->user->name;
            })
            ->addColumn('bulan', function ($data) {
                $bulan = Carbon::parse($data->date);
                return $bulan->translatedFormat('F');
            })
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function payment(Request $request){
        $payment    = TransTagihanDetail::with('user', 'TagihanHeader')->find($request->id);
        /*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php) composer require midtrans/midtrans-php
        Alternatively, if you are not using **Composer**, you can download midtrans-php library (https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require the file manually.
        require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */
        //SAMPLE REQUEST START HERE
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');

        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $payment->order_id  = Str::random(10);
        $payment->save();

        $params = array(
            'transaction_details' => array(
                'order_id' => $payment->order_id,
                'gross_amount' => $payment->TagihanHeader->billing,
            ),
            'customer_details' => array(
                'nisn' => $payment->user->username,
                'name' => $payment->user->name,
                // 'email' => 'budi.pra@example.com',
                // 'phone' => '08111222333',
            ),
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $message = array(
            'status'  => true,
            'token' => $snapToken
        );

        // dd($snapToken);

        // return view('payment',compact('snapToken','paymnet'));
        echo json_encode($message);
    }
    // public function callback(Request $request)
    // {
    //     $serverKey  = env('midtrans.server_key');
    //     $hashed     = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

    //     if ($hashed == $request->signature_key) {
    //         if ($request->transaction_status == 'capture') {
    //             $payment    = TransTagihanDetail::whre('order_id',$request->order_id)->update(['payment_date' => date("Y-m-d")]);
    //             dd($request->order_id);

    //             if($payment){
    //                 $message = array(
    //                     'status' => true,
    //                     'message' => 'Pembayaran berhasil'
    //                 );
    //             }else{
    //                 $message = array(
    //                     'status' => false,
    //                     'message' => 'Data gagal mengirim data'
    //                 );
    //             }
    //         }


    //     }else{
    //         $message = array(
    //             'status' => false,
    //             'message' => 'Data gagal mengirim data'
    //         );

    //     }
    //     echo json_encode($message);
    // }

    public function kwitansi($id){
        $data       = TransTagihanDetail::with('user','TagihanHeader')->find($id);
        $bulan      = Carbon::parse($data->date);
        $content    = [
            'detail'    => TransTagihanDetail::with('user','TagihanHeader')->find($id),
            'bulan'     => Carbon::parse($data->date)
        ];

        $pdf = PDF::loadview('pages.pembayaran.kwitansi',$content);
    	return $pdf->download('Kwitansi '.$data->user->username. ' Bulan '. $bulan->translatedFormat('F').'.pdf');

    }
}
