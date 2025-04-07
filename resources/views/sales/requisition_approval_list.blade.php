@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sales Requisition Approval</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


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
                                    <option value="{{ $value->company_id }}"
                                        {{ session('company_id') == $value->company_id ? 'selected' : '' }}>
                                        {{ $value->company_name }}</option>
                                @endforeach
                            </select>
                            <div id='err_cbo_company_id'>

                            </div>
                            {{-- @error('cbo_company_id')
                    <div class="text-warning" >{{ $message }}</div>
                @enderror --}}
                        </div><!-- /.col -->
                        <div class="col-2 mt-1">
                            <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                            <label for="AYC">Are you Confirm</label>
                        </div>
                        <div class="col-2">
                            <button type="Submit" id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                 disabled>Next</button>
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
                        <table id="requisition_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Requisition No.</th>
                                    <th>Requisition Date</th>
                                    <th>Customer Name</th>
                                    <th>Prepared By</th>
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
            // $('#rr').hide();
            var set_company = $('#cbo_company_id').val();
            if (set_company != 0) {
                getrrlist(set_company);
            } else {
                $('#rr').hide();
            }
        };

        function callset() {
            $('#er_company').hide();
            var company_id = $('#cbo_company_id').val();

            if (company_id != 0) {
                getrrlist(company_id);
            } else if (company_id == 0) {
                $("#err_cbo_company_id").append("<div class='text-warning' id='er_company'>Select Company</div>");
            }
        } //end call set
    </script>

    <script>
        function getrrlist(company_id) {
            $('#rr').show();
            var k = 1;
            $.ajax({
                url: "{{ url('/get/sales/requisition_not_approval_list') }}/" + company_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        if ($.fn.DataTable.isDataTable("#requisition_list")) {
                            $('#requisition_list').DataTable().clear().destroy();
                        }
                    }
                    $('#requisition_list').dataTable({
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
                                    return data.requisition_master_id;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.requisition_date;
                                }
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
                                    return '<a  href="{{ url('/') }}/sales/requisition_approved_details/' +
                                        data.requisition_master_id + '/' + data.company_id +
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
        #requisition_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection
