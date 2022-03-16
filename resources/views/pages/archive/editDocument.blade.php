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
                        <form action="{{ route('dashboard.archive.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="document_id" value="{{ $document->id }}">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Dokumen</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select class="form-control" disabled id="category" name="category_id">
                                                    <option hidden>Pilih Kategori</option>
                                                    @foreach ($category as $eachCategory)
                                                        <option value="{{ $eachCategory->id }}"
                                                            {{ $eachCategory->id == $document->category_id ? 'selected' : '' }}>
                                                            {{ $eachCategory->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="productContainer">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Product Group</label>
                                                <select class="form-control" disabled id="productGroups"
                                                    name="product_group_id">
                                                    @foreach ($document->category->productGroups as $eachProduct)
                                                        <option value="{{ $eachProduct->id }}"
                                                            {{ $eachProduct->id == $document->product_group_id ? 'selected' : '' }}>
                                                            {{ $eachProduct->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="docNumber">Doc. No</label>
                                        <input type="text" class="form-control" id="docNumber" name="docNumber"
                                            placeholder="..." readonly value="{{ $document->docNumber }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="judul">Judul Doc.</label>
                                        <input type="text" class="form-control" id="judul" name="judul" placeholder=""
                                            value="{{ $document->judul }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edisi">Edisi</label>
                                        <input type="text" class="form-control" id="edisi" name="edisi" placeholder=""
                                            value="{{ $document->edisi }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="originator">Originator</label>
                                        <input type="text" class="form-control" id="originator" name="originator"
                                            placeholder="" value="{{ $document->originator }}">
                                    </div>
                                    @if (!empty($document->fileDocument))
                                        <div id="fileDocument">
                                            <p class="text-bold mb-2">File Dokumen</p>
                                            <a href="/fileDocument/{{ $document->fileDocument }}" target="_blank"
                                                class="btn btn-info">Unduh
                                                Dokumen</a>
                                            <button type="button" id="uploadFile" class="btn btn-danger">Ganti</button>
                                        </div>
                                    @endif
                                    <div class="row form-group" style="display:none" id="uploadForm">
                                        <div class="col-4">
                                            <label for="fileDocument">Attachment File</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" onchange="textFormChange()"
                                                        id="fileDocumentField" name="fileDocument">
                                                    <label class="custom-file-label" for="fileDocument">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col">
                                            <p class="text-bold mb-2">&nbsp;</p>
                                            <button type="button" id="batalUploadFile" class="btn btn-danger">Batal</button>
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

            $('#uploadFile').on('click', () => {
                $('#uploadForm').show()
                $('#fileDocument').hide()
            })
            $('#batalUploadFile').on('click', () => {
                $('#uploadForm').hide()
                $('#fileDocument').show()
            })


        })

        function textFormChange() {
            var filename = $('#fileDocumentField').val().split('\\').pop();
            $('.custom-file-label').text(filename)
        }
    </script>
@endpush


{{-- THIS STYLE ONLY RENDER FOR THIS PAGE --}}
@push('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
