@extends('layouts.purchase_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Indent Approval</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="col-2">
                                <label>Project</label>
                                <p class="form-control">{{ $pro_indent_master->project_name }}</p>
                            </div>
                            <div class="col-2">
                                <label>Indent No.</label>
                                <p class="form-control">{{ $pro_indent_master->indent_no }}</p>
                            </div>
                            <div class="col-2">
                                <label>Indent Date</label>
                                <p class="form-control">{{ $pro_indent_master->entry_date }}</p>
                            </div>
                            <div class="col-3">
                                <label>Indent Category</label>
                                <p class="form-control">{{ $pro_indent_master->category_name }}</p>
                            </div>
                            <div class="col-3">
                                <label>Prepared By</label>
                                <p class="form-control">
                                    @php
                                        $emp_name = DB::table('pro_employee_info')
                                            ->where('employee_id', $pro_indent_master->user_id)
                                            ->first();
                                        if ($emp_name == null) {
                                            $employee_name = '';
                                        } else {
                                            $employee_name = $emp_name->employee_name;
                                        }

                                    @endphp
                                    {{ $employee_name }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <label>SL No</label>
                            </div>
                            <div class="col-2">
                                <label>Product Name</label>
                            </div>
                            <div class="col-2">
                                <label>Description</label>

                            </div>
                            <div class="col-1">
                                <label>Indent Qty</label>

                            </div>
                            <div class="col-1">
                                <label for="txt_app_qty">Approved Qty</label>

                            </div>
                            <div class="col-1">
                                <label for="txt_app_unit">Approved Unit</label>

                            </div>
                            <div class="col-3">
                                <label for="txt_remarks">Remarks</label>

                            </div>
                            <div class="col-1">
                                <label for="txt_remarks">Action</label>
                            </div>
                        </div>
                        @foreach ($pro_indent_detail_all as $key => $value)
                            <form id="myForm{{$key}}"
                                action="{{ route('purchase_indent_approval_ok', [$value->indent_details_id, $value->company_id]) }}"
                                method="post">
                                @csrf

                                <input type="hidden" name="txt_indent_no" value="{{ $value->indent_no }}">

                                <div class="row">
                                    <div class="col-1">
                                        <div class="form-group">
                                            <p class="form-control">{{ $key + 1 }}</p>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <input class="form-control" readonly value="{{ $value->product_name }}">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <input class="form-control" readonly value="{{ $value->description }}">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <input readonly value="{{ $value->qty }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <input type="text" name="txt_app_qty" id="txt_app_qty" class="form-control"
                                                value="{{ $value->qty }}">
                                            @error('txt_app_qty')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            @php
                                                $unit = DB::table('pro_units')
                                                    ->where('unit_id', '=', $value->unit)
                                                    ->first();
                                            @endphp
                                            @if (isset($unit))
                                                <input type="text" readonly class="form-control"
                                                    value="{{ $unit->unit_name }}">
                                            @else
                                                <input type="text" readonly class="form-control" value=" ">
                                            @endif

                                            @error('txt_app_unit')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" readonly class="form-control"
                                                value="{{ $value->remarks }}">
                                            @error('txt_remarks')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-1 d-flex flex-row">
                                        <input type="checkbox" id="AYC" onclick='BTON("{{ $key }}")'
                                            name="AYC" class="mr-2">
                                        <button type="submit" id="confirm_action{{ $key }}"
                                            onclick='BTOFF("{{ $key }}")' class="btn btn-primary m-2"
                                            disabled>ok</button>
                                    </div>
                                </div>
                            </form>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function BTON(key) {
            var btname = `confirm_action${key}`;
            if ($(`#${btname}`).prop('disabled')) {
                $(`#${btname}`).prop("disabled", false);
            } else {
                $(`#${btname}`).prop("disabled", true);
            }
        }

        function BTOFF(key) {
            var btname = `confirm_action${key}`;
            if ($(`#${btname}`).prop('disabled')) {
                $(`#${btname}`).prop("disabled", true);
            } else {
                $(`#${btname}`).prop("disabled", true);
            }
            document.getElementById(`myForm${key}`).submit();

        }
    </script>
@endsection
