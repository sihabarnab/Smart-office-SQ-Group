<div class="container-fluid pt-1 pb-2">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h4 class="m-0">Requsition List (Not Final)</h4>
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
                            @foreach ($user_company as $row_table)
                                @php
                                    $y = $row_table->company_id;
                                    $mr_master = DB::table("pro_gmaterial_requsition_master_$y")
                                        ->leftjoin(
                                            'pro_project_name',
                                            "pro_gmaterial_requsition_master_$y.project_id",
                                            'pro_project_name.project_id',
                                        )
                                        ->leftjoin(
                                            'pro_section_information',
                                            "pro_gmaterial_requsition_master_$y.section_id",
                                            'pro_section_information.section_id',
                                        )
                                        ->leftjoin(
                                            'pro_company',
                                            "pro_gmaterial_requsition_master_$y.company_id",
                                            'pro_company.company_id',
                                        )
                                        ->select(
                                            "pro_gmaterial_requsition_master_$y.*",
                                            'pro_project_name.project_name',
                                            'pro_section_information.section_name',
                                            'pro_company.company_name',
                                        )
                                        ->where("pro_gmaterial_requsition_master_$y.status", '=', 1)
                                        ->orderBy("pro_gmaterial_requsition_master_$y.mrm_date", 'DESC')
                                        ->get();

                                @endphp

                                @foreach ($mr_master as $key => $value)
                                    @php
                                        $prepared_by = '';
                                        if ($value->user_id) {
                                            $user = DB::table('pro_employee_info')
                                                ->where('employee_id', $value->user_id)
                                                ->first();
                                            if ($user == null) {
                                                $prepared_by = '';
                                            } else {
                                                $prepared_by = $user->employee_name;
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->company_name }}</td>
                                        <td>{{ $value->project_name }}</td>
                                        <td>{{ $value->section_name }}</td>
                                        <td>{{ $value->mrm_no }} <br> {{ $value->mrm_date }}</td>
                                        <td>{{ $prepared_by }}</td>
                                        <td><a href="{{ route('inventory_material_req_details', [$value->mrm_no, $value->company_id]) }}"
                                                class="btn bg-primary"><i class="fas fa-edit"></i></a></td>
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
