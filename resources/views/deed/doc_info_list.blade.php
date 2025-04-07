<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm small">
                        <thead>
                            <tr>
                                <th width='10%'>SL No.</th>
                                <th width='20%'>Document Type</th>
                                <th width='10%'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_doc_info as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $value->doc_info_name}}</td>
                                    <td>
                                    <a href="{{ route('DeedDocInfoEdit', $value->doc_info_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                    </td>
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
