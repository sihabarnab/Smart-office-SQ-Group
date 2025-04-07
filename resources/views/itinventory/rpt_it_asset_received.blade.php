@extends('layouts.itinventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">IT Asset Receiving Form</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $m_user_id = Auth::user()->emp_id;

       $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
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
                    </div><!-- /.row -->
                    <div class="row mb-2">
                        <div class="col-10">
                            &nbsp;
                        </div>
                        <div class="col-2">
                            <button type="Submit" id="save_event" class="btn btn-primary btn-block"
                                onclick="callset()">Search</button>
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
                        <table id="rpt_it_asset_received_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Company</th>
                                    <th>Employee</th>
                                    <th>Desig</th>
                                    <th>Date</th>
                                    <th>Action</th>
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
            // $('#loader').show();
            var k = 1;
            $.ajax({
                url: "{{ url('/get/rpt_it_asset_received_list') }}/" + company_id + '/' + form + '/' + to,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        // $('#loader').hide();
                        if ($.fn.DataTable.isDataTable("#rpt_it_asset_received_list")) {
                            $('#rpt_it_asset_received_list').DataTable().clear().destroy();
                        }
                    }
                    $('#rpt_it_asset_received_list').dataTable({
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
                                    return data.company_name;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.employee_name;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.desig_name;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.entry_date;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return '<a target="_blank" href="{{ url('/') }}/itinventory/rpt_it_asset_received_view/' +
                                        data.itasset_receiving_master_id + '/'  +
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
        #rpt_it_asset_received_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
@endsection
