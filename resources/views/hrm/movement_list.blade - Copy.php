<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div align="left" class=""><h5><?="Movement Application List"; ?></h5></div>
                    <table id="data2" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Type</th>
                                <th>Application<br>Date & Time</th>
                                <th>Applied For</th>
                                <th>Purpose</th>
                                <th>Approved For</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_late_inform_master as $key=>$row_late_app)
                            @php
                            $ci_late_type=DB::table('pro_late_type')->Where('valid','1')->Where('late_type_id',$row_late_app->late_type_id)->first();

                            @endphp


                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $ci_late_type->late_type }}</td>
                                <td>{{ $row_late_app->entry_date }}<br>{{ $row_late_app->entry_time }}</td>
                                <td>{{ $row_late_app->late_form }} to {{ $row_late_app->late_to }}<br>{{ $row_late_app->late_total }} day</td>
                                <td>{{ $row_late_app->purpose_late }}</td>
                                <td>{{ $row_late_app->approved_date }}</td>
                                <td>
                                    <table id="" class="table table-borderless table-striped">
                                        @foreach($m_level_step as $key=>$row_level_step)
                                        @php

                                        $ci_late_inform_details=DB::table('pro_late_inform_details')
                                        ->Where('approved_id',$row_level_step->report_to_id)
                                        ->Where('late_inform_master_id',$row_late_app->late_inform_master_id)
                                        ->Where('valid','1')
                                        ->first();

                                        if($ci_late_inform_details == NULL)
                                        {
                                            $ci_late_inform_master_01=DB::table('pro_late_inform_master')
                                            // ->Where('approved_id',$row_level_step->report_to_id)
                                            ->Where('late_inform_master_id',$row_late_app->late_inform_master_id)
                                            ->Where('valid','1')
                                            ->first();

                                            if($ci_late_inform_master_01->status=='1')
                                            {
                                                $txt_late_status="Pending";
                                            } else if($ci_late_inform_master_01->status=='3')
                                            {
                                                $txt_late_status="Reject";
                                            }
                                            
                                        } else {
                                            $txt_late_status="Approved";
                                        }
                                        // dd($txt_late_status);
                                        @endphp

                                        <tr>
                                            <td>{{ $row_level_step->employee_name }}</td>
                                            <td>{{ $txt_late_status }}</td>
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