@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employee Attendance Date Report</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

@php

$ci_company=DB::table('pro_company')
->Where('company_id',$txt_company_id)
->first();
$txt_company_name=$ci_company->company_name;

@endphp


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h3 class="card-title"> --}}
                        <div class="row mb-2">
                            <div class="col-6">
                                {{ $txt_company_name }}<br>{{ $txt_frist_date}}
                            </div>
                            <div class="col-4">
                                {{ 'P=Present' }}, {{ 'W=Weekend' }}<br>{{ 'D=Late' }}, {{ 'A=Absent' }}<br>{{ 'H=Holiday'}},{{ 'L=Leave' }}<br> {{ 'TWH=Total Working Hour'}}
                            </div>

                            <div class="col-2">
                                <a href="" class="btn btn-info float-right mr-5 mt-4">Print </a>
                            </div>
                        </div>
                        
                    {{-- </h3> --}}
                </div>
                <div class="card-body">
                    <table id="" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>

                                <th>SL No</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>In Time</th>
                                <th>In Location</th>
                                <th>Out Time</th>
                                <th>Out Location</th>
                                <th>Late</th>
                                <th>Early/Over</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_pro_attendance as $key=>$row)
                            @php
                            // dd($row);
                            if($row->nodeid_in=='0')
                            {
                              $txt_nodeid_in="N/A";
                            } else {
                            $m_biodevice_01=DB::table('pro_biodevice')->Where('biodevice_name',$row->nodeid_in)->Where('valid','1')->first();

                            // dd($row->nodeid_in);
                            $m_placeofposting_01=DB::table('pro_placeofposting')->Where('placeofposting_id',$m_biodevice_01->placeofposting_id)->first();

                            $txt_nodeid_in=$m_placeofposting_01->placeofposting_name;
                            // $txt_nodeid_in="aaa";
                            }
                            // echo "$row->nodeid_out --";
                            if($row->nodeid_out=='0')
                            {
                              $txt_nodeid_out="N/A";
                            } else {
                            $m_biodevice_02=DB::table('pro_biodevice')->Where('biodevice_name',$row->nodeid_out)->Where('valid','1')->first();
                            $m_placeofposting_02=DB::table('pro_placeofposting')->Where('placeofposting_id',$m_biodevice_02->placeofposting_id)->first();

                            $txt_nodeid_out=$m_placeofposting_02->placeofposting_name;
                            // $txt_nodeid_out="bbb";
                            }
                            $m_twh=round($row->working_min/60);

                            $m_employee_info=DB::table('pro_employee_info')
                            ->Where('employee_id',$row->employee_id)
                            ->first();

                            $txt_emp_name=$m_employee_info->employee_name
                            @endphp


                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->employee_id }} | {{ $txt_emp_name }}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->in_time }}</td>
                                <td>{{ $txt_nodeid_in }}</td>
                                <td>{{ $row->out_time }}</td>
                                <td>{{ $txt_nodeid_out }}</td>
                                <td>{{ $row->late_min }}</td>
                                <td>{{ $row->early_min }}</td>
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