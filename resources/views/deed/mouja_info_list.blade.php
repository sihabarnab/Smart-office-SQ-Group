<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm small">
                        <thead>
                            <tr>
                                <th width='10%'>SL No.</th>
                                <th width='20%'>Division</th>
                                <th width='20%'>District</th>
                                <th width='20%'>Upazilas</th>
                                <th width='20%'>Mouja</th>
                                <th width='10%'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_mouja_infos as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $value->divisions_name}} | {{$value->divisions_bn_name}}</td>
                                    <td>{{ $value->district_name}} | {{ $value->district_bn_name}}</td>
                                    <td>{{ $value->upazilas_name}} | {{ $value->upazilas_bn_name}}</td>
                                    <td>{{ $value->moujas_name}} | {{ $value->moujas_bn_name}}</td>
                                    <td>
                                    <a href="{{ route('DeedMoujaEdit',$value->moujas_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
