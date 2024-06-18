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
                <h1>Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Profile</a></div>
                    <div class="breadcrumb-item"><a href="#">profile</a></div>
                </div>
            </div>

            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="col col-5">
                                        <form action="" method="post" id="profile">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" name="username" value="{{ $user->username }}"
                                                    class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" name="name" value="{{ $user->name }}"
                                                    class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Kelas</label>
                                                <input type="text" name="kelas" value="{{ $user->kelas }}"
                                                    class="form-control" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password"
                                                    class="form-control">
                                            </div>

                                            <div>
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
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

        $("#billing").keyup(function(){
            let startDate       = moment($("#startDate").val());
            let endDate         = moment($("#endDate").val());
            let monthDefference = endDate.diff(startDate,"months");
            let total_Billing   = $("#billing").val()*monthDefference;
            $("#total_billing").val(total_Billing);
            $("#total_billing_desc").val(total_Billing);
        })
        $("#profile").submit(function (e) {
                        e.preventDefault();
                        var formData = new FormData(this);
                        $.ajax({
                            url: "{{ route('ubahPassword') }}",
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
                    "url": "{{ route('pageSpp') }}",
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
                    return `<button class="btn btn-sm btn-primary" type="button" onclick='detail(${id})'>Detail</button>`;
                },
                "targets": 5},
            ]
            });
        });

        function detail(id){
            let url = "{{ route('spp.show', ['spp' => ':sppId']) }}";
            url = url.replace(':sppId', id);
           window.location.href = url;
        }





    </script>


@endpush
