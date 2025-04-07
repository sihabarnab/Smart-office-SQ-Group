@extends('layouts.inventory_app')

@section('content')
    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $company = DB::table('pro_company')
            ->where('company_id', $issue_master->company_id)
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
                            <a href="{{ route('rpt_issue_excel', [$issue_master->rim_no, $issue_master->company_id]) }}"
                                class=" btn btn-success">Excel</a>
                        </div>
                        <div class="col-1">
                            <a href="{{ route('rpt_requsition_issue_print', [$issue_master->rim_no, $issue_master->company_id]) }}"
                                class="btn btn-info">Print</a>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <div class=" pt-3" class="text-center">
                                <h2 class="text-center">{{ $company_name }}</h2>
                                <h4 class="text-center">Issue</h4>

                            </div>
                            <div class="row ">
                                <div class="col-2"></div>
                                <div class="col-6">
                                    Issue No : {{ $issue_master->rim_no }} <br>
                                    Requsition No : {{ $issue_master->mrm_no }} <br>
                                    Serial No : {{ $issue_master->mrm_serial_no }} <br>
                                    Project : {{ $issue_master->project_name }} <br>
                                    Remark : {{ $issue_master->remrks }}
                                </div>
                                <div class="col-4">
                                    Issue Date : {{ $issue_master->rim_date }} <br>
                                    Requsition Date : {{ $issue_master->mrm_date }} <br>
                                    Serial Date : {{ $issue_master->mrm_serial_date }} <br>
                                    Section : {{ $issue_master->section_name }} <br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-left align-top">SL No.</th>
                                <th class="text-left align-top">Product Group</th>
                                <th class="text-left align-top">Product Name</th>
                                <th class="text-left align-top">Issue Qty</th>
                                <th class="text-left align-top">Unit</th>
                                <th class="text-left align-top">Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issue_details as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->pg_name }} <br> {{ $value->pg_sub_name }}</td>
                                    <td>{{ $value->product_name }}</td>
                                    <td>{{ $value->product_qty }}</td>
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
