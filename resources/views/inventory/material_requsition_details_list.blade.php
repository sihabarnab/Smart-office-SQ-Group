<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Product Group</th>
                                <th>Product Sub Group</th>
                                <th>Product Name </th>
                                <th>Remarks</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mr_details as $key=> $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->pg_name }}</td>
                                <td>{{ $value->pg_sub_name }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->remarks }}</td>
                                <td>{{ $value->requsition_qty }}</td>
                                <td>{{ $value->unit_name }}</td>
                                <td><a href="{{ route('inventory_material_req_details_edit',[$value->mrd_id,$value->company_id]) }}">Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>