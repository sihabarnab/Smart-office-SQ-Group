@extends('layouts.deed_app')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">DEED INFO</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>



    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                    <div class="row">
                        <div class="col-3">
                            <small>Serial No : </small> {{ $pro_deed_master->deed_sl }}
                        </div>
                        <div class="col-3">
                            <small> Book No : </small>{{ $pro_deed_master->book_no }}
                        </div>
                        <div class="col-3">
                            <small> Deed No: </small> {{ $pro_deed_master->deed_no }}
                        </div>
                        <div class="col-3">
                            <small>Deed Date: </small> {{ $pro_deed_master->deed_date }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-2">
                            <small>Sub-Registry: </small>
                        </div>
                        <div class="col-3">
                            <small>{{ $pro_deed_master->sub_registry_eng }}</small>
                        </div>
                    </div>

                    
                    <h6 class="d-flex justify-content-center">Deed Summary</h6>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="text-left align-top"><small>Deed Type</small></th>
                                <th class="text-left align-top"><small>Division</small></th>
                                <th class="text-left align-top"><small>District</small></th>
                                <th class="text-left align-top"><small>Upazila/P.S</small></th>
                                <th class="text-left align-top"><small>Union</small></th>
                                <th class="text-left align-top"><small>Mouja</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left align-top"><small>{{ $pro_deed_master->deed_type_name }}</small></td>
                                <td class="text-left align-top"><small>{{ $pro_deed_master->divisions_name }}</small></td>
                                <td class="text-left align-top"><small>{{ $pro_deed_master->district_name }}</small></td>
                                <td class="text-left align-top"><small>{{ $pro_deed_master->upazilas_name }}</small></td>
                                <td class="text-left align-top"><small>
                                    @php
                                        $union= DB::table('pro_unions')->where('unions_id',$pro_deed_master->unions_id)->first();
                                                    @endphp
                                                    @isset( $union->unions_name)
                                            {{ $union->unions_name }}
                                            @endisset
                                        </small>
                                        </td>
                                <td class="text-left align-top"><small>{{ $pro_deed_master->moujas_name }}</small></td>
                              
                            </tr>
                            <tr>
                                <td  colspan="2" class="text-left align-top" ><small>Land Area</small></td>
                                <td  colspan="2" class="text-left align-top" ><small>Land Type</small></td>
                                <td  colspan="2" class="text-left align-top" ><small>Price</small></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-left align-top"><small>{{ $pro_deed_master->land_area }}</small> <small>{{ $pro_deed_master->land_unit_nane }} </small></td>
                                <td colspan="2" class="text-left align-top"><small>{{ $pro_deed_master->land_type_name }}</small></td>
                                <td colspan="2" class="text-left align-top"><small>{{ $pro_deed_master->land_price }}</small></td>
                            </tr>
                        </tbody>

                    </table>

                    @if (isset($pro_land_owner) && $pro_land_owner->count()!=0)
                    <h6 class="d-flex justify-content-center">Land Owner Info</h6>
                        <div class="row table-bordered">
                            @foreach ($pro_land_owner as $key => $value)
                                <div class="col-4">
                                  {{ $key + 1 }} : <small class="align-middle" style="margin-left: 20px;">{{ $value->owner_name_eng }}</small>
                                  
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (isset($pro_land_seller)  && $pro_land_seller->count()!=0)
                    <h6 class="d-flex justify-content-center mt-2">Land Seller info and the ownership of the transferred land</h6>
                        @foreach ($pro_land_seller as $key => $value)
                            <div class="row table-bordered">
                                <div class="col-2 ">{{ $key + 1 }}</div>
                                <div class="col-4 d-flex justify-content-start"> <small>{{ $value->seller_name_eng }}</small></div>
                                <div class="col-4 d-flex justify-content-end"><small>{{ $value->land_area }}</small> <small class="align-middle ml-1" >
                                        {{ $value->land_unit_nane }}</small> </div>
                            </div>
                        @endforeach
                    @endif

                    @if ($pro_tapsil)
                    <h6 class="text-center d-flex justify-content-center mt-2">Property Schedule</h6>
                    <div class="row">
                        <div class="col-2">
                            <h6 class="text-center d-flex justify-content-start"><small>Schedule Identity:</small></h6>
                        </div>
                        <div class="col-10">
                            <h6 class="text-center d-flex justify-content-start"><small>
                                @if(isset($union->unions_name))
                                             {{'District '.$pro_deed_master->district_name.', Upazila/P.S '.$pro_deed_master->upazilas_name.', Union '.$union->unions_name.', Mouja '.$pro_deed_master->moujas_name }}
                                    @else
                                   {{'District '.$pro_deed_master->district_name.', Upazila/P.S '.$pro_deed_master->upazilas_name.', Mouja '.$pro_deed_master->moujas_name }}
                                @endif                                

                               
                            </small></h6>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-3"><small>Jl NO:</small></div>
                            <div class="col-3"><small>CS : {{ $pro_tapsil->jl_cs }}</small> </div>
                            <div class="col-3"><small>SA : {{ $pro_tapsil->jl_sa }}</small></div>
                            <div class="col-3"><small>RS : {{ $pro_tapsil->jl_rs }}</small></div>
                        </div>
                        <div class="row">
                            <div class="col-3"><small>Khatiyan No:</small></div>
                            <div class="col-3"><small>CS : {{ $pro_tapsil->khatian_cs }}</small></div>
                            <div class="col-3"><small>SA : {{ $pro_tapsil->khatian_sa }}</small></div>
                            <div class="col-3"><small>RS : {{ $pro_tapsil->khatian_rs }}</small></div>
                        </div>
                        <div class="row">
                            <div class="col-3"><small>Dag No :</small></div>
                            <div class="col-3"><small>{{ $pro_tapsil->dag_eng }}</small></div>
                        </div>
                    @endif
                    @if (isset($pro_namjari) && $pro_namjari->count()!=0)
                        <div class="row table-bordered mt-2">
                            @foreach ($pro_namjari as $key => $value)
                                <div class="col-2">
                                    <small>{{ $key + 1 }}:</small>
                                </div>
                                <div class="col-5">
                                    <small>{{ $value->namjari_no }} </small>
                                </div>
                                <div class="col-5">
                                    <small> {{ $value->namjari_details_eng }}</small>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <hr>

                <a href="{{ route('DeedMasterInfoEnPrint',$pro_deed_master->deed_master_id) }}" class="btn btn-info">Print</a>

                </div><!-- /.col -->
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

@endsection
