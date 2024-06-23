<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>

<body>

    <p>Yang terhormat saudara{{ $header['name'] }} - {{ $header['username'] }}</p>
    <p>Terimakasih telah melakukan pembayaran pada {{ $header['payment_date'] }}</p>
    <p>Berikut detail pembayaran :</p>
    <table border="0" cellspacing="0">
        <thead>
            <tr>
                <th>Nisn</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Bulan</th>
                <th>Tagihan</th>
                <th>Nomor Pembayaran</th>
                <th>Satus</th>
            </tr>
        <tbody>
            @foreach ($detail['data'] as $d)
                <tr>
                    <td>{{ $d->user->username }}</td>
                    <td>{{ $d->user->name }}</td>
                    <td>{{ date('M-Y', strtotime($d->user->payment_date)) }}</td>
                    <td>{{ $d->TagihanHeader->billing }}</td>
                    <td>{{ $d->order_id }}</td>
                    <td>{{ $d->payment?"Lunas":"Belum Lunas" }}</td>
                </tr>
            @endforeach

        </tbody>
        </thead>
    </table>
</body>

</html>
