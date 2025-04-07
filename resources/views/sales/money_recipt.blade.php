@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Money Receipt</h1>
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
                            {{-- <h5>{{ 'Add' }}</h5> --}}
                        </div>
                        <form id="myForm" action="{{ route('money_receipt_master') }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="">-Select Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}" {{$value->company_id == old('cbo_company_id')}} >
                                                {{ $value->company_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_mr_type_id" name="cbo_mr_type_id">
                                        <option value="0">-Select Option-</option>
                                        <option value="1">Sales</option>
                                        <option value="2">Repair</option>
                                        <option value="3">Sundry</option>
                                    </select>
                                    @error('cbo_mr_type_id')
                                    <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2"> 
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                                <div class="col-2"><button type="Submit" id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Add details</button></div>
                                <div class="col-1"></div>
                            </div>

                                                    
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- @include('sales.money_recipt_not_final_list') --}}
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
            } else {
                $("#confirm_action").prop("disabled", true);
            }
            document.getElementById("myForm").submit();
        }
    </script>
@endsection
