<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\TransTagihan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\TransTagihanDetail;
use Illuminate\Support\Facades\DB;

class TransTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data   = [
            'type_menu' => 'Pembayaran'
        ];
        return view('pages.pembayaran.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function page()
    {
        $result = TransTagihan::with('user')->get();
        return DataTables::of($result)
            ->addColumn('status', function ($data) {
                $detail = TransTagihanDetail::where('trans_tagihan_id', $data->id)->sum('payment');
                $header = $data->total_billing;

                if ($header == $detail) {
                    $status = 'Lunas';
                } else {
                    $status = 'Belum Lunas';
                }
                return $status;
            })

            ->addColumn('tagihan', function ($data) {
                $detail = TransTagihanDetail::where('trans_tagihan_id', $data->id)->sum('payment');
                $header = $data->total_billing;

                return $header - $detail;
            })
            ->addColumn('username', function ($data) {
                return $data->user->username;
            })
            ->addColumn('name', function ($data) {
                return $data->user->name;
            })
            ->toJson();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $users      = User::all();
        $startDate  = $request->startDate;
        $endDate    = $request->endDate;
        list($start_year, $start_month, $start_day) = explode('-', $startDate);
        list($end_year, $end_month, $end_day) = explode('-', $endDate);

        $startDate      = Carbon::create($start_year, (int)$start_month, (int)$start_day);
        $endDate        = Carbon::create($end_year, (int)$end_month, (int)$end_day);


        // Buat array untuk menyimpan semua tanggal bulanan
        $allMonths = [];

        // Iterasi dari startDate ke endDate, satu bulan setiap iterasi
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $allMonths[] = $currentDate->toDateString(); // Simpan tanggal dalam format Y-m-d
            $currentDate->addMonth(); // Tambah satu bulan ke currentDate
        }




        DB::beginTransaction();
        try {
            foreach ($users as $u) {

                $dataUser   = [
                    'user_id'       => $u->id,
                    'kelas'         => $u->kelas,
                    'from_date'     => $request->startDate,
                    'to_date'       => $request->endDate,
                    'billing'       => $request->billing,
                    'total_billing' => $request->total_billing
                ];


                $transTagihan = TransTagihan::create($dataUser);
                // Iterasi semua tanggal bulanan antara startDate dan endDate
                foreach ($allMonths as $month) {
                    $dataTagihan = [
                        'trans_tagihan_id' => $transTagihan->id,
                        'user_id'          => $u->id,
                        'date'             => $month, // Gunakan tanggal dari array $allMonths
                    ];

                    TransTagihanDetail::create($dataTagihan);
                }
            }
            $message = array(
                'status' => true,
                'message' => 'Data Berhasil di simpan'
            );

            DB::commit();
        } catch (\Throwable $th) {

            $message = array(
                'status' => false,
                'message' => 'Data gagal di simpan'
            );

            DB::rollback();
        }

        echo json_encode($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data   = [
            'type_menu' => 'Pembayaran',
            'id'        => $id
        ];
        return view('pages.pembayaran.detail', $data);
    }

    public function pageDetail(Request $request)
    {

        $result = TransTagihanDetail::with('user', 'TagihanHeader')
            ->where('trans_tagihan_id', $request->id)->get();

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

    public function payment(Request $request)
    {

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

    public function callback(Request $request)
    {
        $serverKey  = env('midtrans.server_key');
        $hashed     = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture') {
                $payment    = TransTagihanDetail::whre('order_id',$request->order_id);
                $payment->update(['payment_date' => date(strtotime($request->transaction_time))]);
            }
        }
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
}