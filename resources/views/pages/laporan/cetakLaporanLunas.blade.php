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
            <td>Nama Sekolah</td>
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
