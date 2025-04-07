@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Damage Stock</h1>
                    @php
                      $company =  DB::table('pro_company')->where('company_id',$company_id)->first();
                    @endphp
                    {{ $company->company_name}}
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
                                <th>Product Group</th>
                                <th>Sub Group</th>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Damage</th>
                                <th>ttt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php

                            $ci_product_list  = DB::table("pro_product_$company_id")
                            ->leftjoin("pro_product_group_$company_id", "pro_product_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
                            ->leftjoin("pro_product_sub_group_$company_id", "pro_product_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
                            ->leftJoin('pro_units', "pro_product_$company_id.unit", 'pro_units.unit_id')
                            ->select("pro_product_$company_id.*", "pro_product_group_$company_id.pg_name", "pro_product_sub_group_$company_id.pg_sub_name", 'pro_units.unit_name')
                            ->where("pro_product_$company_id.product_category", 1)
                            ->where("pro_product_$company_id.valid", 1)
                            ->get();
                            @endphp
                            @foreach($ci_product_list as $key=>$row_product_list)

                            @php

                            $ci_gmaterial_return_details  = DB::table("pro_gmaterial_return_details_$company_id")
                            ->where("product_id",$row_product_list->product_id)
                            ->whereBetween('return_date',[$txt_start_date,$txt_end_date])
                            ->sum('damage_qty');

                            if ($ci_gmaterial_return_details === NULL)
                            {
                                $txt_damage_qty=0;
                            } else {
                                $txt_damage_qty="$ci_gmaterial_return_details";
                            }

                            @endphp

                           @if($txt_damage_qty === 0)

                           @else
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_product_list->pg_name }}</td>
                                <td>{{ $row_product_list->pg_sub_name }}</td>
                                <td>{{ $row_product_list->product_name }}</td>
                                <td>{{ $row_product_list->unit_name }}</td>
                                <td>{{ $txt_damage_qty }}</td>
                                <td>{{ "aa" }}</td>
                                
                            </tr>
                           @endif

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection