@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Damage Stock</h1>
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
                        <div align="left" class=""></div>
                        <form id="myForm" action="{{ route('RptDamageStockList') }}" method="POST">
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
                                <div class="col-3">
                                    <div class="input-group date" id="sedate3" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" id="txt_month_from"
                                            name="txt_month_from" placeholder="From Year Month"
                                            value="{{ old('txt_month_from') }}" data-target="#sedate3">
                                        <div class="input-group-append" data-target="#sedate3" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('txt_month_from')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <div class="input-group date" id="sedate4" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" id="txt_month_to"
                                            name="txt_month_to" placeholder="To Year Month"
                                            value="{{ old('txt_month_to') }}" data-target="#sedate4">
                                        <div class="input-group-append" data-target="#sedate4" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('txt_month_to')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                        disabled>Submit</button>
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    &nbsp;
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
    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            // $('#loader').hide();
            $("select").select2();
        });
    </script>
    <script>
        $('#sedate3').datetimepicker({
            format: 'YYYY-MM'
        });
    </script>
    <script>
        $('#sedate4').datetimepicker({
            format: 'YYYY-MM'
        });
    </script>
@endsection
