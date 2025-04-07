<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left align-top">SL No.</th>
                                <th class="text-left align-top">Product Group<br>Sub Group<br>Name</th>
                                <th class="text-left align-top">Pre.Issue Qty</th>
                                <th class="text-left align-top">Unit</th>
                                <th class="text-left align-top">Remarks</th>
                                <th class="text-center align-top">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rim_details as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $value->pg_name}}<br>{{ $value->pg_sub_name}}<br>{{ $value->product_name}}</td>
                                    <td>{{ $value->product_qty}}</td>
                                    <td>{{ $value->unit_name}}</td>
                                    <td>{{ $value->remarks}}</td>
                                    <td>
                                        <a href="{{ route('req_material_issue_edit',[$value->rid_id,$value->company_id]) }}">Edit</a>
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