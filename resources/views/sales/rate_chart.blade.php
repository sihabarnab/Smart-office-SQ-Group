@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rate Chart Add</h1>
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
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
    @endphp


    @if (isset($e_rate))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form id="myForm" action="{{ route('rate_chart_update', $e_rate->rate_chart_id) }}"
                                method="Post">
                                @csrf

                                <input type="hidden" name="cbo_company" value="{{ $e_rate->company_id }}">

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input class="form-control" value="{{ $e_rate->rate_group == 1 ? 'A' : 'B' }}"
                                            readonly>

                                    </div>
                                    <div class="col-5">

                                        <input class="form-control"
                                            value="{{ $product->product_name . ($product->model_size == null ? '' : "| $product->model_size") . ($product->product_description == null ? '' : "| $product->product_description") }}"
                                            readonly>

                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_unit_price" name="txt_unit_price"
                                            placeholder="Unit Price" value="{{ $e_rate->rate }}">
                                        @error('txt_unit_price')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_remarks" name="txt_remarks"
                                            placeholder="Remarks" value="{{ $e_rate->remarks }}">
                                        @error('txt_remarks')
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
                                            class="btn btn-primary btn-block" disabled>Update</button>
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
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form id="myForm" action="{{ route('rate_chart_store') }}" method="Post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_company" name="cbo_company">
                                            <option value="">--Select Company--</option>
                                            @foreach ($user_company as $value)
                                                <option value="{{ $value->company_id }}">
                                                    {{ $value->company_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('cbo_company')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_rate_category" name="cbo_rate_category">
                                            <option value="">--Rate Category--</option>
                                            <option value="1">A</option>
                                            <option value="2">B</option>

                                        </select>
                                        @error('cbo_rate_category')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_product_id" name="cbo_product_id">
                                            <option value="">--Product Name--</option>

                                        </select>
                                        @error('cbo_product_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_unit_price" name="txt_unit_price"
                                            placeholder="Unit Price" value="{{ old('txt_unit_price') }}">
                                        @error('txt_unit_price')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_remarks" name="txt_remarks"
                                            placeholder="Remarks" value="{{ old('txt_remarks') }}">
                                        @error('txt_remarks')
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
                                            class="btn btn-primary btn-block" disabled>Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sales/rate_chart_list')
        &nbsp;
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
            } else {
                $("#confirm_action").prop("disabled", true);
            }
            document.getElementById("myForm").submit();

        }
    </script>

    <script type="text/javascript">
        // customer address
        $(document).ready(function() {
            $('select[name="cbo_company"]').on('change', function() {
                getFinishProduct();
                getRateChart();

            });
        });
    </script>

    <script>
        function getFinishProduct() {
            var cbo_company = $('#cbo_company').val();
            if (cbo_company) {
                $.ajax({
                    url: "{{ url('/get_sales_finish_product_list') }}/" + cbo_company,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_product_id"]').empty();
                        $('select[name="cbo_product_id"]').append(
                            '<option value="">--Product Name--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_product_id"]').append(
                                '<option value="' + value.product_id + '">' +
                                value.product_name + ' | ' + (value.model_size ? value.model_size :
                                    "") + ' | ' + (
                                    value.product_description ? value.product_description : "") +
                                '</option>');
                        });
                    }
                });

            } else {
                $('#cbo_product_id').empty();
            }
        }
    </script>

    <script>
        function getRateChart() {
            $k = 1;
            var cbo_company = $('#cbo_company').val();
            if (cbo_company) {
                var k = 1;
                $.ajax({
                    url: "{{ url('/get/sales/chart_list') }}/" + cbo_company,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            // $('#loader').hide();
                            if ($.fn.DataTable.isDataTable("#rate_chart_list")) {
                                $('#rate_chart_list').DataTable().clear().destroy();
                            }
                        }
                        $('#rate_chart_list').dataTable({
                            "responsive": true,
                            "lengthChange": false,
                            "autoWidth": false,
                            order: [
                                [0, 'desc']
                            ],
                            dom: 'Blfrtip',
                            buttons: [{
                                    extend: 'csvHtml5',
                                    title: 'Quotation'
                                },
                                {
                                    extend: 'pdfHtml5',
                                    title: 'Quotation'
                                    // orientation: 'landscape',
                                    // pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'print',
                                    title: 'Quotation',
                                    autoPrint: true,
                                    exportOptions: {
                                        columns: ':visible'
                                    },
                                },
                                'colvis',
                            ],
                            "data": data,
                            "columns": [{
                                    data: null,
                                    render: function(data, type, full) {
                                        return k++;
                                    }
                                },
                                {
                                    "data": "company_name"
                                },
                                {
                                    data: null,
                                    render: function(data, type, full) {
                                        return data.rate_group == 1 ? 'A' : 'B';
                                    }
                                },
                                {
                                    "data": "product_name"
                                },
                                {
                                    "data": "rate"
                                },
                                {
                                    "data": "remarks"
                                },
                                {
                                    data: null,
                                    render: function(data, type, full) {
                                        return '<a target="_blank" href="{{ url('/') }}/sales/rate_chart/edit/' +
                                            data.rate_chart_id + '/' + data.company_id +
                                            '"><i class="fas fa-edit"></i></a>';
                                    }
                                },
                            ], // end colume
                        }); // end dataTable
                    }, // End Sucess
                }); // end Ajax                
            } //endif

        } //End function
    </script>
@endsection
@section('CSS')
    <style>
        #rate_chart_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection
