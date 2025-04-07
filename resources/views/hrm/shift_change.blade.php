@extends('layouts.hrm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Employee Working Shifts Change.</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->where('employee_id',$m_user_id)
            ->groupby('pro_user_company.company_id')
            ->get();
        $data_pro_placeofposting = DB::table('pro_placeofposting')
            ->Where('valid', '1')
            ->orderBy('placeofposting_id', 'asc')
            ->get();
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class=""></div>
                        <form action="#" method="Post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-6">
                                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                        <option value="0">--Company--</option>
                                        @foreach ($user_company as $company)
                                            <option value="{{ $company->company_id }}">
                                                {{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <select name="sele_placeofposting" id="sele_placeofposting" class="form-control">
                                        <option value="0">All Place of Posting</option>
                                        @foreach ($data_pro_placeofposting as $emp_placeofposting)
                                            <option value="{{ $emp_placeofposting->placeofposting_id }}">
                                                {{ $emp_placeofposting->placeofposting_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sele_placeofposting')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @isset($m_employee_list)
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Employee List</h3>
                        </div>
                        <div class="card-body">
                            <table id="data1" class="table table-border table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width=''>SL No</th>
                                        <th width=''>Employee Name</th>
                                        <th width=''>Policy</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($m_employee_list as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->employee_id }}<br>{{ $row->employee_name }}</td>
                                            <td>
                                            <table id="" class="table">  
                                                <tr>
                                                    <th width=''>Policy Name</th>
                                                    <th width=''>IN Time</th>
                                                    <th width=''>Out Time</th>
                                                    <th width=''>Weekend</th>
                                                </tr>

                                                    @foreach ($m_policy as $key => $policy)

                                                    <tr>
                                                        <td>
                                                        {{-- <div class="col-3"> --}}
                                                            {{--  --}}
                                                            <input type="checkbox"
                                                                name="txt_policy{{ $row->employee_id }}{{ $policy->att_policy_id }}"
                                                                id="txt_policy{{ $row->employee_id }}{{ $policy->att_policy_id }}"
                                                                onclick="policy('{{ $policy->att_policy_id }}','{{ $row->employee_id }}')"
                                                                {{ $policy->att_policy_id == $row->att_policy_id ? 'checked' : '' }}>

                                                            {{ $policy->att_policy_name }}
                                                        {{-- </div> --}}
                                                        </td>
                                                        <td>
                                                            {{ $policy->in_time }}
                                                        </td>
                                                        <td>
                                                            {{ $policy->out_time }}
                                                        </td>
                                                        <td>
                                                            {{ $policy->weekly_holiday1 }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                
                                            </td>
                                            </table>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection

@section('script')
    <script>
        function policy(policy, employee) {
            console.log(policy);
            console.log(employee);
            if (policy) {
                $.ajax({
                    url: "{{ url('/Add/Policy/') }}/" + policy + "/" + employee,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data.att_policy_id) {
                            $("#txt_policy" + data.employee_id + data.att_policy_id).prop("checked", false);
                        }
                    },
                });

            } else {
                alert('danger');
            }
        }
    </script>
    <script>
        $(document).ready(function () {
        //change selectboxes to selectize mode to be searchable
        $("select").select2();
        });
    </script>  

@endsection
