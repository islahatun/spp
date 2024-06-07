<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return User::updateOrCreate(
            ["username" => $row["0"]],
            [
            "username"  => $row["0"],
            "name"      => $row["1"],
            "kelas"     => $row["2"],
            "no_telp"   => $row["3"],
            "email"     => $row["4"],
            "role"      => "Siswa",
            "password"  => Hash::make("Password123")

        ]);
    }
}
