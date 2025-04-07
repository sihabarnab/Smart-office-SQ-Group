@extends('layouts.hrm_app')
@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Summary Leave Report</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
   <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $ci_company->company_name }}<BR>{{ $m_year }}</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm" >
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>ID<br>Name/Desig.</th>
                                <th>Leave</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ci_employee_info as $key => $row_employee_info)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $row_employee_info->employee_id }}<br>{{ $row_employee_info->employee_name }}</td>
                                <td>
                                    <table id="" class="table">  
                                        <tr>
                                            <th width=''>Leave Type</th>
                                            <th width=''>Short Name</th>
                                            <th width=''>Total Leave</th>
                                            <th width=''>Availed Leave</th>
                                            <th width=''>Available Leave</th>
                                        </tr>
                                        @foreach ($ci_leave_config as $key => $row_leave_config)
                                        @php

                                        $ci_pro_leave_info_master=DB::table('pro_leave_info_master')->Where('leave_type_id',$row_leave_config->leave_type_id)->where('employee_id',$row_employee_info->employee_id)
                                            ->where('valid',1)
                                            ->where('status',2)
                                            ->where('leave_year',$m_year)
                                            ->orderby('leave_type_id')
                                            ->get();

                                        $m_avail_day = collect($ci_pro_leave_info_master)->sum('g_leave_total'); // 60

                                        // dd($sum);

                                        $m_available=$row_leave_config->leave_days-$m_avail_day;
                                        @endphp

                                        <tr>
                                            <td>{{ $row_leave_config->leave_type }}</td>
                                            <td>{{ $row_leave_config->leave_type_sname }}</td>
                                            <td>{{ $row_leave_config->leave_days }}</td>
                                            <td>{{ $m_avail_day }}</td>
                                            <td>{{ $m_available }}</td>
                                        </tr>
                                        @endforeach

                                    </table>

                                </td>
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