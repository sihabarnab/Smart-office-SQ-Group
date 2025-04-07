@extends('layouts.deed_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Document Upload</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-5">File Upload</h3>

                            <form action="{{ route('DeedDocFileStore') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cbo_deed_no">Deed No.</label>
                                            <input type="text" class="form-control" id="txt_deed_no"
                                            value="{{$pro_deed_masters->deed_no}}" name="txt_deed_no" readonly>
                                            @error('txt_deed_no')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror

                                            <input type="text" class="form-control" id="txt_moujas_id"
                                            value="{{$pro_deed_masters->moujas_id}}" name="txt_moujas_id" readonly>                                            
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cbo_doc_id">Document Type</label>
                                            <select name="cbo_doc_id" id="cbo_doc_id" class="form-control">
                                                <option value="">--Document Type--</option>
                                                @foreach ($pro_doc_infos as $pro_doc_info)
                                                    <option value="{{ $pro_doc_info->doc_info_id }}">
                                                        {{ $pro_doc_info->doc_info_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('cbo_doc_id')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="txt_doc_file">PDF</label>
                                            <input type="file" class="form-control" id="txt_doc_file"
                                                value="{{ old('txt_doc_file') }}" name="txt_doc_file" placeholder="Browse.."
                                                accept=".pdf">
                                            @error('txt_doc_file')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="form-control  bg-primary">Upload</button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
 

@endsection
