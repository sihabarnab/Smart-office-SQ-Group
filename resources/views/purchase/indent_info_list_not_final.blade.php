<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Indent List (Not Final)</h1>
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="text-left align-top">SL No.</th>
                                <th class="text-left align-top">Company</th>
                                <th class="text-left align-top">Project</th>
                                <th class="text-left align-top">Indent No/ Date</th>
                                <th class="text-left align-top">Indent Category</th>
                                <th class="text-left align-top">Prepared By</th>
                                <th class="text-left align-top"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $x = 1;
                            @endphp
                            @if (isset($user_company))
                                @foreach ($user_company as $row_table)
                                    @php
                                    $y=$row_table->company_id;
                                        $pro_indent_master = DB::table("pro_indent_master_$y")
                                            ->leftJoin('pro_project_name', "pro_indent_master_$y.project_id", 'pro_project_name.project_id')
                                            ->leftJoin('pro_indent_category', "pro_indent_master_$y.indent_category", 'pro_indent_category.category_id')
                                            ->select("pro_indent_master_$y.*", 'pro_project_name.project_name', 'pro_indent_category.category_name')
                                            ->where("pro_indent_master_$y.status", '1')
                                            ->where("pro_indent_master_$y.company_id",$y)
                                            ->get();
                                    @endphp

                                    @foreach ($pro_indent_master as $row)
                                        {{-- @dd($row[$key]->category_name) --}}
                                        <tr>
                                            <td class="text-left align-top">{{ $x++ }}</td>
                                            <td class="text-left align-top">{{ $row_table->company_name }}</td>
                                            <td class="text-left align-top">
                                                {{ $row->project_name == null ? '' : $row->project_name }}
                                            </td>
                                            <td class="text-left align-top">{{ $row->indent_no }} <br>
                                                {{ $row->entry_date }} </td>
                                            <td class="text-left align-top">
                                                {{ $row->category_name == null ? '' : $row->category_name }}
                                            </td>
                                            <td class="text-left align-top">
                                                @php
                                                    $emp_name = DB::table('pro_employee_info')
                                                        ->where('employee_id', $value->user_id)
                                                        ->first();
                                                    if($emp_name == null){
                                                        $employee_name = '';
                                                    }else{
                                                      $employee_name = $emp_name->employee_name;  
                                                    }

                                                @endphp
                                                {{ $employee_name }}
                                            </td>
                                            <td class="text-left align-top">
                                                <a href="{{ route('purchase_indent_edit',[$row->indent_no,$row->company_id]) }}">Add
                                                    /
                                                    Edit Indent</a>
                                            </td>

                                        </tr>
                                        {{-- @php
                                            $x = $x + 1;
                                        @endphp --}}
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
