<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    <table id="" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Company Name<br />Employee ID/Name</th>
                                <th>Designation/Department<br />Posting</th>
                                <th>Reporting Boss</th>
                                <th>Report To</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            // dd($m_employee_info);
                            @endphp
                            
                            <tr>
                                <td>{{ $m_employee_info->company_name }}<br>{{ $m_employee_info->employee_id }}<br>{{ $m_employee_info->employee_name }}</td>
                                <td>{{ $m_employee_info->desig_name }}<br>{{ $m_employee_info->department_name }}<br>{{ $m_employee_info->placeofposting_name }}
                                </td>
                                <td>{{ $m_employee_info->level_step }} Persons
                                </td>
                                <td>
                                    <table>
                                        @php
                                            $m_level_step = DB::table('pro_level_step')
                                            ->leftjoin('pro_employee_info', 'pro_level_step.report_to_id', 'pro_employee_info.employee_id')
                                            ->select('pro_level_step.*','pro_employee_info.employee_name','pro_employee_info.employee_id')
                                            ->where('pro_level_step.employee_id', $m_employee_info->employee_id)
                                            ->orderby('pro_level_step.level_step','ASC')
                                            ->get();
                                        @endphp
                                        @foreach($m_level_step as $key=>$row_level_step)
                                        <tr>
                                            {{-- <td>{{ $key+1 }}</td> --}}
                                            <td>{{ $row_level_step->level_step }}</td>
                                            {{-- <td>{{ $row_level_step->level_step_id }}</td> --}}
                                            <td>{{ $row_level_step->employee_id }}</td>
                                            <td>{{ $row_level_step->employee_name }}</td>
                                            <td>
                                                <a href="{{ route('HrmReportingBossEdit', $row_level_step->level_step_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>

                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>