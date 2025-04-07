@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Atten Data Query</h1>
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
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Company<br>Posting</th>
                                <th>Employee ID<br>Employee Name</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($m_employee_info as $key=>$row)
                            @php
                                // $emp='00000161';
                                // $txt_date='2023-04-10';
                            // dd($m_month_year);
                                $m_tmp_log = DB::table("pro_tmp_log_$m_month_year")
                                ->where('emp_id',$row->employee_id)
                                ->where('logdate',$txt_date)
                                // ->where('logtime','<','11:01:00')
                                ->count();
                                // dd($m_tmp_log);

                                if ($m_tmp_log==0){
                                $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row->employee_id)->first();
                                // $txt_employee_id=$ci_employee_info->employee_id;
                                $txt_employee_name=$ci_employee_info->employee_name;

                                $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$ci_employee_info->placeofposting_id)->first();
                                $txt_placeofposting_name=$ci_placeofposting->placeofposting_name;

                                $ci_company=DB::table('pro_company')->Where('company_id',$ci_employee_info->company_id)->first();
                                $txt_company_name=$ci_company->company_name;


                            @endphp
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $txt_company_name }}<br>{{ $txt_placeofposting_name }}</td>
                                <td>{{ $row->employee_id }}<br>{{ $txt_employee_name }}</td>
                                <td>{{ $txt_date }}</td>
                            </tr>
                            @php        
                             }
                            @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection