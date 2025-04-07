<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bank Details List</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Bank Name</th>
                                <th>Short Name</th>
                                <th>Branch</th>
                                <th>Address</th>
                                <th>Swift Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($data as $key=>$row)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->bank_name }}</td>
                                <td>{{ $row->bank_sname }}</td>
                                <td>{{ $row->branch_name }}</td>
                                <td>{{ $row->bank_add }}</td>
                                <td>{{ $row->swift_code }}</td>
                                <td>
                                    <a href="{{ route('bank_details_edit',$row->bank_details_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
