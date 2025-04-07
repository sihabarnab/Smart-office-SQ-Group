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


    @if (isset($pro_indent_master))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data2" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Project</th>
                                        <th>Indent Category</th>
                                        <th>Indent No / Date</th>
                                        <th>Prepare By</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pro_indent_master as $key => $value)
                                        <tr>
                                            <td class="text-left align-top">{{ $key + 1 }}</td>
                                            <td class="text-left align-top">{{ $value->project_name }}</td>
                                            <td class="text-left align-top">{{ $value->category_name }}</td>
                                            <td class="text-left align-top">
                                                {{ $value->indent_no }} <br> {{ $value->entry_date }} </td>
                                            <td class="text-left align-top">{{ $value->employee_name }}</td>
                                            <td class="text-left align-top">
                                                @if ($value->status == '3')
                                                    <p>Approved</p>
                                                @else
                                                    <p>Not Approved</p>
                                                @endif
                                            </td>
                                            <td class="text-left align-top">
                                                <a
                                                    href="{{ route('indent_copy_details', [$value->indent_id, $value->company_id]) }}">Details View</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id='myForm' action="{{ route('indent_copy_search') }}" method="post">
                        @csrf

                        <div class="row mb-2">
                            <div class="col-4">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="0">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}">
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">
                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}" onchange="DateDiff(this.value)">

                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                        </div><!-- /.row -->

                        <div class="row">
                            <div class="col-10">
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                <label for="AYC">Are you Confirm</label>
                            </div>
                            <div class="col-2">
                                <button type="Submit" id="confirm_action" onclick="BTOFF()"  class="btn btn-primary btn-block" disabled>Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    @endif
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