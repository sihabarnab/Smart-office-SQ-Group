<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Issue (not final)</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Project</th>
                                <th>Section</th>
                                <th>Issue No/Date</th>
                                <th>Requsition No/Date</th>
                                <th>Prefered by</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issue_master as $key=>$value)
                            @php
                            // if($value->user_id){
                            //   $user =  DB::table('pro_employee_info')->where("employee_id",$value->user_id)->first();
                            //   $prepared_by = $user->employee_name;
                            // }else{
                            //     $prepared_by ="";
                            // }
                            @endphp     
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->project_name }}</td>
                                <td>{{ $value->section_name }}</td>
                                 <td>{{ $value->rim_no }} <br> {{  $value->rim_date }}</td>
                                <td>{{ $value->mrm_no }} <br> {{  $value->mrm_date }}</td>
                                <td>{{ $value->user_id	 }}</td>
                                <td><a href="{{ route('inventory_req_material_issue_details',$value->rim_no) }}" class="btn bg-primary"><i class="fas fa-edit"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>