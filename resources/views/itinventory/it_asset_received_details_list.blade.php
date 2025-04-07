<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">IT Asset Received Details List</h5>
                </div>
                <div class="card-body">
                    <table id="it_asset_issue_list" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>IT Asset ID</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Receive Date</th>
                                <th>Remarks</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($m_itasset_receving_details as $key=> $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->itasset_id }}</td>
                                <td>{{ $value->product_type_name }} | {{ $value->brand_name }} | {{ $value->model }}</td>
                                <td>{{ $value->itasset_qty }}</td>
                                <td>{{ $value->entry_date }}</td>
                                <td>{{ $value->remarks }}</td>
                                <td><a href="{{route('ItAssetReceivedDetailsEdit',$value->itasset_receiving_details_id)}}">Edit</a></td>
                            </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
