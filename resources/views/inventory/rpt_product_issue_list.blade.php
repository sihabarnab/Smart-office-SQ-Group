{{-- @extends('layouts.inventory_app') --}}

{{-- @section('content') --}}
@if (isset($ci_product))


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">PRODUCT ISSUE</h1>
                    @php
                        $company = DB::table('pro_company')
                            ->where('company_id', $company_id)
                            ->first();
                    @endphp
                    {{ $company->company_name }}
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
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Project</th>
                                    <th>Section</th>
                                    <th>Issue No.<br>Date</th>
                                    <th>Requsition No.<br>Date</th>
                                    <th>Group<br>Sub<br>Product</th>
                                    <th>Remarks</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $ttl_issue_qty = 0;
                                    // $ttl_rr_qty=0;
                                @endphp
                                @foreach ($ci_product as $key => $row_product)
                                    @php

                                        $ci_graw_issue_details = DB::table("pro_graw_issue_details_$company_id")
                                            ->leftJoin('pro_project_name', "pro_graw_issue_details_$company_id.project_id", 'pro_project_name.project_id')
                                            // ->leftJoin('pro_gmaterial_requsition_details', 'pro_graw_issue_details.mrm_no', 'pro_gmaterial_requsition_details.mrm_no')
                                            ->leftJoin('pro_section_information', "pro_graw_issue_details_$company_id.section_id", 'pro_section_information.section_id')
                                            ->leftJoin("pro_product_group_$company_id", "pro_graw_issue_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
                                            ->leftJoin("pro_product_sub_group_$company_id", "pro_graw_issue_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
                                            ->leftJoin("pro_product_$company_id", "pro_graw_issue_details_$company_id.product_id", "pro_product_$company_id.product_id")
                                            ->leftJoin('pro_units', "pro_graw_issue_details_$company_id.product_unit", 'pro_units.unit_id')
                                            ->select("pro_graw_issue_details_$company_id.*", 'pro_project_name.project_name', 'pro_section_information.*', "pro_product_group_$company_id.pg_name", "pro_product_sub_group_$company_id.pg_sub_name", "pro_product_$company_id.product_name", 'pro_units.unit_name')
                                            ->where("pro_graw_issue_details_$company_id.product_id", $row_product->product_id)
                                            ->where("pro_graw_issue_details_$company_id.valid", 1)
                                            ->whereBetween("pro_graw_issue_details_$company_id.rim_date", [$m_from_date, $m_to_date])
                                            ->get();

                                    @endphp
                                    {{-- @php
                            $ttl_issue_qty=0;
                            // $ttl_rr_qty=0;
                            @endphp --}}

                                    @foreach ($ci_graw_issue_details as $key1 => $row_graw_issue_details)
                                        <tr>
                                            <td>{{ $key1 + 1 }}</td>
                                            <td>{{ $row_graw_issue_details->project_name }}</td>
                                            <td>{{ $row_graw_issue_details->section_name }}</td>
                                            <td>{{ $row_graw_issue_details->rim_no }}<br>{{ $row_graw_issue_details->rim_date }}
                                            </td>
                                            <td>{{ $row_graw_issue_details->mrm_no }}<br>{{ $row_graw_issue_details->mrm_date }}
                                            </td>
                                            <td>{{ $row_graw_issue_details->pg_name }}
                                                <hr class="m-0" color='white'>
                                                {{ $row_graw_issue_details->pg_sub_name }}
                                                <hr class="m-0" color='white'>
                                                {{ $row_graw_issue_details->product_name }}
                                            </td>
                                            <td>{{ $row_graw_issue_details->remarks }}</td>
                                            <td>{{ $row_graw_issue_details->product_qty }}</td>
                                            <td>{{ $row_graw_issue_details->unit_name }}</td>
                                        </tr>
                                        @php
                                            $ttl_issue_qty = $ttl_issue_qty + $row_graw_issue_details->product_qty;
                                        @endphp
                                    @endforeach
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">&nbsp;</td>
                                    <td style="text-align: right;">{{ 'Total' }}</td>
                                    <td style="text-align: right;">{{ $ttl_issue_qty }}</td>
                                    <td colspan="1">&nbsp;</td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
@endif
{{-- @endsection --}}
