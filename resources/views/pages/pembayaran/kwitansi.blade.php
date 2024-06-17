<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
</head>
<body>
    <table border="1" width="100%" cellspacing="0">
        <tr>
           <td>Nama Sekolah</td>
        </tr>
        <tr>
            <td>
                <center><b>KWITANSI PEMBAYARAN SPP</b></center>
            </td>
        </tr>
        <tr>
            <td>
                <center>Nomor Pembayaran : {{ $detail->order_id }}</center>
                <div>
                    <table border="0">
                        <tr>
                            <td>Sudah diterima dari</td>
                            <td>: {{ $detail->user->username }} - {{ $detail->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Uang sebesar</td>
                            <td>: Rp .{{ $detail->payment }}</td>
                        </tr>
                        <tr>
                            <td>Sebagai pembayaran </td>
                            <td>: SPP pada bulan {{ $bulan->translatedFormat('F') }}</td>
                        </tr>
                    </table>
                    <center>
                        <table width="100%" border="0">
                            <tr>
                                <td>
                                    <p></p>
                                    <p>Yang Memberi,</p>
                                    <p>Siswa</p>
                                    <br>
                                    <br>
                                    <p>{{ $detail->user->name }}</p>
                                </td>
                                <td>
                                    <p>{{ date('d,M Y') }}</p>
                                    <p>Yang Menerima,</p>
                                    <p>Keuangan</p>
                                    <br>
                                    <br>
                                    <p>KEUANGAN</p></td>
                            </tr>
                        </table>
                    </center>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
