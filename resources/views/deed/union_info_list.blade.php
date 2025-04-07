<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th width='10%'>SL No.</th>
                                <th width='20%'>Division</th>
                                <th width='20%'>District</th>
                                <th width='20%'>Upazilas</th>
                                <th width='20%'>Union</th>
                                <th width='10%'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_union_infos as $key => $value)

                            @php

                            $ci_upazilas=DB::table('pro_upazilas')
                            ->Where('upazilas_id',$value->upazilas_id)
                            ->first();

                            $ci_districts=DB::table('pro_districts')
                            ->Where('districts_id',$ci_upazilas->districts_id)
                            ->first();

                            $ci_divisions=DB::table('pro_divisions')
                            ->Where('divisions_id',$ci_upazilas->divisions_id)
                            ->first();


                            @endphp

                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $ci_divisions->divisions_name}} | {{ $ci_divisions->divisions_bn_name}}</td>
                                    <td>{{ $ci_districts->district_name}} | {{ $ci_districts->district_bn_name}}</td>
                                    <td>{{ $value->upazilas_name}} | {{ $value->upazilas_bn_name}}</td>
                                    <td>{{ $value->unions_name}} | {{ $value->unions_bn_name}}</td>
                                    <td>
                                    <a href="" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
