@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Finished Product Stock Details</h1>
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
                    <form id="myForm" action="{{ route('rpt_finish_product_stock_view') }}" method="POST">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}"
                                            {{ $value->company_id == $company_id ? 'selected' : '' }}>
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                            <div class="col-3">
                                <select class="form-control" id="cbo_pg_id" name="cbo_pg_id">
                                    <option value="">--Product Group--</option>
                                    <option value="28" {{ '28' == $pg_id ? 'selected' : '' }}>TRANSFORMER</option>
                                    <option value="33" {{ '33' == $pg_id ? 'selected' : '' }}>CTPT</option>
                                </select>
                                @error('cbo_pg_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="cbo_pg_sub_id" name="cbo_pg_sub_id">
                                    <option value="">--Product Sub Group--</option>
                                </select>
                                @error('cbo_pg_sub_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="cbo_product_id" name="cbo_product_id">
                                    <option value="">--Product--</option>
                                </select>
                                @error('cbo_product_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>



                        </div><!-- /.row -->
                        <div class="row">
                            <div class="col-3">
                                <input type="date" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ $m_from_date }}">

                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="date" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ $m_to_date }}">
                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                    disabled>Search</button>
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                <label for="AYC">Are you Confirm</label>
                            </div>
                        </div><!-- /.row -->



                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>



    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-left align-top">SL No.</th>
                                    <th class="text-left align-top">Product Group</th>
                                    <th class="text-left align-top">Product Sub Group</th>
                                    <th class="text-left align-top">Product</th>
                                    <th class="text-left align-top">QTY</th>
                                    <th class="text-left align-top">Unit</th>
                                    <th class="text-left align-top">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product as $key => $row)
                                    @php
                                        $qty = DB::table("pro_fpsd_$company_id")
                                            ->where('company_id', $company_id)
                                            ->where('product_id', $row->product_id)
                                            ->whereBetween('fpsm_date', [$m_from_date, $m_to_date])
                                            ->sum('qty');
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->pg_name }}</td>
                                        <td>{{ $row->pg_sub_name }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td>{{ $qty }}</td>
                                        <td>{{ $row->unit_name }}</td>
                                        <td><a target="_blank"
                                                href="{{ route('rpt_fps_details', [$row->product_id, $company_id, $m_from_date, $m_to_date]) }}"
                                                class="btn btn-primary">Details</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getfpsub();
            $('select[name="cbo_pg_id"]').on('change', function() {
                getfpsub();
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_pg_sub_id"]').on('change', function() {
                var cbo_pg_sub_id = $(this).val();
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_pg_sub_id && cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/inventory/fpsd_product/') }}/" +
                            cbo_pg_sub_id + '/' + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_product_id"]').empty();
                            $('select[name="cbo_product_id"]').append(
                                '<option value="">-Product-</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_product_id"]').append(
                                    '<option value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_product_id"]').empty();
                }

            });
        });
    </script>

    <script>
        function getfpsub() {
            var cbo_pg_id = $('#cbo_pg_id').val();
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_pg_id && cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get/inventory/fpsd_sub_group/') }}/" +
                        cbo_pg_id + '/' + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_pg_sub_id"]').empty();
                        $('select[name="cbo_pg_sub_id"]').append(
                            '<option value="">--Product Sub Group--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_pg_sub_id"]').append(
                                '<option value="' + value.pg_sub_id + '">' + value.pg_sub_id + '|' +
                                value.pg_sub_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_pg_sub_id"]').empty();
            }
        }
    </script>
@endsection
@endsection
