@extends('layouts.purchase_app')

@section('content')
    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-2">
                        <div class="col-11">&nbsp;
                        </div>
                        <div class="col-1">
                            <a href="{{ route('indent_copy_master',[$pro_indent_master->indent_id,$pro_indent_master->company_id]) }}" class=" btn btn-success">COPY</a>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="pt-3" style="text-align: center;">
                                <h2 style="text-transform: uppercase;">indent</h2>
                                {{-- <h3>Transformer</h3> --}}
                            </div>
                            <div class="row ">
                                <div class="col-2"></div>
                                <div class="col-6">
                                    Indent No : {{ $pro_indent_master->indent_no }} <br>
                                    Project : {{ $pro_indent_master->project_name }}
                                </div>
                                <div class="col-4">
                                    Indent Date : {{ $pro_indent_master->entry_date }} <br>
                                    Indent Category : {{ $pro_indent_master->category_name }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Group|Sub Group</th>
                                <th>Product Name | Description</th>
                                <th>Section</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_indent_detail_all as $key => $value)

                            @php
                                $ci_grr_details  = DB::table("pro_grr_details_$value->company_id")
                                ->where("product_id",$value->product_id)
                                ->where("indent_no",$value->indent_no)
                                ->sum('received_qty');

                                if ($ci_grr_details === NULL)
                                {
                                    $txt_rr_qty="0.0000";
                                } else {
                                    $txt1_rr_qty="$ci_grr_details";
                                    $txt_rr_qty=number_format($txt1_rr_qty,4);
                                }

                            @endphp

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->pg_name }} <hr class="m-0" color='white'> {{ $value->pg_sub_name }}</td>
                                    <td>{{ $value->product_name }}<hr class="m-0" color='white'>{{ $value->description }}</td>
                                    <td>{{ $value->section_name }}</td>
                                    <td>
                                        @php
                                            $unit = DB::table('pro_units')
                                                ->where('unit_id', '=', $value->unit)
                                                ->first();
                                        @endphp
                                        @isset($unit)
                                            {{ $unit->unit_name }}
                                        @endisset
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
