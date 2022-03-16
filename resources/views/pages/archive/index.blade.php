@extends('layouts.app')

@section('title', 'Excelitas Tech | Document Archive')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Arsip Dokumen</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Archive Management</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Data Arsip Dokumen</h3>
                            </div>
                            <div class="card-body">

                                <a href="{{ route('dashboard.archive.create') }}" class="btn btn-success mb-3">
                                    <i class="fas fa-plus"></i>
                                    Tambah Dokumen
                                </a>
                                <table id="typeDocument" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Doc. Number</th>
                                            <th>Judul</th>
                                            <th>Edisi</th>
                                            <th>Originator</th>
                                            <th>File</th>

                                            @hasrole('Super Admin')
                                                <th width="10%" class="text-center">Aksi</th>
                                            @endhasrole
                                            @hasrole('Admin')
                                                <th width="10%" class="text-center">Aksi</th>
                                            @endhasrole
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document as $eachDocument)
                                            <tr>
                                                <td>
                                                    {{ $eachDocument->docNumber }}
                                                </td>
                                                <td>
                                                    {{ $eachDocument->judul }}

                                                </td>
                                                <td>
                                                    {{ $eachDocument->edisi }}

                                                </td>
                                                <td>
                                                    {{ $eachDocument->originator }}

                                                </td>
                                                <td>
                                                    <a href="/fileDocument/{{ $eachDocument->fileDocument }}"
                                                        class="btn btn-info">
                                                        Download
                                                    </a>
                                                </td>

                                                @hasrole('Super Admin')
                                                    <td class="align-middle text-center">
                                                        <div class="form-group">
                                                            <a href="{{ route('dashboard.archive.edit', $eachDocument->id) }}"
                                                                class="btn btn-success">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button data-id="{{ $eachDocument->id }}" name="delete"
                                                                class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                @endhasrole
                                                @hasrole('Admin')
                                                    <td class="align-middle text-center">
                                                        <div class="form-group">
                                                            <a href="{{ route('dashboard.archive.edit', $eachDocument->id) }}"
                                                                class="btn btn-success">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button data-id="{{ $eachDocument->id }}" name="delete"
                                                                class="btn btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                @endhasrole
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



@endsection

{{-- THIS SCRIPT ONLY RENDER FOR THIS PAGE --}}
@push('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE App -->

    <script>
        $(function() {
            // $("#example1").DataTable({
            //     "responsive": true,
            //     "lengthChange": false,
            //     "autoWidth": false,
            //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $("#typeDocument").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false
            })
            //delete button action
            $(document).on("click", "table#typeDocument button[name='delete']", function() {
                let id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "klik yes untuk menghapus akun.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('dashboard.archive.destroy', ['']) }}/${id}`,
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            dataType: "JSON",
                            success: function(res) {
                                // userListTable.ajax.reload();
                                showNotification(res.message, "success", 3000);
                                location.reload();
                            },
                            error: function(res) {
                                let data = res.responseJSON;
                                showNotification(data.message, "error", 3000);
                            }
                        })
                    }
                })
            })
        });
    </script>
@endpush


{{-- THIS STYLE ONLY RENDER FOR THIS PAGE --}}
@push('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
