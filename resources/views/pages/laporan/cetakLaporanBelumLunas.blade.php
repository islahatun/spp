<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Daftar Siswa Belum Lunas</title>
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
                            <center>
                                PONDOK PESANTREN "AL-RAHMAH"
                                <p>Jl. Ciruas Petir, KM 6 Kel.Lebak Wangi, Kec. Walantaka-Kota Seang Banten</p>
                            </center>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <center>Daftar Siswa Belum Lunas Pembayaran </center>
            </td>
        </tr>
        <tr>
            <td>
                <table border="1" cellspacing="0" width="100%">
                    <tr style="text-align: center">
                        <td>NISN</td>
                        <td>NAMA</td>
                        <td>KELAS</td>
                        <td>TAGIHAN</td>
                        <td>JUMLAH BULAN BELUM LUNAS</td>
                    </tr>
                    @foreach ($detail as $d )
                    <tr>
                        <td>{{ $d['username'] }}</td>
                        <td>{{ $d['name'] }}</td>
                        <td>{{ $d['kelas'] }}</td>
                        <td>{{ $d['tagihan'] }}</td>
                        <td>{{ $d['jumlah_bulan'] }} Bulan</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
