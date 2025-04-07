@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Return Sales Invoice </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
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


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="myForm" action="{{ route('return_invoice_details') }}" method="GET">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="">-Select Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}">{{ $value->company_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <select class="form-control" id="cbo_invoice_id" name="cbo_invoice_id">
                                        <option value="">-Select Invoice-</option>

                                    </select>
                                    @error('cbo_invoice_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_return_date" name="txt_return_date"
                                        value="{{ old('txt_return_date') }}" placeholder="Return Date."
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">

                                    @error('txt_return_date')
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
                                    <button type="Submit" id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Return Details
                                    </button>
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
            } else {
                $("#confirm_action").prop("disabled", true);
            }
            document.getElementById("myForm").submit();
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                var cbo_company_id = $(this).val();
                if (cbo_company_id != 0) {
                    $.ajax({
                        url: "{{ url('/get/sales/return_invoice_list/') }}/" + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            $('select[name="cbo_invoice_id"]').empty();
                            $('select[name="cbo_invoice_id"]').append(
                                '<option value="">-Select Invoice-</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_invoice_id"]').append(
                                    '<option value="' + value.sim_id + '">' +
                                    value.sim_id + '</option>');
                            });

                        },
                    });

                } else {
                    $('select[name="cbo_invoice_id"]').empty();
                }

            });
        });
    </script>
@endsection
