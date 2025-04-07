@extends('layouts.inventory_app')

@section('content')

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
    $company = DB::table('pro_company')
        ->where('company_id', $mr_master->company_id)
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
                        <a href="{{ route('rpt_requsition_excel',[$mr_master->mrm_no,$mr_master->company_id]) }}" class=" btn btn-success">Excel</a>
                    </div>
                    <div class="col-1">
                        <a href="{{ route('rpt_requsition_print',[$mr_master->mrm_no,$mr_master->company_id]) }}" class="btn btn-info"> Print </a>
                    </div>
                </div>


                <div class="row mb-2">
                    <div class="col-12">
                        <div class=" pt-3" class="text-center">
                            <h2 class="text-center">{{$company_name}}</h2>
                            <h4 class="text-center">Requsition</h4>
                            
                        </div>
                        <div class="row ">
                            <div class="col-2"></div>
                            <div class="col-6">
                                Requsition No : {{ $mr_master->mrm_no }} <br>
                                Serial No : {{ $mr_master->mrm_serial_no }} <br>
                                Project : {{ $mr_master->project_name }} <br>
                                Remark : {{ $mr_master->remarks }}
                            </div>
                            <div class="col-4">
                                Requsition Date : {{ $mr_master->mrm_date }} <br>
                                Serial Date : {{ $mr_master->mrm_serial_date }} <br>
                                Section : {{ $mr_master->section_name }} <br>
                            </div>
                        </div>
                    </div>
                </div>

                <table  class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-left align-top">SL No.</th>
                            <th class="text-left align-top">Product Group</th>
                            <th class="text-left align-top">Product Name</th>
                            <th class="text-left align-top">Requsition Qty</th>
                            <th class="text-left align-top">Approved Qty</th>
                            <th class="text-left align-top">Unit</th>
                            <th class="text-left align-top">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mr_details as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->pg_name }} <br> {{ $value->pg_sub_name }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->requsition_qty }}</td>
                                <td>{{ $value->approved_qty }}</td>
                                <td>
                                    @isset($value->unit_name)
                                        {{ $value->unit_name }}
                                    @endisset
                                </td>
                                <td>{{ $value->remarks }}</td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
