<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attendance Policy / Shift Information</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Company</th>
                                <th>Policy Name</th>
                                <th>Short Name</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Grace Time</th>
                                <th>Lunch Time</th>
                                <th>Lunch Break</th>
                                <th>Weekly Holiday</th>
                                <th>Multiple Holiday</th>
                                <th>Over Time</th>
                                <th>Act</th>
                                <th>Sub</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_company as $key=>$row_user_company)

                            @php
                            $data=DB::table('pro_att_policy')
                            ->join("pro_company", "pro_att_policy.company_id", "pro_company.company_id")
                            ->select("pro_att_policy.*", "pro_company.company_name")
                            ->Where('pro_att_policy.company_id',$row_user_company->company_id)
                            ->Where('pro_att_policy.valid','1')
                            ->orderBy('pro_att_policy.att_policy_id', 'desc')
                            ->get(); //query builder
                            @endphp
                            
                            @foreach($data as $key=>$row)
                            @php

                                if($row->ot_elgble==1){
                                    $txt_ot_elgble='Yes';
                                } else if($row->ot_elgble==2){
                                    $txt_ot_elgble='No';
                                }

                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->company_name }}</td>
                                <td>{{ $row->att_policy_name }}</td>
                                <td>{{ $row->pshortname }}</td>
                                <td>{{ $row->in_time }}</td>
                                <td>{{ $row->out_time }}</td>
                                <td>{{ $row->in_time_graced }}</td>
                                <td>{{ $row->lunch_time }}</td>
                                <td>{{ $row->lunch_break }}</td>
                                <td>{{ $row->weekly_holiday1 }}</td>
                                <td>{{ $row->weekly_holiday2 }}</td>
                                <td>{{ $txt_ot_elgble }}</td>
                                <td>
                                    <a href="{{ route('hrmbackpolicyedit', $row->att_policy_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                                @php

                                if($row->policy_status==1){
                                @endphp
                                <td>&nbsp;</td>
                                @php
                                } else if($row->policy_status==2){
                                @endphp
                                <td>
                                    <a href="{{ route('HrmPolicySubEdit', $row->att_policy_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                                @php
                                }
                                @endphp
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
