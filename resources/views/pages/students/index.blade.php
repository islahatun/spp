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
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalSiswa">
                                            Launch demo modal
                                          </button>
                                    </div>
                                    <table class="table-striped table"
                                        id="table-1">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="text-center" width="40">#</th>
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


    <!-- Modal -->
<div class="modal fade" id="ModalSiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" id="form-student" method="post">
            @csrf
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">NISN</label>
                <div class="col-sm-10">
                  <input type="text" readonly class="form-control" name="nisn" id="nisn" >
                </div>
              </div>
              <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="name" id="name">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Kelas</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="kelas" id="kelas">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">No Hp</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="no_telp" id="no_telp">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">E-Mail</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="email" id="email">
                </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
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
                        $('#modal').modal('toggle');
                        $("#modal-title").html("New");

                        method = 'post';
                        formUrl = `teacher`;
        }

        function edit(obj) {
                        let idx = getSelectedRowDataTables(dt);
                        if (idx) {
                            let data = dt
                                .row(idx.row)
                                .data();
                            // reset form
                            $(fm).each(function () {
                                this.reset();
                            });

                            // mengambil data
                            $(fm).deserialize(data)

                            let id = data.id;

                            // setting title modal
                            $("#modal-title").html("Ubah")
                            // open modal
                            $('#modal').modal('toggle');

                            method = 'POST';
                            formUrl = `/updateTeacher`;
                        }
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
                "columns": [{
                    data: "DT_RowIndex",
                    orderable: true,
                    searchable: true
                }, {
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
                    return '<button class="btn btn-sm btn-primary" type="button" onclick="editData('+id+')">Edit</button>'
                },
                "targets": 5},
            ]
            });
        });

        function editData(obj){

        }





    </script>


@endpush
