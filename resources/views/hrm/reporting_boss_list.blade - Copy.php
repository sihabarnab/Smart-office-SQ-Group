<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Company Name<br />Employee ID/Name</th>
                                <th>Designation/Department<br />Posting</th>
                                <th>Report To</th>
                                <th>aaaaa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_company as $key=>$row_company)
                                @php
                                $m_employee_info=DB::table('pro_employee_info')
                                ->Where('company_id',$row_company->company_id)
                                ->Where('valid',1)
                                ->get();
                                $i=1;
                                @endphp
                                @foreach($m_employee_info as $mkey=>$row_biodata)
                                    @php

                                    $mmm_employee_info=DB::table('pro_employee_info')
                                    ->leftjoin("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
                                    ->leftjoin("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
                                    ->leftjoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
                                    ->leftjoin("pro_placeofposting", "pro_employee_info.placeofposting_id", "pro_placeofposting.placeofposting_id")

                                    ->select("pro_employee_info.*", "pro_company.company_name", "pro_desig.desig_name","pro_department.department_name","pro_placeofposting.placeofposting_name")

                                    ->Where('pro_employee_info.employee_id',$row_biodata->employee_id)
                                    ->first();

                                    // dd($mmm_employee_info);
                                    @endphp
                                    <tr>
                                    <td>a</td>
                                    <td>
                                        {{ $mmm_employee_info->company_name }}<br>
                                        {{ $mmm_employee_info->employee_id }}<br>
                                        {{ $mmm_employee_info->employee_name }}
                                    </td>
                                    <td>
                                        {{ $mmm_employee_info->desig_name }}<br>
                                        {{ $mmm_employee_info->department_name }}<br>
                                        {{ $mmm_employee_info->placeofposting_name }}
                                    </td>
                                    <td>
                                        <table>
                                            @php
                                                $mmm_level_step=DB::table('pro_level_step')
                                                ->Where('pro_level_step.employee_id',$row_biodata->employee_id)
                                                // ->orderBy('pro_level_step.level_step_id')
                                                ->get();
                                            @endphp
                                            @foreach($mmm_level_step as $key1=>$row_level_step)
                                            @php
                                                $mm_report=DB::table('pro_employee_info')
                                                ->Where('employee_id',$row_level_step->report_to_id)
                                                // ->orderBy('pro_level_step.level_step_id')
                                                ->first();

                                            @endphp
                                            <tr>
                                                <td>{{ $row_level_step->level_step }}</td>
                                                <td>{{ $row_level_step->report_to_id }}</td>
                                                <td>{{ $mm_report->employee_name }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>aa</td>                               
                                </tr>

                                @php
                                $i++;
                                @endphp
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>