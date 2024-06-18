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

    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Siswa</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Siswa</a></div>
                    <div class="breadcrumb-item"><a href="#">Daftar Siswa</a></div>
                </div>
            </div>

            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Siswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="mb-3 d-flex justify-content-end">
                                        <form id="import" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <div class="custom-file ">
                                                        <input type="file" class="custom-file-input" name="file" id="customFile">
                                                        <label class="custom-file-label" for="customFile">Import</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <button class="btn btn-primary" type="submit">Import</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-end">
                                        <button class="btn btn-success" onclick="manual(0)">Tambah</button>
                                    </div>
                                    <table class="table-striped table"
                                        id="table-1">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Nama</th>
                                                <th>Nisn</th>
                                                <th>Kelas</th>
                                                <th>No Telp</th>
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    <script>
        var fm = '#form-student'
        $("#import").submit(function (e) {
                        e.preventDefault();
                        var formData = new FormData(this);
                        $.ajax({
                            url: "{{ route('students.store') }}",
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

        function add(obj) {
                        // reset form
                        $(fm).each(function () {
                            this.reset();
                        });
                        $('#ModalSiswa').modal('toggle');
                        $("#modal-title").html("New");

                        method = 'post';
                        formUrl = `teacher`;
        }


        function remove(obj) {
                        let idx = getSelectedRowDataTables(dt);
                        if (idx) {
                            let data = dt
                                .row(idx.row)
                                .data();
                            let dv = data.id
                            let value = {
                                id: dv
                            }

                            Swal
                                .fire({
                                    title: 'Apakah anda yakin.?',
                                    text: "Data yang dihapus tidak dapat dikembalikan!",
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya!'
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            url: `/teacher/${dv}`,
                                            type: "DELETE",
                                            cache: false,
                                            data: {
                                                "_token": "{{ csrf_token() }}"
                                            },
                                            success: function (data, textStatus, jqXHR) {
                                                let table = $('#dt').DataTable();
                                                table
                                                    .ajax
                                                    .reload();
                                                toastr.success('Data sandi berhasil dihapus.');
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                                toastr.error('Data sandi gagal dihapus.');
                                            }
                                        });
                                    }
                                })

                        }
        }

        $("#form-student").submit(function (e) {
                        e.preventDefault();
                        var formData = new FormData(this);
                        $.ajax({
                            url: "{{ route('students.store') }}",
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
                    "url": "{{ route('pageStudent') }}",
                },
                "columns": [ {
                    data: "name",
                    orderable: true,
                    searchable: true
                }, {
                    data: "username",
                    orderable: true,
                    searchable: true
                }, {
                    data: "kelas",
                    orderable: true,
                    searchable: true
                }, {
                    data: "no_telp",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "index",
                    orderable: true,
                    searchable: true
                }],
                "columnDefs": [
                {"render": function ( data, type, row, meta ) {
                    let id = row.id
                    return `<button class="btn btn-sm btn-primary" type="button" onclick='manual(${id}, "${encodeURIComponent(JSON.stringify(row))}")'>Edit</button>`;
                },
                "targets": 4},
            ]
            });
        });

        function manual(id){
            let url = "{{ route('students.show', ['student' => ':studentId']) }}";
            url = url.replace(':studentId', id);
           window.location.href = url;
        }





    </script>


@endpush
