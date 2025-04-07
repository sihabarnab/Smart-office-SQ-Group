@extends('layouts.deed_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Document Information</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>
    @if(isset($m_doc_type))

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-5">{{ 'Edit' }}</h3>
                        <form action="{{ route('DeedDocInfoUpdate',$m_doc_type->doc_info_id) }}" method="Post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-10">
                                    <input type="text" class="form-control" id="txt_doc_info" name="txt_doc_info" placeholder="Document type" value="{{ $m_doc_type->doc_info_name }}">
                                    @error('txt_doc_info')
                                    <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-5">Add</h3>
                        <form action="{{ route('DeedDocInfoStore') }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-10">
                                    <input type="text" class="form-control" id="txt_doc_info"
                                        value="{{ old('txt_doc_info') }}" name="txt_doc_info" placeholder="Document type">
                                    @error('txt_doc_info')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <button type="Submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>  
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('/deed/doc_info_list')
    @endif 

@endsection
