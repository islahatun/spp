<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TransTagihan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\TransTagihanDetail;
use PDF;

class laporanController extends Controller
{
    public function index(){
        $data   = [
            'type_menu' => 'laporan'
        ];
        return view('pages.laporan.index',$data);
    }

    public function pageLunas(){
        $result = TransTagihan::with('user')->whereNotNull('status')->get();
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

            ->addColumn('username', function ($data) {
                return $data->user->username;
            })
            ->addColumn('name', function ($data) {
                return $data->user->name;
            })
            ->toJson();
    }
    public function pageBelumLunas(){
        $result = TransTagihan::with('user')->whereNull('status')->get();
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
            ->addColumn('jumlah_bulan', function ($data) {
                $detail = TransTagihanDetail::where('trans_tagihan_id', $data->id)->whereNull('payment')->count();

                return $detail." Bulan";
            })
            ->addColumn('username', function ($data) {
                return $data->user->username;
            })
            ->addColumn('name', function ($data) {
                return $data->user->name;
            })
            ->toJson();
    }
    public function cetakPdf($id){

        if($id == 2){
            $fileName   = 'Lapoaran-Pembayaran-Lunas.pdf';
            $view       = 'pages.laporan.cetakLaporanLunas';
            $detail     = TransTagihan::with('user')->whereNotNull('status')->get();
        }else{
            $fileName   = 'Lapoaran-Pembayaran-Belum-Lunas.pdf';
            $view       = 'pages.laporan.cetakLaporanBelumLunas';
            $detail     = TransTagihan::with('user','detail')->whereNull('status')->get()
                        ->map(function($transTagihan){
                            $totalDetail = $transTagihan->detail->sum('payment');
                            $count       = $transTagihan->detail->whereNull('payment')->count();

                            return [
                                'username'      => $transTagihan->user->username,
                                'name'          => $transTagihan->user->name,
                                'kelas'         => $transTagihan->user->kelas,
                                'tagihan'       => $transTagihan->total_billing - $totalDetail,
                                'jumlah_bulan'  => $count,
                            ];
                        });
        }
        $content    = [
            'detail'    => $detail,
        ];


        $pdf = PDF::loadview($view,$content);
    	return $pdf->download($fileName);

    }
}
