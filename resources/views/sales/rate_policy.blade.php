@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rate Policy Add</h1>
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

    @if (isset($e_policy))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form id="myForm" action="{{ route('rate_policy_update', $e_policy->rate_policy_id) }}"
                                method="Post">
                                @csrf

                                <input type="hidden" name="cbo_company" value="{{ $e_policy->company_id }}">

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_policy_name"
                                            name="txt_policy_name" placeholder="Policy Name"
                                            value="{{ $e_policy->rate_policy_name }}">
                                        @error('txt_policy_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_rate_category" name="cbo_rate_category">
                                            <option value="0">--Rate Category--</option>
                                            <option value="1" {{ $e_policy->rate_group == 1 ? 'selected' : '' }}>A
                                            </option>
                                            <option value="2" {{ $e_policy->rate_group == 2 ? 'selected' : '' }}>B
                                            </option>

                                        </select>
                                        @error('cbo_rate_category')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_discount_type" name="cbo_discount_type">
                                            <option value="0">--Discount Type--</option>
                                            <option value="1" {{ $e_policy->discount_type == 1 ? 'selected' : '' }}>
                                                Percent</option>
                                            <option value="2" {{ $e_policy->discount_type == 2 ? 'selected' : '' }}>
                                                Fixed</option>



                                        </select>
                                        @error('cbo_discount_type')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-2">
                                        <input type="number" class="form-control" id="txt_discount" name="txt_discount"
                                            placeholder="Discount" value="{{ $e_policy->discount }}">
                                        @error('txt_discount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_remarks" name="txt_remarks"
                                            placeholder="Remarks" value="{{ $e_policy->remarks }}">
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
                            <form id="myForm" action="{{ route('rate_policy_store') }}" method="Post">
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
                                        <input type="text" class="form-control" id="txt_policy_name"
                                            name="txt_policy_name" placeholder="Policy Name"
                                            value="{{ old('txt_policy_name') }}">
                                        @error('txt_policy_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <select class="form-control" id="cbo_rate_category" name="cbo_rate_category">
                                            <option value="0">--Rate Category--</option>
                                            <option value="1">A</option>
                                            <option value="2">B</option>

                                        </select>
                                        @error('cbo_rate_category')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-2">
                                        <select class="form-control" id="cbo_discount_type" name="cbo_discount_type">
                                            <option value="0">--Discount Type--</option>
                                            <option value="1">Percent</option>
                                            <option value="2">Fixed</option>
                                        </select>
                                        @error('cbo_discount_type')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-2">
                                        <input type="number" class="form-control" id="txt_discount" name="txt_discount"
                                            placeholder="Discount" value="{{ old('txt_discount') }}">
                                        @error('txt_discount')
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
        @include('sales/rate_policy_list')
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

    <script>
        $(document).ready(function() {
            $('select[name="cbo_company"]').on('change', function() {
                getRatePolicy();
            });
        }); // end document

        function getRatePolicy() {
            var k = 1;
            var cbo_company = $('#cbo_company').val();
            if (cbo_company) {
                var k = 1;
                $.ajax({
                    url: "{{ url('/get/sales/policy_list') }}/" + cbo_company,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            // $('#loader').hide();
                            if ($.fn.DataTable.isDataTable("#policy_list")) {
                                $('#policy_list').DataTable().clear().destroy();
                            }
                        }
                        $('#policy_list').dataTable({
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
                                    "data": "rate_policy_name"
                                },
                                {
                                    data: null,
                                    render: function(data, type, full) {
                                        if (data.discount_type == 1) {
                                            return data.discount + '%';
                                        } else {
                                            return data.discount;
                                        }

                                    }
                                },
                                {
                                    "data": "remarks"
                                },
                                {
                                    data: null,
                                    render: function(data, type, full) {
                                        return '<a target="_blank" href="{{ url('/') }}/sales/rate_policy/edit/' +
                                            data.rate_policy_id + '/' + data.company_id +
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
        #policy_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection
