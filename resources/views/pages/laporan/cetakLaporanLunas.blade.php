<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Daftar Lunas</title>
</head>
<body>
    <table border="1" cellspacing="0" width="100%">
        <tr>
            <td>
                <table border="0">
                    <tr>
                        <td>
                            <img src="{{ public_path('img/logo.png') }}" alt="" width="50px" height="50px" srcset="">
                        </td>
                        <td>
                            <center>PONDOK PESANTREN "AL-RAHMAH"</center>
                            <p>Jl. Ciruas Petir, KM 6 Kel.Lebak Wangi, Kec. Walantaka-Kota Seang Banten</p>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
        <tr>
            <td>
                <center>Daftar Siswa Lunas Pembayaran </center>
            </td>
        </tr>
        <tr>
            <td>
                <table border="1" cellspacing="0" width="100%">
                    <tr style="text-align: center">
                        <td>NISN</td>
                        <td>NAMA</td>
                        <td>KELAS</td>
                    </tr>
                    @foreach ($detail as $d )
                    <tr>
                        <td>{{ $d->user->username }}</td>
                        <td>{{ $d->user->name }}</td>
                        <td>{{ $d->user->kelas }}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
