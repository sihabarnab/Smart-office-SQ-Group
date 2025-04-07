@php
    $mr_details = DB::table("pro_money_receipt_$mr_master->company_id")
        ->where('mr_master_id', $mr_master->mr_master_id)
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
                                <th>Product Type</th>
                                <th>Customer Name</th>
                                <th>Payment Type</th>
                                <th>MR Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($mr_details as $key => $row)
                                @php
                                    $pay_type = DB::table('pro_payment_type')
                                        ->where('payment_type_id', $row->payment_type)
                                        ->first();
                                    $customer = DB::table("pro_customer_information_$mr_master->company_id")
                                        ->where('customer_id', $row->customer_id)
                                        ->first();
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->pg_id == 28 ? 'TRANSFORMER' : 'CTPT' }}</td>
                                    <td>
                                        {{ $customer->customer_name == null ? '' : $customer->customer_name }}
                                    </td>
                                    <td>
                                        {{ $pay_type->payment_type == null ? '' : $pay_type->payment_type }}
                                    </td>

                                    <td>
                                        @php
                                            $total = $row->mr_amount + $total;
                                        @endphp
                                        {{ $row->mr_amount }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Total</td>
                                <td>{{ $total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
