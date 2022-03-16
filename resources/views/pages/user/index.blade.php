@extends('layouts.app')

@section('title', 'Excelitas Tech | User Management')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manajemen Akun</li>
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
                    <div class="col">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">User Management</h3>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-success mb-3" data-toggle="modal"
                                    data-target="#addUserModal">
                                    <i class="fas fa-plus mr-2"></i>New User
                                </button>
                                <table id="userListTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    {{-- add user modal --}}
    <form action="{{ route('dashboard.user.store') }}" id="addUserForm" method="post">
        @csrf
        <div class="modal fade" id="addUserModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New User</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nama :</label>
                                    <input id="name" type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="username">Username :</label>
                                    <input id="username" type="text" name="username" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password">Password :</label>
                                    <input id="password" type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password_confirm">Confirm Password :</label>
                                    <input id="password_confirm" type="password" name="password_confirm"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="role">Role :</label>
                                    <select name="role" id="role" class="custom-select">
                                        <option value="">Pilih Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="User">User</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>

    {{-- edit user modal --}}
    <form id="editUserForm" method="POST">
        @csrf
        <div class="modal fade" id="editUserModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New User</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nama :</label>
                                    <input id="name" readonly type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="username">Username :</label>
                                    <input id="username" readonly type="text" name="username" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password">Password :</label>
                                    <input id="password" type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password_confirm">Confirm Password :</label>
                                    <input id="password_confirm" type="password" name="password_confirm"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="role">Role :</label>
                                    <select name="role" id="role" class="custom-select">
                                        <option value="">Pilih Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="User">User</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>
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
            let addUserModal = $("div#addUserModal");
            let editUserModal = $("div#editUserModal");
            let addUserForm = $("form#addUserForm");
            let editUserForm = $("form#editUserForm");

            let userListTable = $('#userListTable').DataTable({
                searching: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('dashboard.user.get.user-datatable') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                },
                columns: [{
                        data: 'name',
                        name: 'name',
                        defaultContent: "-"
                    },
                    {
                        data: 'username',
                        name: 'username',
                        defaultContent: "-"
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        defaultContent: "-",
                        render: function(data, type, row) {
                            return moment(data).format("LLL");
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        defaultContent: "-",
                        render: function(data, type, row) {
                            return moment(data).format("LLL");
                        }
                    },
                    {
                        data: 'roles',
                        name: 'roles.name',
                        defaultContent: "-",
                        render: function(data, type, row) {
                            switch (data) {
                                case "Admin":
                                    return `
                                <span class="badge badge-success">${data}</span>
                                `
                                    break;

                                case "User":
                                    return `
                                    <span class="badge badge-primary">${data}</span>
                                    `
                                    break;
                            }

                        }
                    },
                    {
                        render: function(data, type, row) {
                            return `
                            <div class="form-group">
                                <button data-id=${row.id} name="edit"  class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button data-id=${row.id} name="delete" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `
                        }
                    },

                ],
            });

            //submit form action
            addUserForm.on("submit", function(event) {
                event.preventDefault();
                let form = $(this);
                let url = $(this).attr("action");
                let data = $(this).serialize();

                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    success: function(res) {
                        showNotification(res.message, "success", 3000);
                        userListTable.ajax.reload();
                        addUserModal.modal("toggle");
                        form[0].reset();
                    },
                    error: function(res) {
                        let data = res.responseJSON;
                        showNotification(data.message, "error", 3000);
                    }
                })


            })


            editUserForm.on("submit", function(event) {
                event.preventDefault();
                let form = $(this);
                let url = $(this).attr("action");
                let data = $(this).serialize();

                $.ajax({
                    url: url,
                    type: "PUT",
                    data: data,
                    dataType: "JSON",
                    success: function(res) {
                        showNotification(res.message, "success", 3000);
                        userListTable.ajax.reload();
                        editUserModal.modal("toggle");
                        form[0].reset();
                    },
                    error: function(res) {
                        let data = res.responseJSON;
                        showNotification(data.message, "error", 3000);
                    }
                })


            })


            //delete button action
            $(document).on("click", "table#userListTable button[name='delete']", function() {
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
                            url: `{{ route('dashboard.user.destroy', ['']) }}/${id}`,
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            dataType: "JSON",
                            success: function(res) {
                                userListTable.ajax.reload();
                                showNotification(res.message, "success", 3000);
                            },
                            error: function(res) {
                                let data = res.responseJSON;
                                showNotification(data.message, "error", 3000);
                            }
                        })
                    }
                })
            })


            //edit button action
            $(document).on("click", "table#userListTable button[name='edit']", function() {
                let id = $(this).attr('data-id');

                $.ajax({
                    url: `{{ route('dashboard.user.show', ['']) }}/${id}`,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    success: function(res) {
                        let data = res.data;
                        editUserModal.find("input[name='name']").val(data.name);
                        editUserModal.find("input[name='username']").val(data.username);
                        editUserModal.find("input[name='password']").val("");
                        editUserModal.find("input[name='password_confirm']").val("");

                        editUserModal.find("select[name='role'] option").each(function() {
                            if (data.roles[0].name == $(this).val()) {
                                $(this).attr("selected", true);
                            } else {
                                $(this).removeAttr("selected");
                            }
                        })
                        editUserModal.modal("toggle");
                        editUserForm.attr("action",
                            `{{ route('dashboard.user.update', ['']) }}/${id}`)
                    }
                });
            });


        });
    </script>
@endpush


{{-- THIS STYLE ONLY RENDER FOR THIS PAGE --}}
@push('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
