<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Product Group</th>
                                <th>Product Sub Group</th>
                                <th>Product Name </th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($m_fpsd as $key=> $value)
                            @php
                                // dd($value->fpsd_id);
                            @endphp
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->pg_name }}</td>
                                <td>{{ $value->pg_sub_name }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->product_description }}</td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ $value->unit_name }}</td>
                                <td><a href="{{route('FinishProductDetailsEdit',[$value->fpsd_id,$value->company_id])}}">Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>