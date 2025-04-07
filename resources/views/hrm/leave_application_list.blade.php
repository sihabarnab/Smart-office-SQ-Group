@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Self Leave Report</h1>
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
                    
                    <table id="" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Type</th>
                                <th>Application<br>Date & Time</th>
                                <th>Applied For</th>
                                <th>Description</th>
                                <th>Approved For</th>
                                <th class="text-center">Approved By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($m_leave_info_master as $key=>$row_leave)
                            @php
                            $ci_leave_type=DB::table('pro_leave_type')
                            ->Where('valid','1')
                            ->Where('leave_type_id',$row_leave->leave_type_id)
                            ->first();
                            // dd($row_leave);
                            @endphp

                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $ci_leave_type->leave_type }} | {{ $ci_leave_type->leave_type_sname }}</td>
                                <td>{{ $row_leave->entry_date }}<br>{{ $row_leave->entry_time }}</td>
                                <td>{{ $row_leave->leave_form }} to {{ $row_leave->leave_to }}<br>{{ $row_leave->total }} day</td>
                                <td>{{ $row_leave->purpose_leave }}{{ $row_leave->leave_info_master_id }}</td>
                                <td>{{ $row_leave->g_leave_form }} to {{ $row_leave->g_leave_to }}<br>{{ $row_leave->g_leave_total }} day</td>
                                <td>
                                    <table id="" class="table table-borderless table-striped">
                                        @foreach($m_level_step as $key=>$row_level_step)
                                        @php
                                        // if ($row_leave->leave_info_master_id==NULL)
                                        // {
                                        //     $txt_leave_status="ffffffffff";
                                        // } else {
                                        $ci_leave_approved_details=DB::table('pro_leave_approved_details')
                                        ->Where('approved_id',$row_level_step->report_to_id)
                                        ->Where('leave_info_master_id',$row_leave->leave_info_master_id)
                                        ->Where('valid','1')
                                        ->first();
                                        // dd($ci_leave_approved_details);

                                        if($ci_leave_approved_details == NULL)
                                        {
                                            $txt_leave_status="Pending";
                                        } else {
                                            $txt_leave_status="Approved";
                                        }
                                        // }
                                        @endphp
                                        <tr>
                                            <td>{{ $row_level_step->employee_name }}</td>
                                            <td>{{ $txt_leave_status }}</td>
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