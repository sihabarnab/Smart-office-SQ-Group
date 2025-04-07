<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Product Group <br> Product sub Group <br> Product Name</th>
                                <th>Remarks</th>
                                <th>Unit</th>
                                <th>Good Qty</th>
                                <th>Bad Qty</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gm_return_details as $key=>$value)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>{{ $value->pg_name}} <br> {{ $value->pg_sub_name}}  <br> {{ $value->product_name}}</td>
                                    <td>{{ $value->comments}}</td>
                                    <td>{{ $value->unit_name}}</td>
                                    <td>{{ $value->useable_qty}}</td>
                                    <td>{{ $value->damage_qty}}</td>
                                    <td><a href="{{ route('inventory_material_return_edit',[$value->mreturnd_id,$value->company_id]) }}" class="btn bg-primary"><i class="fas fa-edit"></i></a></td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>