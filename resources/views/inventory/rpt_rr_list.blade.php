@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Receving Report</h1>
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
            ->Where('pro_company.inventory_status', '1')
            ->get();
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    {{-- <form action="{{ route('company_wise_list_for_rr') }}" method="post"> --}}
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
                            <div id='err_cbo_company_id'>

                            </div>
                            {{-- @error('cbo_company_id')
                                <div class="text-warning" >{{ $message }}</div>
                            @enderror --}}

                        </div><!-- /.col -->
                        <div class="col-3">
                            <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                placeholder="From Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                                onblur="if(this.value==''){this.type='text'}">
                            <div id='err_txt_form_date'>

                            </div>
                            @error('txt_from_date')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                placeholder="To Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                onblur="if(this.value==''){this.type='text'}">

                            <div id='err_txt_to_date'>

                            </div>
                            {{-- @error('txt_to_date')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror --}}
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


    <div class="container-fluid" id = 'rr'>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="rpt_rr_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-left align-top">SL No.</th>
                                    <th class="text-left align-top">Project/Indent Category</th>
                                    <th class="text-left align-top">Supply</th>
                                    <th class="text-left align-top">Indent No / Date</th>
                                    <th class="text-left align-top">RR No / Date</th>
                                    <th class="text-left align-top">Challan No / Date</th>
                                    <th class="text-left align-top">LC No / Date</th>
                                    <th class="text-left align-top">Remarks</th>
                                    <th class="text-left align-top"></th>
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

        }



        function getrrlist(company_id, form, to) {

            $('#rr').show();
            $('#loader').show();
            var k = 1;
            $.ajax({
                url: "{{ url('/get/rpt_rr_list') }}/" + company_id + '/' + form + '/' + to,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#loader').hide();

                        if ($.fn.DataTable.isDataTable("#rpt_rr_list")) {
                            $('#rpt_rr_list').DataTable().clear().destroy();
                        }
                    }

                    $('#rpt_rr_list').dataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        dom: 'Blfrtip',
                        buttons: [{
                                extend: 'csvHtml5',
                                title: 'Receiving Report'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Receiving Report'
                                // orientation: 'landscape',
                                // pageSize: 'LEGAL'
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
                                    return data.project_name + '<br>' + data.category_name;
                                }

                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.supplier_name + '<br>' + data
                                        .supplier_address;
                                }

                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.indent_no + '<br>' + data.indent_date;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.grr_no + '<br>' + data.grr_date;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.chalan_no + '<br>' + data.chalan_date;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.glc_no ? data.glc_no : "" + '<br>' + data
                                        .glc_date ? data.glc_date : '';
                                }
                            },
                            {
                                "data": "remarks"
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return '<a target="_blank" href="{{ url('/') }}/inventory/rpt_rr_list_details/' +
                                        data.grr_master_id + '/' + data.company_id +
                                        '">view / print</a>';
                                }
                            },
                        ], // end colume
                    }); // end dataTable
                }, // End Sucess
            }); // end Ajax
        }
    </script>
@endsection
@section('css')
    #rpt_rr_list_filter {
    width: 100px;
    float: right;
    margin: 6px 150px 0px 0px;
    }
@endsection
