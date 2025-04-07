@php
    $net_total = 0;

    $req_details = DB::table("pro_sales_requisition_details_$req_master->company_id")
    ->leftJoin("pro_finish_product_$req_master->company_id", "pro_sales_requisition_details_$req_master->company_id.product_id", "pro_finish_product_$req_master->company_id.product_id")
    ->leftJoin('pro_units',"pro_finish_product_$req_master->company_id.unit", 'pro_units.unit_id')
    ->select("pro_sales_requisition_details_$req_master->company_id.*", "pro_finish_product_$req_master->company_id.product_name","pro_finish_product_$req_master->company_id.product_description",'pro_units.unit_name')
    ->where("pro_sales_requisition_details_$req_master->company_id.requisition_master_id", $req_master->requisition_master_id)
    ->get();
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
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Commision</th>
                                <th>Carring</th>
                                <th>Extended</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($req_details as $key => $row)

                            @php
                              $net_total = $net_total +  $row->net_total ;
                            @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->product_name }}</td>
                                    <td>{{ $row->product_description }}</td>
                                    <td class="text-right">{{ number_format($row->qty,2) }}</td>
                                    <td class="text-right">{{ number_format($row->rate,2) }}</td>
                                    <td class="text-right">{{ number_format($row->comm_rate,2) }}</td>
                                    <td class="text-right">{{ number_format($row->transport_rate,2) }}</td>
                                    <td class="text-right">{{ number_format($row->net_total,2) }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-right">Total:</td>
                                <td class="text-right">{{number_format($net_total,2)}}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="row">
                        <div class="col-10 text-right">
                            Opening Balance:
                        </div>
                        <div class="col-2 text-right">
                         {{number_format($req_master->last_balance,2)}} 
                         <hr  class="m-0" style="border-top: 2px solid #fff;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10 text-right">
                            Grand Total:
                        </div>
                        <div class="col-2 text-right">
                            @php
                                $grand_total= $net_total + ($req_master->last_balance);
                            @endphp
                            {{number_format($grand_total,2)}}
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-10 text-right">
                            Committed Deposit Amount:
                        </div>
                        <div class="col-2 text-right">
                            {{ number_format($req_master->deposit_amount,2) }} 
                            <hr  class="m-0" style="border-top: 2px double #fff;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-10 text-right">
                            Net Balance:
                        </div>
                        <div class="col-2 text-right">
                             @php
                                 $net_balance= ($grand_total) - ($req_master->deposit_amount)
                             @endphp
                              {{ number_format($net_balance,2) }}
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
