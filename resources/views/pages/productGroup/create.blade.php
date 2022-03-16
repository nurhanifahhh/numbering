@extends('layouts.app')

@section('title', 'Excelitas Tech | Create Product Group')

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
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    {{-- <div class="col-6">
                        <form action="{{ route('dashboard.archive.store.document') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Product Group</h3>
                                </div>

                                <form>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kategori</label>
                                                    <select class="form-control select2bs4">
                                                        <option selected="selected">Pilih Kategori</option>
                                                        <option>Alabama</option>
                                                        <option>Alaska</option>
                                                        <option>California</option>
                                                        <option>Delaware</option>
                                                        <option>Tennessee</option>
                                                        <option>Texas</option>
                                                        <option>Washington</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama"
                                                placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="numberCode">Kode Angka</label>
                                            <input type="number" class="form-control" id="numberCode"
                                                placeholder="XXXX">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

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
                                <h3 class="card-title">Product Group Management</h3>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-success mb-3" data-toggle="modal"
                                    data-target="#addUserModal">
                                    <i class="fas fa-plus mr-2"></i>Add Product Group
                                </button>
                                <table id="productListTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Number Code</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productGroup as $eachGroup)
                                            <tr>
                                                <td class="align-middle">{{ $eachGroup->name }}</td>
                                                <td class="align-middle">{{ $eachGroup->numberCode }}</td>
                                                <td class="align-middle text-center" width="20%">
                                                    <div class="form-group">
                                                        <button data-id="{{ $eachGroup->id }}" name="edit"
                                                            class="btn btn-success">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button data-id="{{ $eachGroup->id }}" name="delete"
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

    {{-- add product group modal --}}
    <form action="{{ route('dashboard.productgroup.store') }}" id="addUserForm" method="post">
        @csrf
        <div class="modal fade" id="addUserModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Product Group</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="category_id">
                                        <option hidden>Choose Category</option>
                                        @foreach ($category as $eachCategory)
                                            <option value="{{ $eachCategory->id }}">{{ $eachCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="numberCode">Number Code</label>
                            <input type="number" class="form-control" name="numberCode" id="numberCode"
                                placeholder="XXXX">
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
                        <h4 class="modal-title">Edit Product Group</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="category_id">
                                        <option hidden>Choose Category</option>
                                        @foreach ($category as $eachCategory)
                                            <option value="{{ $eachCategory->id }}">{{ $eachCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="numberCode">Number Code</label>
                            <input type="number" class="form-control" name="numberCode" id="numberCode"
                                placeholder="XXXX">
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
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //delete button action
            $(document).on("click", "table#productListTable button[name='delete']", function() {
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
                            url: `{{ route('dashboard.productgroup.destroy', ['']) }}/${id}`,
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
                                console.log(data)
                            }
                        })
                    }
                })
            })

            let editUserModal = $("div#editUserModal");
            let editUserForm = $("form#editUserForm");

            //edit button action
            $(document).on("click", "table#productListTable button[name='edit']", function() {
                let id = $(this).attr('data-id');

                $.ajax({
                    url: `{{ route('dashboard.productgroup.show', ['']) }}/${id}`,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    success: function(res) {
                        let data = res.data;
                        console.log(data)
                        editUserModal.find("select[name='category_id'] option").each(function() {
                            if ($(this).val() == data.category_id)
                                $(this).attr("selected", "selected");
                        });
                        editUserModal.find("input[name='name']").val(data.name);
                        editUserModal.find("input[name='numberCode']").val(data.numberCode);

                        editUserModal.modal("toggle");
                        editUserForm.attr("action",
                            `{{ route('dashboard.productgroup.update', ['']) }}/${id}`)
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
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
