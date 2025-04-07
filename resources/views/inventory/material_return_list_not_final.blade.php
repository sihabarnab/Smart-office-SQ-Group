<div class="container-fluid pt-1 pb-2">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h4 class="m-0"> Return List (Not Final)</h4>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Company</th>
                                <th>Project</th>
                                <th>Section</th>
                                <th>Requesition No/Date</th>
                                <th>Prepared By</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $x = 1;
                            @endphp
                            @if (isset($user_company))
                                @foreach ($user_company as $row_table)
                                    @php
                                        $y = $row_table->company_id;
                                        $gm_return_master = DB::table("pro_gmaterial_return_master_$y")
                                            ->leftJoin('pro_project_name', "pro_gmaterial_return_master_$y.project_id", 'pro_project_name.project_id')
                                            ->leftJoin('pro_section_information',"pro_gmaterial_return_master_$y.section_id", 'pro_section_information.section_id')
                                            ->leftJoin('pro_company',"pro_gmaterial_return_master_$y.company_id", 'pro_company.company_id')
                                            ->select(
                                                "pro_gmaterial_return_master_$y.*",
                                                'pro_project_name.project_name',
                                                'pro_section_information.section_name',
                                                'pro_company.company_name',
                                            )
                                            ->where("pro_gmaterial_return_master_$y.status", '=', '1')
                                            ->get();
                                    @endphp

                                    @foreach ($gm_return_master as $key => $value)
                                        <tr>
                                            <td>{{ $x++ }}</td>
                                            <td>{{ $value->company_name }}</td>
                                            <td>{{ $value->project_name }}</td>
                                            <td>{{ $value->section_name }}</td>
                                            <td>{{ $value->return_master_no }} <br> {{ $value->return_date }} </td>
                                            <td>
                                                @php
                                                    $employee = DB::table('pro_employee_info')
                                                        ->where('employee_id', $value->user_id)
                                                        ->first();
                                                @endphp
                                                @isset($employee)
                                                    {{ $employee->employee_name }}
                                                @endisset

                                            </td>
                                            <td><a href="{{ route('inventory_material_return_details', [$value->return_master_no,$value->company_id]) }}"
                                                    class="btn bg-primary"><i class="fas fa-edit"></i></a></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
