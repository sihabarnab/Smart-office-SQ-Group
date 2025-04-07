@extends('layouts.purchase_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Indent List Report</h1>
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
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.purchase_status', '1')
            ->get();
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="myForm" action="{{ route('company_wise_indent_report') }}" method="post">
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
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                              <div class="col-3">
                                <input type="text" class="form-control" id="txt_from_date"
                                    name="txt_from_date" placeholder="From Date"
                                    value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">
                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                              </div>
                              <div class="col-3">
                                <input type="text" class="form-control" id="txt_to_date"
                                    name="txt_to_date" placeholder="To Date"
                                    value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}" onchange="DateDiff(this.value)">

                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                              </div>

                        </div><!-- /.row -->
                        <div class="row mb-2">
                            <div class="col-10">
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                            </div>
                            <div class="col-2">
                                <button type="Submit" id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    @if (isset($pro_indent_master))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data2" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Project</th>
                                        <th>Indent Category</th>
                                        <th>Indent No / Date</th>
                                        <th>Prepared By</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pro_indent_master as $key => $value)
                                        <tr>
                                            <td class="text-left align-top">{{ $key + 1 }}</td>
                                            <td class="text-left align-top">{{ $value->project_name }}</td>
                                            <td class="text-left align-top">{{ $value->category_name }}</td>
                                            <td class="text-left align-top">
                                                {{ $value->indent_no }} <br> {{ $value->entry_date }} </td>
                                            <td class="text-left align-top">{{ $value->user_id }}</td>
                                            <td class="text-left align-top">
                                                @if ($value->status == '3')
                                                    <p>Approved</p>
                                                @else
                                                    <p>Not Approved</p>
                                                @endif
                                            </td>
                                            <td class="text-left align-top">
                                                <a href="{{ route('purchase_indent_view',[$value->indent_id,$value->company_id]) }}">view /
                                                    print</a>
                                            </td>

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
            }else{
                $("#confirm_action").prop("disabled", true);  
            }
            document.getElementById("myForm").submit(); 
            
        }
    </script>
@endsection

{{-- 
@section('script')
    <script>
        window.onload = function() {
            var k = 1;
            $.ajax({
                url: "{{ url('/get/purchase/indent_list_report') }}/",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#loader').hide();
                    }
                    $('#indent_list_report').dataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        dom: 'Blfrtip',
                        buttons: [{
                                extend: 'csvHtml5',
                                title: 'Indent List Report'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Indent List Report'
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
                                "data": "project_name"
                            },
                            {
                                "data": "category_name"
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.indent_no + '<br>' + data.entry_date;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    if (data.status == 3) {
                                        return '<p>Approved</p>';
                                    } else {
                                        return '<p>Not Approved</p>';
                                    }
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return '<a href="{{ url('/') }}/purchase/indent_view/' +
                                        data.indent_id + '" target="_blank">view / print</a>';
                                }
                            },
                        ], // end colume
                    }); // end dataTable
                }, // End Sucess
            }); // end Ajax
        }; // end document
    </script>
@endsection --}}
{{-- @section('css')
    #indent_list_report_filter {
    width: 100px;
    float: right;
    margin: 6px 150px 0px 0px;
    }
@endsection --}}
