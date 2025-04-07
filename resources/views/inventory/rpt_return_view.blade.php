@extends('layouts.inventory_app')

@section('content')
    <div class="container-fluid">
        @include('flash-message')
    </div>
    @php
        $company = DB::table('pro_company')
            ->where('company_id', $gm_return_master->company_id)
            ->first();
        $company_name = $company == null ? '' : $company->company_name;
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-2">
                        <div class="col-10">&nbsp;
                        </div>
                        <div class="col-1">
                            <a href="{{ route('rpt_return_excel', [$gm_return_master->return_master_no, $gm_return_master->company_id]) }}"
                                class=" btn btn-success">Excel</a>
                        </div>
                        <div class="col-1">
                            <a href="{{ route('rpt_return_print', [$gm_return_master->return_master_no, $gm_return_master->company_id]) }}"
                                class="btn btn-info">Print</a>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <div class=" pt-3" class="text-center">
                                <h2 class="text-center">{{ $company_name}}</h2>
                                <h4 class="text-center">Return Report</h4>

                            </div>
                            <div class="row ">
                                <div class="col-2"></div>
                                <div class="col-6">
                                    Return No : {{ $gm_return_master->return_master_no }} <br>
                                    Voucher No : {{ $gm_return_master->voucher_no }} <br>
                                    Remark : {{ $gm_return_master->remarks }}
                                </div>
                                <div class="col-4">
                                    Return Date : {{ $gm_return_master->return_date }} <br>
                                    Project : {{ $gm_return_master->project_name }} <br>
                                    Section : {{ $gm_return_master->section_name }} <br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Product Group</th>
                                <th>Product Name</th>
                                <th>Unit</th>
                                <th>Usable Qty</th>
                                <th>Damage Qty</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gm_return_details as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->pg_name }} <br> {{ $value->pg_sub_name }}</td>
                                    <td>{{ $value->product_name }}</td>
                                    <td>
                                        @isset($value->unit_name)
                                            {{ $value->unit_name }}
                                        @endisset
                                    </td>
                                    <td>{{ $value->useable_qty }}</td>
                                    <td>{{ $value->damage_qty }}</td>
                                    <td>{{ $value->comments }}</td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
