@extends('layouts.finance_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Indent for Check (Second)</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.finance_status', '1')
            ->get();
    @endphp


    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('CompanyFundReqCheckList2') }}" method="post">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-12">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="0">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}">
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <div class="row mb-2">
                            <div class="col-10">
                                &nbsp;
                            </div>
                            <div class="col-2">
                                <button type="Submit" id="save_event" class="btn btn-primary btn-block">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    @if (isset($m_fund_req_master))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Indent #</th>
                                        <th>Date</th>
                                        <th>Company</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Prepare By</th>
                                        <th>1st Checked</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_fund_req_master as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->fund_req_master_id }}</td>
                                            <td>{{ $value->fund_req_date }}</td>
                                            <td>{{ $value->company_name }}</td>
                                            <td>{{ $value->req_form }}</td>
                                            <td>{{ $value->req_to }}</td>
                                            <td>{{ $value->employee_id }} <br> {{ $value->employee_name }}</td>
                                            <td>{{ $value->first_check }} <br> {{ $value->first_name }}</td>
                                            <td><a href="{{ route('FundReqCheck02',[$value->fund_req_master_id,$value->company_id]) }}"
                                                    class="btn bg-primary">Details</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
