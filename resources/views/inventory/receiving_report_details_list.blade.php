<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL No.aa</th>
                                <th>Product Group</th>
                                <th>Product Sub Group</th>
                                <th>Product Name </th>
                                <th>Approved Qty</th>
                                <th>RR Qty</th>
                                <th>Unit</th>
                                <th>Remarks</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_grr_details as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->pg_name }}</td>
                                <td>{{ $value->pg_sub_name }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->indent_qty }}</td>
                                <td>{{ $value->received_qty }}</td>
                                <td>
                                    @php
                                $unit=DB::table('pro_units')->where('unit_id',$value->unit)->first();
                                    @endphp
                                    @isset($unit)
                                    {{ $unit->unit_name }}
                                    @endisset
                                </td>
                                <td>{{ $value->remarks }}</td>
                                <td><a class="btn bg-primary" href="{{ route('inventory_receiving_report_edit',[$value->grr_details_id,$value->company_id]) }}"><i class="fas fa-edit"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>