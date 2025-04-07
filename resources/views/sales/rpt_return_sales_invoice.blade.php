@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Return Sales Invoice</h1>
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

    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    {{-- <form action="{{ route('company_wise_list_for_rr') }}" method="post"> --}}
                    @csrf
                    <div class="row mb-2">
                        <div class="col-3">
                            <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                <option value="0">--Select Company--</option>
                                @foreach ($user_company as $value)
                                    <option value="{{ $value->company_id }}">
                                        {{ $value->company_name }}</option>
                                @endforeach
                            </select>
                            <div id='err_cbo_company_id'>

                            </div>
                        </div><!-- /.col -->

                        <div class="col-3">
                            <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                <option value="">--Product Group--</option>
                                <option value="28" {{ old('cbo_transformer') == '28' ? 'selected' : '' }}>
                                    TRANSFORMER</option>
                                <option value="33" {{ old('cbo_transformer') == '33' ? 'selected' : '' }}>CTPT
                                </option>
                            </select>
                            <div id='err_cbo_transformer'>
                            </div>
                        </div>

                        <div class="col-2">
                            <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                placeholder="From Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                                onblur="if(this.value==''){this.type='text'}">
                            <div id='err_txt_form_date'>

                            </div>
                            @error('txt_from_date')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                placeholder="To Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                onblur="if(this.value==''){this.type='text'}">

                            <div id='err_txt_to_date'>

                            </div>
                        </div>
                        <div class="col-2">
                            <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                disabled>Search</button>
                            <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                            <label for="AYC">Are you Confirm</label>
                        </div>
                    </div><!-- /.row -->

                    {{-- </form> --}}
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid" id='rr'>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="gate_pass_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Return Invoice No.</th>
                                    <th>Return Invoice Date</th>
                                    <th>Sales Invoice No</th>
                                    <th>Customer Name</th>
                                    <th>Prepare By</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
            $('#AYC').prop('checked', false);
            callset();
        }
    </script>

    <script>
        window.onload = function() {
            $('#rr').hide();
        };

        function callset() {
            $('#err_to').hide();
            $('#err_form').hide();
            $('#er_company').hide();
            var company_id = $('#cbo_company_id').val();
            var x = $('#txt_from_date').val();
            var y = $('#txt_to_date').val();
            console.log(x);

            if (company_id != 0) {
                if (x && y) {
                    var form = x;
                    var to = y;
                    getrrlist(company_id, form, to);

                } else if (x && y.length == 0) {
                    $("#err_txt_to_date").append("<div class='text-warning' id='err_to'> To date is required</div>");
                } else if (y && x.length == 0) {
                    $("#err_txt_form_date").append("<div class='text-warning' id='err_form'> Form date is required</div>");
                } else {
                    var form = 0;
                    var to = 0;
                    getrrlist(company_id, form, to);
                }
            } else if (company_id == 0 && x.length == 0 && y.length == 0) {
                $("#err_txt_to_date").append("<div class='text-warning id='err_to'> To date is required</div>");
                $("#err_txt_form_date").append("<div class='text-warning' id='err_form'> Form date is required</div>");
                $("#err_cbo_company_id").append("<div class='text-warning' id='er_company'>Select Company</div>");
            } else {
                $("#err_cbo_company_id").append("<div class='text-warning' id='er_company'>Select Company</div>");
            }
        } //end call set
    </script>

    <script>
        function getrrlist(company_id, form, to) {
            $('#rr').show();
            var cbo_transformer = $('#cbo_transformer').val();
            if (cbo_transformer) {
                var product_group = cbo_transformer;
            } else {
                var product_group = 0;
            }
            var k = 1;
            $.ajax({
                url: "{{ url('/get/sales/rpt_return_invoice_list') }}/" + company_id + '/' + form + '/' + to + '/' +
                    product_group,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        // $('#loader').hide();
                        if ($.fn.DataTable.isDataTable("#gate_pass_list")) {
                            $('#gate_pass_list').DataTable().clear().destroy();
                        }
                    }
                    $('#gate_pass_list').dataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
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
                                data: null,
                                render: function(data, type, full) {
                                    return data.rsim_id;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.rsim_date;
                                }
                            },
                            {
                                "data": "sim_id"
                            },
                            {
                                "data": "customer_name"
                            },
                            {
                                "data": "employee_name"
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return '<a target="_blank" href="{{ url('/') }}/sales/rpt_return_sales_invoice_view/' +
                                        data.rsim_id + '/' + data.company_id +
                                        '">view/print</a>';
                                }
                            },
                        ], // end colume
                    }); // end dataTable
                }, // End Sucess
            }); // end Ajax
        } // end document
    </script>
@endsection

@section('CSS')
    <style>
        #gate_pass_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection
