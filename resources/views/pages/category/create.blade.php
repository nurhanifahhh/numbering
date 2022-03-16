@extends('layouts.app')

@section('title', 'Excelitas Tech | Create Category')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        {{-- <h1 class="m-0">tes</h1> --}}
                        <a href="{{ route('dashboard.archive.create') }}" class="btn btn-secondary"><i
                                class="fas fa-arrow-left" aria-hidden="true"></i></a>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    {{-- <div class="col-6">
                        <form action="{{ route('dashboard.category.store') }}" method="POST">
                            @csrf
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Dokumen</h3>
                                </div>

                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama">Nama Kategori</label>
                                            <input type="text" class="form-control" name="nama" id="nama" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="code">Kode Kategori</label>
                                            <input type="text" class="form-control" name="code" id="code" placeholder="">
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </form>
                    </div> --}}
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Category Management</h3>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-success mb-3" data-toggle="modal"
                                    data-target="#addUserModal">
                                    <i class="fas fa-plus mr-2"></i>Add Category
                                </button>
                                <table id="categoryListTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($category as $eachCategory)
                                            <tr>
                                                <td class="align-middle">{{ $eachCategory->name }}</td>
                                                <td class="align-middle">{{ $eachCategory->code }}</td>
                                                <td class="align-middle text-center" width="20%">
                                                    <div class="form-group">
                                                        <button data-id="{{ $eachCategory->id }}" name="edit"
                                                            class="btn btn-success">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button data-id="{{ $eachCategory->id }}" name="delete"
                                                            class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>

    {{-- add user modal --}}
    <form action="{{ route('dashboard.category.store') }}" id="addUserForm" method="post">
        @csrf
        <div class="modal fade" id="addUserModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Name :</label>
                                    <input id="name" type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="code">Code :</label>
                                    <input id="code" type="text" name="code" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
                        <h4 class="modal-title">Edit Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Name :</label>
                                    <input id="name" type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="code">Code :</label>
                                    <input id="code" type="text" name="code" class="form-control">
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
    <script>
        $(function() {
            //delete button action
            $(document).on("click", "table#categoryListTable button[name='delete']", function() {
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
                            url: `{{ route('dashboard.category.destroy', ['']) }}/${id}`,
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            dataType: "JSON",
                            success: function(res) {
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

            
            let editUserModal = $("div#editUserModal");
            let editUserForm = $("form#editUserForm");
            
            //edit button action
            $(document).on("click", "table#categoryListTable button[name='edit']", function() {
                let id = $(this).attr('data-id');

                $.ajax({
                    url: `{{ route('dashboard.category.show', ['']) }}/${id}`,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    success: function(res) {
                        let data = res.data;
                        console.log(data)
                        editUserModal.find("input[name='name']").val(data.name);
                        editUserModal.find("input[name='code']").val(data.code);

                        editUserModal.modal("toggle");
                        editUserForm.attr("action",
                            `{{ route('dashboard.category.update', ['']) }}/${id}`)
                    }
                });
            });

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
                        location.reload();
                        // editUserModal.modal("toggle");
                        // form[0].reset();
                    },
                    error: function(res) {
                        let data = res.responseJSON;
                        showNotification(data.message, "error", 3000);
                    }
                })


            })

        })
    </script>
@endpush


{{-- THIS STYLE ONLY RENDER FOR THIS PAGE --}}
@push('style')
@endpush
