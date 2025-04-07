<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="text-left align-top">SL No.</th>
                                <th class="text-left align-top">Project Name</th>
                                <th class="text-left align-top">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_project_name as $key => $value)
{{--                                 @php
                                    $company = DB::table('pro_company')
                                        ->Where('company_id', $value->company_id)
                                        ->first();
                                @endphp
 --}}                                <tr>
                                    <td class="text-left align-top">{{ $key + 1 }}</td>
                                    <td class="text-left align-top">{{ $value->project_name }}</td>
                                    <td class="text-left align-top">
                                        <a href="{{ route('project_name_edit', $value->project_id) }}"
                                            class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
