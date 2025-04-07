
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
                                <th>Serial Number</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($serial as $key => $row)
                                @php
                                    $product = DB::table("pro_finish_product_$riv_master->company_id")
                                        ->where('product_id', $row->product_id)
                                        ->first();
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $product->product_name }}
                                    </td>
                                    <td>{{ $row->serial_no }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
