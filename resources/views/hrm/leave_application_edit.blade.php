<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Leave List For Edit</h3>
                </div>
                <div class="card-body">
                    <table id="" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Type</th>
                                <th>Application<br>Date & Time</th>
                                <th>Applied For</th>
                                <th>Description</th>
                                <th>Action</th>
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
                                <td>{{ $row_leave->purpose_leave }}</td>
                                <td>
                                    <a href="{{ route('HrmLleaveAppEdit', $row_leave->leave_info_master_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
