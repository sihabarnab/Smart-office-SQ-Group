@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Challan </h1>
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
                    {{-- <form action="{{ route('company_wise_challan') }}" method="post"> --}}
                    @csrf
                    <div class="row mb-2">
                        <div class="col-12">
                            <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                <option value="0">--Select Company--</option>
                                @foreach ($user_company as $value)
                                    <option value="{{ $value->company_id }}">
                                        {{ $value->company_name }}</option>
                                @endforeach
                            </select>
                            <div id='err_cbo_company_id'>

                            </div>
                            @error('cbo_company_id')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <div class="row mb-2">
                        <div class="col-10">
                            <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                            <label for="AYC">Are you Confirm</label>
                        </div>
                        <div class="col-2">
                            <button type="Submit" id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                disabled>Search</button>
                        </div>
                    </div>
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
                        <table id="sales_dch_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Company.</th>
                                    <th>Invoice No.</th>
                                    <th>Customer Name</th>
                                    <th>Ref. Name</th>
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

    <div class="container-fluid" id='rr2'>
        <h3 class="m-2">Delivery Challan Not Final </h3>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="sales_dch_not_final_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Delivery challan No.</th>
                                    <th>Invoice No.</th>
                                    <th>Customer Name</th>
                                    <th>Delivery Address</th>
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
            $('#rr2').hide();
        };

        function callset() {
            $('#er_company').hide();
            var company_id = $('#cbo_company_id').val();

            if (company_id) {
                getrrlist(company_id);
                getdchnotfinallist(company_id);
            } else {
                $("#err_cbo_company_id").append("<div class='text-warning' id='er_company'>Select Company</div>");
            }
        } //end call set
    </script>

    <script>
        function getrrlist(company_id) {
            $('#rr').show();
            // $('#loader').show();
            var k = 1;
            $.ajax({
                url: "{{ url('/get/sales/dch_list') }}/" + company_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        // $('#loader').hide();
                        if ($.fn.DataTable.isDataTable("#sales_dch_list")) {
                            $('#sales_dch_list').DataTable().clear().destroy();
                        }
                    }
                    $('#sales_dch_list').dataTable({
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
                                "data": "company_name"
                            },
                            {
                                "data": "sim_id"
                            },
                            {
                                "data": "customer_name"
                            },
                            {
                                "data": "ref_name"
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return '<a target="_blank" href="{{ url('/') }}/sales/create_delivery_challan/' +
                                        data.sim_id + '/' + data.company_id +
                                        '">Create Challan</a>';
                                }
                            },
                        ], // end colume
                    }); // end dataTable
                }, // End Sucess
            }); // end Ajax
        } // end document
    </script>

    <script>
        function getdchnotfinallist(company_id) {
            $('#rr2').show();
            // $('#loader').show();
            var k = 1;
            $.ajax({
                url: "{{ url('/get/sales/dch_not_final_list') }}/" + company_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        // $('#loader').hide();
                        if ($.fn.DataTable.isDataTable("#sales_dch_not_final_list")) {
                            $('#sales_dch_not_final_list').DataTable().clear().destroy();
                        }
                    }
                    $('#sales_dch_not_final_list').dataTable({
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
                                    return data.delivery_chalan_master_id+'<br>'+data.dcm_date;
                                }
                            },
                            {
                                "data": "sim_id"
                            },
                            {
                                "data": "customer_name"
                            },
                            {
                                "data": "delivery_address"
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return '<a target="_blank" href="{{ url('/') }}/sales/delivery_challan_details/' +
                                        data.delivery_chalan_master_id + '/' + data.company_id +
                                        '">Next</a>';
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
        #sales_dch_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
        #sales_dch_not_final_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection
