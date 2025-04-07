@extends('layouts.purchase_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Indent Copy</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                        href="{{ route('purchase_indent_edit', [$indent_no, $company_id]) }}">Copy Final</a>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-3">
                <input type="text" readonly class="form-control" value="{{ $pro_indent_master->company_name }}">
            </div>
            <div class="col-3">
                <input type="text" name="txt_indent_no" id="txt_indent_no" readonly class="form-control"
                    value="{{ $pro_indent_master->indent_no }}">
                @error('txt_indent_no')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-3">
                <input type="text" readonly class="form-control" name="cbo_project_name" id="cbo_project_name"
                    value="{{ $pro_indent_master->project_name }}">
                @error('cbo_project_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-3">
                <input type="text" readonly class="form-control" value="{{ $pro_indent_master->category_name }}">
                @error('cbo_indent_category')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
            </div>

        </div>
    </div><!-- /.container-fluid -->


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="text-left align-top" width='5%'>SL No.</th>
                                    <th class="text-left align-top">Product</th>
                                    <th class="text-left align-top">Description</th>
                                    <th class="text-left align-top" width='15%'>Section</th>
                                    <th class="text-left align-top">Qty</th>
                                    <th class="text-left align-top">Remarks</th>
                                    <th class="text-left align-top">Require Date</th>
                                    <th class="text-left align-top"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($m_indent_detail_all as $key => $value)
                                    @if ($value->pg_sub_id)
                                        <form id="myForm{{$key}}" action="{{ route('indent_copy_product_details_add') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="cbo_company_id" value="{{ $company_id }}">
                                            <input type="hidden" name="txt_indent_no" value="{{ $indent_no }}">
                                            <input type="hidden" name="txt_indent_details_id"
                                                value="{{ $value->indent_details_id }}">
                                            <tr class="">
                                                <td class="text-left align-top pl-0 pr-0"><input type="text"
                                                        class="form-control" name="txt_description"
                                                        value="{{ $i++ }}">
                                                </td>
                                                <td class="text-left align-top pl-0 pr-0"><input type="text"
                                                        class="form-control" name="txt_description"
                                                        value="{{ $value->product_name }}"></td>
                                                <td class="text-left align-top pl-0 pr-0"><input type="text"
                                                        class="form-control" name="txt_description"
                                                        value="{{ $value->description }}"> </td>
                                                <td class="text-left align-top pl-0 pr-0">
                                                    <select name="cbo_section" class="form-control" id="cbo_section">
                                                        <option value="">--Select Section--</option>
                                                        @foreach ($m_section_information as $row)
                                                            <option value="{{ $row->section_id }}"
                                                                {{ $value->section_id == $row->section_id ? 'selected' : '' }}>
                                                                {{ $row->section_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('cbo_section')
                                                        <div class="text-warning">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td class="text-left align-top pl-0 pr-0">
                                                    <input type="number" class="form-control" name="txt_qty"
                                                        value="{{ $value->qty }}">
                                                    @error('txt_qty')
                                                        <div class="text-warning">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td class="text-left align-top pl-0 pr-0"><input type="text"
                                                        class="form-control" name="txt_remarks"
                                                        value="{{ $value->remarks }}">
                                                </td>
                                                <td class="text-left align-top pl-0 pr-0"><input type="date"
                                                        class="form-control" name="txt_req_date"
                                                        value="{{ $value->req_date }}"></td>
                                                <td class="text-left align-top pl-1 pr-1 d-flex flex-row">
                                                    <input type="checkbox" id="AYC" onclick='BTON("{{$key}}")' name="AYC" class="mr-2">
                                                    <button type="Submit" id="confirm_action{{$key}}" onclick='BTOFF("{{$key}}")'
                                                        class="btn btn-primary btn-block" disabled>ADD</button>
                                                </td>
                                            </tr>
                                        </form>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Indent List</h1>
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-left align-top">SL No.</th>
                                    <th class="text-left align-top">Product Group</th>
                                    <th class="text-left align-top">Product Sub Group</th>
                                    <th class="text-left align-top">Product Name</th>
                                    <th class="text-left align-top">Description</th>
                                    <th class="text-left align-top">Section</th>
                                    <th class="text-left align-top">Qty</th>
                                    <th class="text-left align-top">Unit</th>
                                    <th class="text-left align-top">Remarks</th>
                                    <th class="text-left align-top">Product Require Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($new_indent_detail_all as $key => $value)
                                    <tr>
                                        <td class="text-left align-top">{{ $key + 1 }}</td>
                                        <td class="text-left align-top">{{ $value->pg_name }}</td>
                                        <td class="text-left align-top">{{ $value->pg_sub_name }}</td>
                                        <td class="text-left align-top">{{ $value->product_name }}</td>
                                        <td class="text-left align-top">{{ $value->description }}</td>
                                        <td class="text-left align-top">{{ $value->section_name }}</td>
                                        <td class="text-left align-top">{{ $value->qty }}</td>
                                        <td class="text-left align-top">
                                            @php
                                                $unit = DB::table('pro_units')
                                                    ->where('unit_id', '=', $value->unit)
                                                    ->first();
                                            @endphp
                                            @if (isset($unit))
                                                {{ $unit->unit_name }}
                                            @endif
                                        </td>
                                        <td class="text-left align-top">{{ $value->remarks }}</td>
                                        <td class="text-left align-top">{{ $value->req_date }}</td>

                                    </tr>
                                @endforeach
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
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>

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
