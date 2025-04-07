@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Finish Product Serial</h1>
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
                        <form id="myForm" action="{{ route('finish_product_serial_store') }}" method="post">
                            @csrf
                            <div class="row mb-1">
                                <div class="col-3">
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
                                    <select class="form-control" id="cbo_product_id" name="cbo_product_id">
                                        <option value="">-Select Product-</option>

                                    </select>
                                    @error('cbo_product_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <div class="input-group date" id="sedate4" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" id="txt_year"
                                            name="txt_year" placeholder="Year" value="{{ old('txt_year') }}"
                                            data-target="#sedate4">
                                        <div class="input-group-append" data-target="#sedate4" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('txt_year')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>{{-- end row --}}

                            <div class="row">
                                <div class="col-3">
                                    <input type="number" class="form-control" id="txt_serial" name="txt_serial"
                                        placeholder="Serial No">
                                    @error('txt_serial')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <input type="number" class="form-control" id="txt_qty" name="txt_qty"
                                        placeholder="Qty">
                                    @error('txt_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row ">
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


    @if (session()->has('m_finish_product_serial'))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <div class="card-body">
                            <table id="data1" class="table table-border table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Company Name</th>
                                        <th>Product</th>
                                        <th>Serial No</th>
                                        <th>Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (session('m_finish_product_serial') as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->company_name }}</td>
                                            <td>{{ $row->product_name }}|{{ $row->model_size }}</td>
                                            <td>{{ $row->serial_no }}</td>
                                            <td>{{ $row->year }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif



@endsection
@section('script')
    <script>
        $('#sedate4').datetimepicker({
            format: 'YYYY'
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
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
