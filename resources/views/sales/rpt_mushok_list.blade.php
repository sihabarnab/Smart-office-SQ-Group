@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Mushok </h1>
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
                        <div class="col-6">
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
                       
                        <div class="col-2">
                            <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Search</button>
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
                        <table id="delivary_challan_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Company Name</th>
                                    <th>Mushok Number</th>
                                    <th>Financial Year</th>
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
        window.onload = function() {
            $('#rr').hide();
        };

        function callset() {
            $('#er_company').hide();
            var company_id = $('#cbo_company_id').val();
            if (company_id != 0) {
                getrrlist(company_id);
             } 
            else {
                $("#err_cbo_company_id").append("<div class='text-warning' id='er_company'>Select Company</div>");
            }
        } //end call set
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
        $('#AYC').prop('checked', false);
        callset();
    }
</script>

    <script>
        function getrrlist(company_id) {
            $('#rr').show();
            // $('#loader').show();
            var k = 1;
            $.ajax({
                url: "{{ url('/get/sales/get_mushok_list') }}/" + company_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data) {
                        // $('#loader').hide();
                        if ($.fn.DataTable.isDataTable("#delivary_challan_list")) {
                            $('#delivary_challan_list').DataTable().clear().destroy();
                        }
                    }
                    $('#delivary_challan_list').dataTable({
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
                                "data": "mushok_number"
                            },
                            {
                                "data": "financial_year_name"
                            }
                            
                        ], // end colume
                    }); // end dataTable
                }, // End Sucess
            }); // end Ajax
        } // end document
    </script>
@endsection

@section('CSS')
    <style>
        #delivary_challan_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection
