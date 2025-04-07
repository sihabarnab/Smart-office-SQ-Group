@extends('layouts.purchase_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Indent Copy</h1>
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
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form id="myForm" action="{{ route('indent_copy_master_store') }}" method="post">
                                @csrf
                                <input type="hidden" name="cbo_old_indent_no" id="cbo_old_indent_no" value="{{$pro_indent_master->indent_no}}">

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                            <option value="0">--Select Company--</option>
                                            @foreach ($user_company as $value)
                                                <option value="{{ $value->company_id }}" {{ $pro_indent_master->company_id == $value->company_id ? "selected":""}}>
                                                    {{ $value->company_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="cbo_project_name" id="cbo_project_name" class="form-control">
                                            <option value="0">--Select Project--</option>
                                            @foreach ($pro_project_name as $value)
                                                <option value="{{ $value->project_id }}" {{ $pro_indent_master->project_id == $value->project_id ? "selected":""}}>
                                                    {{ $value->project_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_project_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="cbo_indent_category" id="cbo_indent_category" class="form-control">
                                            <option value="0">--Select Indent Category--</option>
                                            @foreach ($pro_indent_category as $value)
                                                <option value="{{ $value->category_id }}" {{ $pro_indent_master->indent_category == $value->category_id ? "selected":""}}>
                                                    {{ $value->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_indent_category')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-10">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary btn-block" disabled>Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection
@section('script')
    <script>
        function BTON() {
            
            if ($('#confirm_action').prop('disabled')) {
                $("#confirm_action").prop("disabled", false);
            } else {
                $("#confirm_action").prop("disabled", true);
            }
        }
        function BTOFF() {
            if ($('#confirm_action').prop('disabled')) {
                $("#confirm_action").prop("disabled", true);
            }else{
                $("#confirm_action").prop("disabled", true);  
            }
            document.getElementById("myForm").submit();    
        }
    </script>
@endsection