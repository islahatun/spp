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
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Laporan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Laporan</a></div>
                    <div class="breadcrumb-item"><a href="#">Laporan Pembayaran</a></div>
                </div>
            </div>

            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Lpaoran Pembayaran Belum Lunas</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="mb-3 d-flex justify-content-end">
                                        <button class="btn btn-success" onclick="print(1)">Cetak</button>
                                    </div>

                                    <table class="table-striped table"
                                        id="table-1">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Nisn</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Tagihan</th>
                                                <th>Jumlah bulan belum lunas</th>
                                                <th>Satus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Lpaoran Pembayaran Lunas</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="mb-3 d-flex justify-content-end">
                                        <button class="btn btn-success" onclick="print(2)">Cetak</button>
                                    </div>

                                    <table class="table-striped table"
                                        id="table-2">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Nisn</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Satus</th>
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


        $(document).ready(function() {
            var dt = $('#table-1').DataTable({
                "destroy": true,
                "processing": true,
                "select": true,
                // "scrollX": true,
                "ajax": {
                    "url": "{{ route('pageLaporanBelumLunas') }}",
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
                }, {
                    data: "tagihan",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "jumlah_bulan",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "status",
                    orderable: true,
                    searchable: true,
                }]
            });

            var dt2 = $('#table-2').DataTable({
                "destroy": true,
                "processing": true,
                "select": true,
                // "scrollX": true,
                "ajax": {
                    "url": "{{ route('pageLaporanLunas') }}",
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
                    data: "status",
                    orderable: true,
                    searchable: true,
                }]
            });
        });

        function print(id){
            let url = "{{ route('cetakPdf', ['id' => ':sppId']) }}";
            url = url.replace(':sppId', id);
           window.location.href = url;
        }





    </script>


@endpush
