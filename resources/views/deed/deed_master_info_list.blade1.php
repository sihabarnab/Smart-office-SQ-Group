@if($pro_deed_masters)
<section class="container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable"  class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th  >SL No.</th>
                                    <th  >Serial No.</th>
                                    <th  >Book No.</th>
                                    <th  >Deed No.</th>
                                    <th  >Deed Date.</th>
                                    <th  >Division</th>
                                    <th  >District</th>
                                    <th  >Upazilas</th>
                                    <th  >Mouja</th>
                                    <th  >Deed Type</th>
                                    <th  ></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pro_deed_masters as $key => $pro_deed_master)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $key+1 }}</td>
                                        <td style="vertical-align: middle;">{{ $pro_deed_master->deed_sl}}</td>
                                        <td style="vertical-align: middle;">{{ $pro_deed_master->book_no}}</td>
                                        <td style="vertical-align: middle;">{{ $pro_deed_master->deed_no}}</td>
                                        <td style="vertical-align: middle;">{{ $pro_deed_master->deed_date}}</td>
                                        <td style="vertical-align: middle;">{{ $pro_deed_master->divisions_name}} | {{$pro_deed_master->divisions_bn_name}}</td>
                                        <td style="vertical-align: middle;">{{ $pro_deed_master->district_name}} | {{ $pro_deed_master->district_bn_name}}</td>
                                        <td style="vertical-align: middle;">{{ $pro_deed_master->upazilas_name}} | {{ $pro_deed_master->upazilas_bn_name}}</td>
                                        <td style="vertical-align: middle;">{{ $pro_deed_master->moujas_name}} | {{ $pro_deed_master->moujas_bn_name}}</td>
                                        <td style="vertical-align: middle;">{{ $pro_deed_master->deed_type_name}} | {{ $pro_deed_master->deed_type_name}}</td>
                                        <td style="vertical-align: middle;">
                                            <a href="#" class="btn btn-info">Edit</a>
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
</section>
@endif
