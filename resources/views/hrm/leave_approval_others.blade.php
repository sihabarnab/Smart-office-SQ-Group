@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Leave Approval Others</h1>
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
                <div class="card-body">
                    <div align="left" class=""><h5><?="New Application"; ?></h5></div>
                    <table id="data2" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>ID<br>Name<br>Company</th>
                                <th>Designation<br>Department<br>Mobile</th>
                                <th>Leave Type<br>Leave Date</th>
                                <th>Application<br>Date & Time</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($ci_report as $key=>$row_leave_app) --}}
                            @php
                            // $m_level_step=$row_leave_app->level_step;
                            // dd($m_level_step);
                            // $ci_level_step=DB::table('pro_level_step')
                            // ->Where('valid','1')
                            // // ->Where('status','1')
                            // ->Where('employee_id',$row_leave_app->employee_id)
                            // ->Where('report_to_id',$m_user_id)
                            // ->orderBy('employee_id','asc')
                            // ->get();

                            // $ci_list=DB::table('pro_leave_info_master')
                            // ->Where('valid','1')
                            // ->Where('status','1')
                            // // ->Where('employee_id',$row_leave_app->employee_id)
                            // ->orderBy('leave_form','DESC')
                            // ->get();
                            @endphp
                            @foreach($ci_list as $key=>$row_leave_app)
                            @php                            
                            $ci_leave_type=DB::table('pro_leave_type')->Where('valid','1')->Where('leave_type_id',$row_leave_app->leave_type_id)->first();
                            @endphp

                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_leave_app->employee_id }}<br>{{ $row_leave_app->employee_name }}<br>{{ $row_leave_app->company_name }}</td>
                                <td>{{ $row_leave_app->desig_name }}<br>{{ $row_leave_app->department_name }}<br>{{ $row_leave_app->mobile }}</td>
                                <td>{{ $ci_leave_type->leave_type }}<br>{{ $row_leave_app->leave_form }} to {{ $row_leave_app->leave_to }}</td>
                                <td>{{ $row_leave_app->entry_date }}<br>{{ $row_leave_app->entry_time }}</td>
                                <td>
                                    <a href="{{ route('leave_app_for_approval_other',$row_leave_app->leave_info_master_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            {{-- @endforeach --}}
                            {{-- @endforeach --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection