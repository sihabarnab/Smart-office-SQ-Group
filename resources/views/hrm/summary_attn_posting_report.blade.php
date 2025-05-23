@extends('layouts.hrm_app')
@section('content')

{{-- @foreach($ci_summ_attn_report as $key1=>$row1)
@php
$ci_company=DB::table('pro_company')->Where('company_id',$row1->company_id)->first();
$txt_company_name=$ci_company->company_name;

$ci_month_year=DB::table('pro_summ_attn_master')->Where('summ_attn_master_id',$row1->summ_attn_master_id)->first();

// $txt_month=$ci_month_year->month;
$txt_year=$ci_month_year->year;
$month_name = date("F", mktime(0, 0, 0, $ci_month_year->month, 10));

@endphp
@endforeach
 --}}
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0">Summary Attendance Report Posting Wise</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
   <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $month_name}}, {{ $txt_year }}</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm" >
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>ID<br>Name/Desig.</th>
                                <th>Department<br>Posting</th>
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


                            @foreach($ci_summ_attn_report_posting as $key=>$row)
                            @php

                            $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$row->placeofposting_id)->first();
                            $txt_placeofposting_name=$ci_placeofposting->placeofposting_name;


                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->employee_id }}<BR>{{ $row->employee_name }}<BR>{{ $row->desig_name }}<BR>{{ $row->company_name }}</td>
                                <td>{{ $row->department_name }}<BR>{{ $txt_placeofposting_name }}</td>
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection