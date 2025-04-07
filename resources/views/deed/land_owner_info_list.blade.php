<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>

                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Name</th>
                                <th>Birth</th>
                                <th>Religious</th>
                                <th>NID No.</th>
                                <th>Profession</th>
                                <th>Present Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_land_owner_info as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $value->owner_name_eng }}<br>{{$value->owner_name_bang}}</td>
                                    <td>{{ $value->owner_dob }}</td>
                                    <td>{{ $value->owner_religous_eng }}<br>{{$value->owner_religous_bang}}</td>
                                    <td>{{ $value->owner_nid_eng }}<br>{{$value->owner_nid_bang}}</td>
                                    <td>{{ $value->owner_profession_eng }}<br>{{$value->owner_profession_bang}}</td>
                                    <td>{{ $value->owner_present_add_eng }}<br>{{$value->owner_present_add_bang}}</td>
                                    <td>
                                    <a href="{{ route('DeedLandOwnerInfoEdit',$value->land_owner_info_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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


