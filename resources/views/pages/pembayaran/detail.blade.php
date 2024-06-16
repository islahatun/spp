@extends('layouts.app')

@section('title', 'DataTables')

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet"
        href="assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css"> --}}
        <!-- CSS Libraries -->
    <link rel="stylesheet"
    href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet"
    href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet"
    href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">

        <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pembayaran</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Pembayaran</a></div>
                    <div class="breadcrumb-item"><a href="#">SPP</a></div>
                    <div class="breadcrumb-item"><a href="#">Detail SPP</a></div>
                </div>
            </div>
            <div class="mb-3 d-flex justify-content-end">
                <button class="btn btn-dark" onclick="back()">Kembali</button>
            </div>

            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail SPP</h4>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table-striped table"
                                        id="table-1">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Nisn</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Bulan</th>
                                                <th>Tagihan</th>
                                                <th>Satus</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
        <!-- JS Libraies -->
        <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
        <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
        <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>

        <!-- Page Specific JS File -->
        {{-- <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script> --}}

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    <script>

        function back(){
            let url = "{{ route('spp.index') }}";
           window.location.href = url;
        }

        $("#form-spp").submit(function (e) {
                        e.preventDefault();
                        var formData = new FormData(this);
                        $.ajax({
                            url: "{{ route('spp.store') }}",
                            type: 'post',
                            data: formData,
                            processData: false,
                            contentType: false, // Pastikan konten tipe diatur ke false
                            success: function (data, textStatus, jqXHR) {

                                let view = jQuery.parseJSON(data);
                                if (view.status == true) {
                                    toastr.success(view.message);
                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);
                                } else {
                                    toastr.error(view.message);
                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);
                                }
                            },
                            error: function (reject) {

                                var response = $.parseJSON(reject.responseText);
                                $.each(response.errors, function (key, val) {
                                    $("#" + key + "_error").text(val[0]);
                                })

                            }

                        });
        });


        $(document).ready(function() {
            var dt = $('#table-1').DataTable({
                "destroy": true,
                "processing": true,
                "select": true,
                // "scrollX": true,
                "ajax": {
                    "url": "{{ route('pageSppDetail') }}",
                    "data":{
                        "id" : {{ $id }}
                    }
                },
                "columns": [ {
                    data: "username",
                    orderable: true,
                    searchable: true
                }, {
                    data: "name",
                    orderable: true,
                    searchable: true
                }, {
                    data: "kelas",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "bulan",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "tagihan",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "status",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "index",
                    orderable: true,
                    searchable: true,
                    class:"text-center"
                }],
                "columnDefs": [
                {"render": function ( data, type, row, meta ) {
                    let id = row.id
                    return '<button class="btn btn-sm btn-primary" type="button" onclick="bayar('+id+')">Bayar</button>';
                },
                "targets": 6},
            ]
            });
        });

        function bayar(id){
            $.ajax({
                    url: '{{ route('payment') }}',
                    type: 'post',
                    cache: false,
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        'id':id
                                    },
                    success: function(data, textStatus, jqXHR) {

                        let view = jQuery.parseJSON(data);
                        if (view.status == true) {


                            // For example trigger on button clicked, or any time you need;
                        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
                        window.snap.pay(''+view.token+'', {
                        onSuccess: function(result){
                            /* You may add your own implementation here */
                            alert("payment success!"); console.log(result);
                        },
                        onPending: function(result){
                            /* You may add your own implementation here */
                            alert("wating your payment!"); console.log(result);
                        },
                        onError: function(result){
                            /* You may add your own implementation here */
                            alert("payment failed!"); console.log(result);
                        },
                        onClose: function(){
                            /* You may add your own implementation here */
                            alert('you closed the popup without finishing the payment');
                        }
                        })


                        } else {
                            toastr.error(view.message);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(reject) {

                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function(key, val) {
                            $("#" + key + "_error").text(val[0]);
                        })

                    }

                });
        }





    </script>


@endpush
