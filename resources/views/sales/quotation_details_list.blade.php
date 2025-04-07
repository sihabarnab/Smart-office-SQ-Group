<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">QUATATION DETAILS LIST</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Item</th>
                                <th>Specification</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Extended Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_quotation_details as $key=>$row)  
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->product_name }}</td>
                                <td>{{ $row->product_description }}</td>
                                <td class="text-right">{{ number_format($row->qty,2) }}</td>

                                <td class="text-right">{{ number_format($row->rate,2) }}</td>
                                <td class="text-right"> {{ number_format($row->rate*$row->qty,2) }}</td>
                                <td> <a href="{{ route('quotation_details_edit',[$row->quotation_details_id,$row->company_id]) }}">Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>