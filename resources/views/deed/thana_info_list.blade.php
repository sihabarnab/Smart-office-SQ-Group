<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Division</th>
                                <th>District</th>
                                <th>Thana</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_thana_infos as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $value->divisions_name}} | {{$value->divisions_bn_name}}</td>
                                    <td>{{ $value->district_name}} | {{ $value->district_bn_name}}</td>
                                    <td>{{ $value->upazilas_name}} | {{ $value->upazilas_bn_name}}</td>
                                    <td>
                                    <a href="{{ route('DeedUpzilaEdit',$value->upazilas_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
