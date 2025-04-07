@php
    $total = 0;
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="quotation_list" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Item</th>
                                <th>Unit</th>
                                <th>QTY</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($d_challan_details as $key => $row)
                                @php
                                    $serial1 = DB::table("pro_finish_product_serial_$row->company_id")
                                        ->where('delivery_chalan_master_id', $row->delivery_chalan_master_id)
                                        ->where('product_id', $row->product_id)
                                        ->where('status',3)
                                        ->count();

                                    $total = $total + $row->del_qty;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->product_name }}</td>
                                    <td>{{ $row->unit_name }}</td>
                                    <td>{{ $row->del_qty }}</td>
                                   
                                    @if ($serial1 == $row->del_qty)
                                    <td>Edit</td>
                                    <td>Serial</td>
                                    @else
                                    <td> <a href="{{ route('delivery_challan_serial', [$row->delivery_chalan_details_id, $row->company_id]) }}">Serial</a></td>
                                    <td> <a href="{{ route('delivery_challan_details_edit', [$row->delivery_chalan_details_id, $row->company_id]) }}">Edit</a></td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right">Total:</td>
                                <td colspan="1">{{ $total }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
