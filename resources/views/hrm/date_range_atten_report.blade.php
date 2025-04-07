@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Date Range Attendance Report</h1>
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
                    <h3 class="card-title">{{ $m_company->company_name }}<br>{{ $txt_from_date }} to {{$txt_to_date}}</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>ID/Name/Desig</th>
                                <th>W.Day</th>
                                <th>Weekly</th>
                                <th>Holiday</th>
                                <th>Leave</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Late</th>                                
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($m_employee_info as $key=>$row)
                            @php
                                $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row->employee_id)->first();
                                $txt_employee_id=$ci_employee_info->employee_id;
                                $txt_employee_name=$ci_employee_info->employee_name;

                                $ci_desig=DB::table('pro_desig')->Where('desig_id',$ci_employee_info->desig_id)->first();
                                $txt_desig_name=$ci_desig->desig_name;


                                $m_working_day=DB::table('pro_attendance_0424')
                                ->whereBetween('attn_date',[$txt_from_date,$txt_to_date])
                                ->where('day_status','R')
                                ->where('employee_id',$ci_employee_info->employee_id)
                                ->count();
                                $m_twd=$m_working_day;

                                $m_weekend=DB::table('pro_attendance_0424')
                                ->whereBetween('attn_date',[$txt_from_date,$txt_to_date])
                                ->where('day_status','W')
                                ->where('employee_id',$ci_employee_info->employee_id)
                                ->count();
                                $m_w=$m_weekend;

                                $m_holiday=DB::table('pro_attendance_0424')
                                ->whereBetween('attn_date',[$txt_from_date,$txt_to_date])
                                ->where('day_status','H')
                                ->where('employee_id',$ci_employee_info->employee_id)
                                ->count();
                                $m_h=$m_holiday;

                                $m_leave=DB::table('pro_attendance_0424')
                                ->whereBetween('attn_date',[$txt_from_date,$txt_to_date])
                                ->where('status','L')
                                ->where('employee_id',$ci_employee_info->employee_id)
                                ->count();
                                $m_l=$m_leave;

                                $m_present=DB::table('pro_attendance_0424')
                                ->whereBetween('attn_date',[$txt_from_date,$txt_to_date])
                                ->where('status','P')
                                ->where('employee_id',$ci_employee_info->employee_id)
                                ->count();
                                $m_present=$m_present;

                                $m_absent=DB::table('pro_attendance_0424')
                                ->whereBetween('attn_date',[$txt_from_date,$txt_to_date])
                                ->where('status','A')
                                ->where('employee_id',$ci_employee_info->employee_id)
                                ->count();
                                $m_absent=$m_absent;

                                $m_late=DB::table('pro_attendance_0424')
                                ->whereBetween('attn_date',[$txt_from_date,$txt_to_date])
                                ->where('status','D')
                                ->where('employee_id',$ci_employee_info->employee_id)
                                ->count();
                                $m_late=$m_late;

                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->employee_id }}<br>{{ $txt_employee_name }}<br>{{ $txt_desig_name }}</td>
                                <td align="center">{{ $m_twd }}</td>
                                <td align="center">{{ $m_w }}</td>
                                <td align="center">{{ $m_h }}</td>
                                <td align="center">{{ $m_l }}</td>
                                <td align="center">{{ $m_present }}</td>
                                <td align="center">{{ $m_absent }}</td>
                                <td align="center">{{ $m_late }}</td>
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