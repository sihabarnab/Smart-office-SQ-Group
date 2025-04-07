@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product Group</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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

    <div class="container-fluid">
        @include('flash-message')
    </div>
    @if (isset($m_pg))
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div align="left" class="">
                        <h5>{{ 'Edit' }}</h5>
                    </div>
                    <form id="myForm" method="post" action="{{ route('inventorypgupdate', $m_pg->pg_id) }}">
                        @csrf
                        <div class="">
                            <div class="row mb-2">
                                <div class="col-4">
                                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                        <option value="">--Select Company--</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}"
                                                {{ $value->company_id == $m_pg->company_id ? 'selected' : '' }}>
                                                {{ $value->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div><!-- /.col -->
                                <div class="col-8">
                                    <input type="hidden" class="form-control" id="txt_pg_id" name="txt_pg_id"
                                        value="{{ $m_pg->pg_id }}">
                                    <input type="text" class="form-control" id="txt_pg_name" name="txt_pg_name"
                                        value="{{ $m_pg->pg_name }}">
                                    @error('txt_pg_name')
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
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                        disabled>Update</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div align="left" class="">
                        <h5>{{ 'Add' }}</h5>
                    </div>
                    <form id="myForm" method="post" action="{{ route('inventorypgstore') }}">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-4">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}">
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                            <div class="col-8">
                                <input type="text" class="form-control" id="txt_pg_name" name="txt_pg_name"
                                    value="{{ old('txt_pg_name') }}" placeholder="Product Group Name">
                                @error('txt_pg_name')
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
                                <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                    disabled>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @include('inventory.product_group_list')
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            getproductgrouplist();

            $('select[name="cbo_company_id"]').on('change', function() {
                getproductgrouplist();
            });
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

    <script>
        function getproductgrouplist() {
            var k = 1;
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get_all_product_group_list/') }}/" + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            if ($.fn.DataTable.isDataTable("#pg_data")) {
                                $('#pg_data').DataTable().clear().destroy();
                            }
                        }

                        $('#pg_data').dataTable({
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
                                        return data.pg_name;
                                    }

                                },
                                {
                                    data: null,
                                    render: function(data, type, full) {
                                        return '<a target="_blank" href="{{ url('/') }}/inventory/product_group/edit/' +
                                            data.pg_id + '/' + data
                                            .company_id +
                                            '"><i class="fas fa-edit"></i></a>';
                                    }
                                },
                            ], // end colume
                        }); // end dataTable
                    }, // End Sucess
                }); // end Ajax
            } else {
                if ($.fn.DataTable.isDataTable("#pg_data")) {
                    $('#pg_data').DataTable().clear().destroy();
                }
            }
        }
    </script>
@endsection
@section('css')
    #pg_data_filter {
    width: 100px;
    float: right;
    margin: 6px 150px 0px 0px;
    }
@endsection
