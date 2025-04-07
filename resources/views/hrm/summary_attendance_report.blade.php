@extends('layouts.hrm_app')
@section('content')


@php
   $summ_attn_master_id = $data['summ_attn_master_id'];
   $txt_company_id = $data['company_id'];
   $txt_company_name = $data['company_name'];
   $txt_year = $data['year'];
   $month = $data['month'];
   $month_name = $data['month_name'];
   $sele_placeofposting = $data['sele_placeofposting'];

@endphp

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Summary Attendance Report</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
   <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{route('summary_attendance_print',[$summ_attn_master_id,$sele_placeofposting])}}" class="btn btn-primary float-right" >Print</a>
                    <h3 class="card-title">{{ $txt_company_name }}<BR>{{ $month_name}}, {{ $txt_year }}</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm" >

                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>ID<br>Name/Desig.</th>
                                <th>Department<br>Posting/PSM</th>
                                <th>W.Day</th>
                                <th>Weekly</th>
                                <th>Holiday</th>
                                <th>Leave</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Late</th>
                                <th>E.Out</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_summ_attn_report as $key=>$row)
                            @php

                            // $txt_joinning_date=date("d-m-Y",strtotime("$row->joinning_date"));

                            $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$row->placeofposting_id)->first();
                            $txt_placeofposting_name=$ci_placeofposting->placeofposting_name;


                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->employee_id }}<BR>{{ $row->employee_name }}<BR>{{ $row->desig_name }}</td>
                                <td>{{ $row->department_name }}<BR>{{ $txt_placeofposting_name }}<BR>{{ $row->psm_id }}
                                </td>
                                <td align="center">{{ $row->working_day }}</td>
                                <td align="center">{{ $row->weekend }}</td>
                                <td align="center">{{ $row->holiday }}</td>
                                <td align="center">{{ $row->total_leave }}</td>
                                <td align="center">{{ $row->present }}</td>
                                <td align="center">{{ $row->absent }}</td>
                                <td align="center">{{ $row->late }}</td>
                                <td align="center">{{ $row->early_out }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="1" ></td>
                                <td >{{ $txt_company_name }}, {{ $month_name}}, {{ $txt_year }}</td>
                                <td colspan="9"></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection