@extends('layouts.app')

@section('title', 'Excelitas Tech | Create Document')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        {{-- <h1 class="m-0">tes</h1> --}}
                        <a href="{{ route('dashboard.archive.index') }}" class="btn btn-secondary"><i
                                class="fas fa-arrow-left" aria-hidden="true"></i></a>
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
                        <form action="{{ route('dashboard.archive.store.document') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Dokumen</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select class="form-control" id="category" name="category_id">
                                                    <option hidden>Pilih Kategori</option>
                                                    @foreach ($category as $eachCategory)
                                                        <option value="{{ $eachCategory->id }}">
                                                            {{ $eachCategory->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @hasrole('Admin')
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <a href="{{ route('dashboard.category.create') }}"
                                                        class="btn btn-primary btn-block">
                                                        <i class="fas fa-plus"></i> Tambah Kategori
                                                    </a>
                                                </div>
                                            </div>
                                        @endhasrole
                                    </div>
                                    <div class="row" style="display:none" id="productContainer">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label>Product Group</label>
                                                <select class="form-control" id="productGroups" name="product_group_id">
                                                    <option selected="selected">Pilih Product Group</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        @hasrole('Admin')
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <a href="{{ route('dashboard.productgroup.create') }}"
                                                    class="btn btn-primary btn-block">
                                                    <i class="fas fa-plus"></i> Tambah Product Group
                                                </a>
                                            </div>
                                        </div>
                                        @endhasrole
                                    </div>
                                    <div class="form-group">
                                        <label for="docNumber">Doc. No</label>
                                        <input type="text" class="form-control" id="docNumber" name="docNumber"
                                            placeholder="..." readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="judul">Judul Doc.</label>
                                        <input type="text" class="form-control" id="judul" name="judul" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="edisi">Edisi</label>
                                        <input type="text" class="form-control" id="edisi" name="edisi" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="originator">Originator</label>
                                        <input type="text" class="form-control" id="originator" name="originator"
                                            placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="fileDocument">Attachment File</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="fileDocument"
                                                    name="fileDocument">
                                                <label class="custom-file-label" for="fileDocument">Choose
                                                    file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
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

            $('#category').on('change', () => {
                $('#docNumber').val('')
                var id = $('#category').val()
                $.ajax({
                    url: `{{ route('dashboard.archive.get.product', ['']) }}/${id}`,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    success: function(res) {
                        $('#productContainer').show()
                        $('#productGroups')
                            .find('option')
                            .remove()
                            .end()

                        $('#productGroups').append($('<option>', {
                            value: '',
                            text: 'Pilih Product Group',
                            hidden: true
                        }));
                        $.each(res.data, function(i, val) {
                            $('#productGroups').append($('<option>', {
                                value: val.id,
                                text: val.name
                            }));
                        });
                    },
                    error: function(res) {
                        $('#productContainer').show()
                        let data = res.responseJSON;
                        showNotification(data.message, "error", 3000);
                    }
                });
            })

            $('#productGroups').on('change', () => {
                $('#docNumber').val('')
                var category_id = $('#category').val()
                var product_id = $('#productGroups').val()

                $.ajax({
                    url: `{{ route('dashboard.archive.get.docnumber', ['', '']) }}/${category_id}/${product_id}`,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    success: function(res) {
                        $('#docNumber').val(res.data)
                    }
                });
            })

            $('#fileDocument').on('change', () => {
                var filename = $('#fileDocument').val().split('\\').pop();
                $('.custom-file-label').text(filename)
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
