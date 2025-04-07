@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Remaining Serial Number List</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="myForm" action="{{ route('remaing_serial_list') }}" method="GET">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}"
                                            {{ old('cbo_company_id') == $value->company_id ? 'selected' : '' }}>
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                            <div class="col-3">
                                <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                    <option value="">--Product Group--</option>
                                    <option value="28" {{ old('cbo_transformer') == '28' ? 'selected' : '' }}>
                                        TRANSFORMER</option>
                                    <option value="33" {{ old('cbo_transformer') == '33' ? 'selected' : '' }}>CTPT
                                    </option>
                                </select>
                                @error('cbo_transformer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select name="cbo_product_id" id="cbo_product_id" class="form-control">
                                    <option value="">--Select Product--</option>
                                </select>
                                @error('cbo_product_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                            <div class="col-2">
                                <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Submit</button>
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                <label for="AYC">Are you Confirm</label>
                            </div>
                        </div><!-- /.row -->
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
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
            } else {
                $("#confirm_action").prop("disabled", true);
            }
            document.getElementById("myForm").submit();
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var cbo_transformer = $('select[name="cbo_transformer"]').val();
            var cbo_company_id = $('select[name="cbo_company_id"]').val();
            if (cbo_transformer && cbo_company_id) {
                GetProduct();
            }

            $('select[name="cbo_transformer"]').on('change', function() {
                GetProduct();
            });

            function GetProduct() {
                var cbo_transformer = $('select[name="cbo_transformer"]').val();
                var cbo_company_id = $('select[name="cbo_company_id"]').val();
                if (cbo_transformer && cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/sales/cbo_transformer_ctpt/') }}/" +
                            cbo_transformer + '/' + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_product_id"]').empty();
                            $('select[name="cbo_product_id"]').append(
                                '<option value="">-Select Product-</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_product_id"]').append(
                                    '<option value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_product_id"]').empty();
                }
            }
        });
    </script>
@endsection
