@php
    $mr = DB::table("pro_money_receipt_$sales_master->company_id")
        ->where('sim_id', $sales_master->sim_id)
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
                                <th>Invoice #</th>
                                <th>Date</th>
                                <th>Money Receipt</th>
                                <th>Date</th>
                                <th>MR Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mr as $key => $row)
                                @php
                                    $total = $total + $row->mr_amount;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $sales_master->sim_id }}</td>
                                    <td>{{ $sales_master->sim_date }}</td>
                                    <td>{{ $row->mr_id }}</td>
                                    <td>{{ $row->collection_date }}</td>
                                    <td>{{ $row->mr_amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right">Total:</td>
                                <td>{{ $total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
