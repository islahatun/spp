<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Mail\testMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\TransTagihanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
}
