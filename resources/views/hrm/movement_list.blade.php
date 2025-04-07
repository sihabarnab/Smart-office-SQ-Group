<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div align="left" class="">
                        <h5><?= 'Movement Application List' ?></h5>
                    </div>
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

                            @foreach ($ci_late_inform_master as $key => $row_late_app)
                                @php
                                    $ci_late_type = DB::table('pro_late_type')
                                        ->Where('valid', '1')
                                        ->Where('late_type_id', $row_late_app->late_type_id)
                                        ->first();

                                @endphp


                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $ci_late_type->late_type }}</td>
                                    <td>{{ $row_late_app->entry_date }}<br>{{ $row_late_app->entry_time }}</td>
                                    <td>{{ $row_late_app->late_form }} to
                                        {{ $row_late_app->late_to }}<br>{{ $row_late_app->late_total }} day</td>
                                    <td>{{ $row_late_app->purpose_late }}</td>
                                    <td>{{ $row_late_app->approved_date }}</td>
                                    <td>
                                        <table id="" class="table table-borderless table-striped">
                                            @php

                                                $m_level_step = DB::table('pro_level_step')
                                                    ->leftjoin(
                                                        'pro_employee_info',
                                                        'pro_level_step.report_to_id',
                                                        'pro_employee_info.employee_id',
                                                    )
                                                    ->select('pro_level_step.*', 'pro_employee_info.employee_name')
                                                    ->Where('pro_level_step.employee_id', $row_late_app->employee_id)
                                                    ->Where('pro_level_step.valid', '1')
                                                    ->orderby('pro_level_step.level_step', 'DESC')
                                                    ->get();

                                            @endphp

                                            @foreach ($m_level_step as $row)
                                                <tr>
                                                    <td>{{ $row->employee_name }}</td>
                                                    <td>
                                                        @php
                                                            $approved_check = DB::table('pro_late_approved_details')
                                                                ->where(
                                                                    'late_inform_master_id',
                                                                    $row_late_app->late_inform_master_id,
                                                                )
                                                                ->where('approved_id', $row->report_to_id)
                                                                ->first(); //approved other
                                                            $approved_check01 = DB::table('pro_late_inform_details')
                                                                ->where(
                                                                    'late_inform_master_id',
                                                                    $row_late_app->late_inform_master_id,
                                                                )
                                                                ->where('approved_id', $row->report_to_id)
                                                                ->first(); //direct approved
                                                        @endphp
                                                        @if (isset($approved_check) || isset($approved_check01))
                                                            {{ 'Approved' }}
                                                        @else
                                                            {{-- //reject person --}}
                                                            @if ($row_late_app->status == 3 && $row_late_app->late_approved == $row->report_to_id)
                                                                {{ 'Reject' }}
                                                            @else
                                                                {{ 'Pending' }}
                                                            @endif
                                                        @endif

                                                    </td>

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
