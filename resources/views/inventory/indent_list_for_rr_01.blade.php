<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Receving Report</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data2" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-left align-top">SL No.</th>
                                        <th class="text-left align-top">Company</th>
                                        <th class="text-left align-top">Project</th>
                                        <th class="text-left align-top">Indent No / Date</th>
                                        <th class="text-left align-top">Indent Category</th>
                                        <th class="text-left align-top"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pro_indent_master as $key => $value)
                                        <tr>
                                            <td class="text-left align-top">{{ $key + 1 }}</td>
                                            <td class="text-left align-top">{{ $value->company_name }}</td>
                                            <td class="text-left align-top">{{ $value->project_name }}</td>
                                            <td class="text-left align-top">{{ $value->indent_no }} <br>
                                                {{ $value->entry_date }} </td>
                                            <td class="text-left align-top">{{ $value->category_name }}</td>
                                            <td class="text-left align-top">
                                                <a target="_blank"
                                                    href="{{ route('inventory_indent_receiving_report', [$value->indent_no,$value->company_id]) }}">Create
                                                    RR</a>
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

