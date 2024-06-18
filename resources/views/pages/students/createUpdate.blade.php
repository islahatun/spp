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
                    <div class="breadcrumb-item active"><a href="#">Siswa</a></div>
                    <div class="breadcrumb-item"><a href="#">Daftar Siswa</a></div>
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
                                <h4>Form Siswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="col col-5">
                                        <form action="" method="post" id="formSiswa">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user?$user->id:'' }}">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" name="username" value="{{ $user?$user->username:'' }}"
                                                    class="form-control" >
                                            </div>
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" name="name" value="{{ $user?$user->name:'' }}"
                                                    class="form-control" >
                                            </div>
                                            <div class="form-group">
                                                <label>Kelas</label>
                                                <input type="text" name="kelas" value="{{ $user?$user->kelas:"" }}"
                                                    class="form-control" >
                                            </div>

                                            <div class="form-group">
                                                <label>No Hp</label>
                                                <input type="no_telp" name="no_telp" value="{{ $user?$user->no_telp:"" }}"
                                                    class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>E-Mail</label>
                                                <input type="email" name="email" value="{{ $user?$user->email:"" }}"
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

        $("#formSiswa").submit(function (e) {
                        e.preventDefault();
                        var formData = new FormData(this);
                        $.ajax({
                            url: "{{ route('saveOrUpdate') }}",
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


        function back(){
            let url = "{{ route('students.index') }}";
           window.location.href = url;
        }





    </script>


@endpush
