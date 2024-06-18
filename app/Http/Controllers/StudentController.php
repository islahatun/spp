<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data   = [
            'type_menu' => 'Student'
        ];
        return view('pages.students.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function page(){
        $result = User::where('role','Siswa')->get();

        return DataTables::of($result)->toJson();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "file" => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import( new UsersImport, $request->file("file"));

    }

    public function saveOrUpdate(Request $request){

        $validate = $request->validate([
            'username'  => 'required',
            'name'      => 'required',
            'kelas'     => 'required',
            'email'     => 'required',
            'no_telp'   => 'required'
        ]);
        $validate['role']       = 'Siswa';
        $validate['password']   = Hash::make('Password123');

        if($request->id){
            $result = User::where('id',$request->id)->update($validate);

        }else{
            $result = User::create($validate);
        }

        if($result){
            $message = array(
                'status' => true,
                'message' => 'Data Berhasil di simpan'
            );
        }else{
            $message = array(
                'status' => false,
                'message' => 'Data gagal disimpan'
            );
        }

        echo json_encode($message);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if($id != 0){
            $user   = User::find($id);
        }else{
            $user   = "";
        }
        $data   = [
            'type_menu' => 'Student',
            'user'      => $user
        ];
        return view('pages.students.createUpdate',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data   = [
            'type_menu' => 'Student',
            'data'      => User::find($id)
        ];
        return view('pages.students.createUpdate',$data);
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
        $result = User::where('id',$id)->delete();

        if($result){
            $message = array(
                'status' => true,
                'message' => 'Data berhasil di hapus'
            );
        }else{
            $message = array(
                'status' => false,
                'message' => 'Data gagal dihapus'
            );
        }

        echo json_encode($message);
    }
}
