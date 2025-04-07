@extends('layouts.sales_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($m_product))
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div align="left" class="">
                        <h5>{{ 'Edit' }}</h5>
                    </div>
                    <form id="myForm" action="{{ route('finish_product_update', $m_product->product_id) }}"
                        method="post">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                    <option value="">-Select Company-</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}"
                                            {{ $m_product->company_id == $value->company_id ? 'selected' : '' }}>
                                            {{ $value->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-3">
                                <select name="cbo_product_cat_id" id="cbo_product_cat_id" class="form-control">
                                    <option value="2">Finish Product</option>
                                </select>
                                @error('cbo_product_cat_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-3">
                                <select name="cbo_pg_id" id="cbo_pg_id" class="form-control">
                                    <option value="0">--Product Group--</option>
                                    @foreach ($m_product_group as $row_product_group)
                                        <option value="{{ $row_product_group->pg_id }}"
                                            {{ $row_product_group->pg_id == $m_product->pg_id ? 'selected' : '' }}>
                                            {{ $row_product_group->pg_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_pg_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-3">
                                <select name="cbo_pg_sub_id" id="cbo_pg_sub_id" class="form-control">
                                    <option value="0">Product Sub Group</option>

                                    @if ($m_product_sub_group == null)
                                        @php
                                            $m_product_sub_group_all = DB::table("pro_product_sub_group_$m_product->company_id")
                                                ->Where('pg_sub_id', $m_product->pg_sub_id)
                                                ->Where('valid', '1')
                                                ->get();
                                        @endphp
                                        @foreach ($m_product_sub_group_all as $row)
                                            <option value="{{ $row->pg_sub_id }}" >
                                                {{ $row->pg_sub_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="{{ $m_product_sub_group->pg_sub_id }}" selected>
                                            {{ $m_product_sub_group->pg_sub_name }}
                                        </option>
                                    @endif

                                </select>
                                @error('cbo_pg_sub_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="row mb-2">

                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_product_name" name="txt_product_name"
                                    placeholder="Product Name" value="{{ $m_product->product_name }}">
                                @error('txt_product_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_product_type" name="txt_product_type"
                                    value="{{ $m_product->product_type }}" placeholder="Product Type">
                                @error('txt_product_type')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_brand_name" name="txt_brand_name"
                                    placeholder="Brand Name" value="{{ $m_product->brand_name }}">
                                @error('txt_brand_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_model_size" name="txt_model_size"
                                    placeholder="Size / Model" value="{{ $m_product->model_size }}">
                                @error('txt_model_size')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" id="txt_product_description"
                                    name="txt_product_description" placeholder="Product Description"
                                    value="{{ $m_product->product_description }}">
                                @error('txt_product_description')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_unit_id" id="cbo_unit_id" class="form-control">
                                    <option value="0">Product Unit</option>
                                    @foreach ($m_unit as $row_unit)
                                        <option value="{{ $row_unit->unit_id }}"
                                            {{ $row_unit->unit_id == $m_product->unit ? 'selected' : '' }}>
                                            {{ $row_unit->unit_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_unit_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_reorder_qty" name="txt_reorder_qty"
                                    placeholder="Reorder Qty" value="{{ $m_product->reorder_qty }}">
                                @error('txt_reorder_qty')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select name="cbo_discount" id="cbo_discount" class="form-control">
                                    <option value="0">Discount</option>
                                    @foreach ($m_yesno as $row_discount)
                                        <option value="{{ $row_discount->yesno_id }}"
                                            {{ $row_discount->yesno_id == $m_product->get_discount ? 'selected' : '' }}>
                                            {{ $row_discount->yesno_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_discount')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select name="cbo_warrenty" id="cbo_warrenty" class="form-control">
                                    <option value="0">Warrenty</option>
                                    @foreach ($m_yesno as $row_warrenty)
                                        <option value="{{ $row_warrenty->yesno_id }}"
                                            {{ $row_warrenty->yesno_id == $m_product->warrenty ? 'selected' : '' }}>
                                            {{ $row_warrenty->yesno_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_warrenty')
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
                                <button type="submit" id="confirm_action" onclick="BTOFF()"
                                    class="btn btn-primary btn-block" disabled>Update</button>
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
                    <form id="myForm" method="post" action="{{ route('FinishProductStore') }}">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                    <option value="">-Select Company-</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}"
                                            {{ old('cbo_company_id') == $value->company_id ? 'selected' : '' }}>
                                            {{ $value->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-3">
                                <select name="cbo_product_cat_id" id="cbo_product_cat_id" class="form-control">
                                    <option value="2">Finish Product</option>
                                </select>
                                @error('cbo_product_cat_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select name="cbo_pg_id" id="cbo_pg_id" class="form-control">
                                    <option value="0">Product Group</option>

                                </select>
                                @error('cbo_pg_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select name="cbo_pg_sub_id" id="cbo_pg_sub_id" class="form-control">
                                    <option value="0">Product Sub Group</option>
                                </select>
                                @error('cbo_pg_sub_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-2">
                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_product_name" name="txt_product_name"
                                    value="{{ old('txt_product_name') }}" placeholder="Product Name">
                                @error('txt_product_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_product_type" name="txt_product_type"
                                    value="{{ old('txt_product_type') }}" placeholder="Product Type">
                                @error('txt_product_type')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_brand_name" name="txt_brand_name"
                                    value="{{ old('txt_brand_name') }}" placeholder="Brand Name">
                                @error('txt_brand_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4">
                                <input type="text" class="form-control" id="txt_model_size" name="txt_model_size"
                                    value="{{ old('txt_model_size') }}" placeholder="Size / Model">
                                @error('txt_model_size')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" id="txt_product_description"
                                    name="txt_product_description" value="{{ old('txt_product_description') }}"
                                    placeholder="Product Description">
                                @error('txt_product_description')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_unit_id" id="cbo_unit_id" class="form-control">
                                    <option value="0">Product Unit</option>
                                    @foreach ($m_unit as $row_unit)
                                        <option value="{{ $row_unit->unit_id }}">
                                            {{ $row_unit->unit_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_unit_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_reorder_qty" name="txt_reorder_qty"
                                    value="{{ old('txt_reorder_qty') }}" placeholder="Reorder Qty">
                                @error('txt_reorder_qty')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select name="cbo_discount" id="cbo_discount" class="form-control">
                                    <option value="0">Discount</option>
                                    @foreach ($m_yesno as $row_discount)
                                        <option value="{{ $row_discount->yesno_id }}">
                                            {{ $row_discount->yesno_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_discount')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select name="cbo_warrenty" id="cbo_warrenty" class="form-control">
                                    <option value="0">Warrenty</option>
                                    @foreach ($m_yesno as $row_warrenty)
                                        <option value="{{ $row_warrenty->yesno_id }}">
                                            {{ $row_warrenty->yesno_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_warrenty')
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
                                <button type="submit" id="confirm_action" onclick="BTOFF()"
                                    class="btn btn-primary btn-block" disabled>Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif
    @include('sales.finish_product_list')

@endsection

@section('script')
    <script type="text/javascript">
        // customer address
        $(document).ready(function() {
            getAllFinishProductList();
            $('select[name="cbo_company_id"]').on('change', function() {
                getFinishProduct();
                getAllFinishProductList();
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
        function getFinishProduct() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get_sales_finish_product_group_list') }}/" + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_pg_id"]').empty();
                        $('select[name="cbo_pg_id"]').append(
                            '<option value="">--Product Group--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_pg_id"]').append(
                                '<option value="' + value.pg_id + '">' +
                                value.pg_name + '</option>');
                        });
                    }
                });

            } else {
                $('#cbo_pg_id').empty();
                $('select[name="cbo_pg_sub_id"]').empty();
            }
        }
    </script>

    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_pg_id"]').on('change', function() {
                var cbo_company_id = $('#cbo_company_id').val();
                var cbo_pg_id = $(this).val();
                if (cbo_pg_id && cbo_company_id) {

                    $.ajax({
                        url: "{{ url('/get_sales/finish_product_sub_group/') }}/" + cbo_pg_id +
                            '/' + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_pg_sub_id"]').empty();
                            $('select[name="cbo_pg_sub_id"]').append(
                                '<option value="0">Product Sub Group</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_pg_sub_id"]').append(
                                    '<option value="' + value.pg_sub_id + '">' +
                                    value.pg_sub_id + ' | ' + value.pg_sub_name +
                                    '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_pg_sub_id"]').empty();
                }

            });
        });
    </script>

    <script>
        function getAllFinishProductList() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                var k = 1;
                $.ajax({
                    url: "{{ url('/get_all_finish_product_list') }}/" + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                        if ($.fn.DataTable.isDataTable("#product_info")) {
                            $('#product_info').DataTable().clear().destroy();
                        }
                    }
                        $('#product_info').dataTable({
                            "responsive": true,
                            "lengthChange": false,
                            "autoWidth": true,
                            order: [
                                [0, 'desc']
                            ],
                            dom: 'Blfrtip',
                            buttons: [{
                                    extend: 'csvHtml5',
                                    title: 'Product Information'
                                },
                                {
                                    extend: 'pdfHtml5',
                                    title: 'Product Information'
                                    // orientation: 'landscape',
                                    // pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'print',
                                    title: 'Product Information',
                                    autoPrint: true,
                                    exportOptions: {
                                        columns: ':visible'
                                    },
                                },
                                'colvis',
                            ],


                            "aaData": data,
                            "columns": [{
                                    data: null,
                                    render: function(data, type, full) {
                                        return k++;
                                    }
                                },
                                {
                                    "data": "pg_name"
                                },
                                {
                                    data: null,
                                    render: function(data, type, full) {
                                        if (data.pg_sub_id != null) {
                                            return data.pg_sub_name;
                                        } else {
                                            return 'N/A';
                                        }
                                    }
                                },
                                {
                                    "data": "product_name"
                                },
                                {
                                    "data": "unit_name"
                                },
                                {
                                    "data": "product_description"
                                },
                                {
                                    "data": "product_type"
                                },
                                {
                                    "data": "brand_name"
                                },
                                {
                                    data: null,
                                    render: function(data, type, full) {
                                        return '<a href="{{ url('/') }}/sales/finish_product_edit/' +
                                            data.product_id + '/' + data.company_id +
                                            '" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>';
                                    }
                                },
                            ]
                        }) // end dataTable

                    }, // End Sucess
                }); // end Ajax

            }

        } // end Windows onload
    </script>
@endsection
@section('css')
    #product_info_filter {
    margin-top: -25px;
    }
@endsection
