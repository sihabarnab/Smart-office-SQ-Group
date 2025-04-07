@php
    $sales_details = DB::table("pro_sid_$sales_master->company_id")
        ->leftJoin("pro_rate_policy_$sales_master->company_id", "pro_sid_$sales_master->company_id.rate_policy_id", "pro_rate_policy_$sales_master->company_id.rate_policy_id")
        ->leftJoin("pro_finish_product_$sales_master->company_id", "pro_sid_$sales_master->company_id.product_id", "pro_finish_product_$sales_master->company_id.product_id")
        ->leftJoin('pro_units', "pro_finish_product_$sales_master->company_id.unit", 'pro_units.unit_id')
        ->select("pro_sid_$sales_master->company_id.*","pro_finish_product_$sales_master->company_id.product_description", "pro_finish_product_$sales_master->company_id.product_name", "pro_rate_policy_$sales_master->company_id.rate_policy_name", 'pro_units.unit_name')
        ->where("pro_sid_$sales_master->company_id.sim_id", $sales_master->sim_id)
        ->get();
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
                                <th>Specification</th>
                                <th>Reference</th>
                                <th>Rate Policy</th>
                                <th>Unit</th>
                                <th>QTY</th>
                                <th>Unit Price</th>
                                <th>Extended Price</th>
                                <th>Discount</th>
                                <th>Transfort Discount</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_details as $key => $row)
                                @php
                                    $serial = DB::table("pro_finish_product_serial_$sales_master->company_id")
                                        ->where('product_id', $row->product_id)
                                        ->where('sim_id', $sales_master->sim_id)
                                        ->count();
                                    $total = $total + $row->total;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->product_name }}</td>
                                    <td>{{ $row->product_description }}</td>
                                    <td>{{ $row->auth_ref_no }}</td>
                                    <td>{{ $row->rate_policy_name }}</td>
                                    <td>{{ $row->unit_name }}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ $row->rate }}</td>
                                    <td>{{ $row->total }}</td>
                                    <td>{{ $row->total_discount }}</td>
                                    <td>{{ $row->total_transport }}</td>
                                    @if ($serial)
                                    <td> Serial </td>
                                    <td>Edit</td>
                                    @else
                                        <td><a
                                                href="{{ route('sales_invoice_add_serial', [$row->sid_id, $row->company_id]) }}">Serial</a>
                                        </td>
                                        <td> <a
                                                href="{{ route('sales_invoice_details_edit', [$row->sid_id, $row->company_id]) }}">Edit</a>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10" class="text-right">Total:</td>
                                <td colspan="3">{{ $total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
