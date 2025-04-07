@extends('layouts.deed_app')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">দলিলের তথ্য</h1>
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
                            <small>ক্রমিক নং : </small> {{ $pro_deed_master->deed_sl }}
                        </div>
                        <div class="col-3">
                            <small>বহি নং : </small>{{ $pro_deed_master->book_no }}
                        </div>
                        <div class="col-3">
                            <small>দলিল নং : </small> {{ $pro_deed_master->deed_no }}
                        </div>
                        <div class="col-3">
                            <small>তারিখ : </small> {{ $pro_deed_master->deed_date }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-2">
                            <small>সাব-রেজিস্ট্রি : </small>
                        </div>
                        <div class="col-3">
                            <small>{{ $pro_deed_master->sub_registry_bang }}</small>
                        </div>
                    </div>


                    <h6 class="d-flex justify-content-center mt-2">দলিলের সার সংক্ষেপ</h6>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="text-left align-top"><small>দলিলের প্রকৃতি</small></th>
                                <th class="text-left align-top"><small>বিভাগ</small></th>
                                <th class="text-left align-top"><small>জেলা</small></th>
                                <th class="text-left align-top"><small>উপজিলা/থানা</small></th>
                                <th class="text-left align-top"><small>ইউনিয়ন</small></th>
                                <th class="text-left align-top"><small>মৌজা</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left align-top"><small>{{ $pro_deed_master->deed_type_bn_name }}</small>
                                </td>
                                <td class="text-left align-top"><small>{{ $pro_deed_master->divisions_bn_name }}</small>
                                </td>
                                <td class="text-left align-top"><small>{{ $pro_deed_master->district_bn_name }}</small></td>
                                <td class="text-left align-top"><small>{{ $pro_deed_master->upazilas_bn_name }}</small></td>
                                <td class="text-left align-top"><small>       @php
                                        $union= DB::table('pro_unions')->where('unions_id',$pro_deed_master->unions_id)->first();
                                                    @endphp
                                                    @isset( $union->unions_bn_name)
                                            {{ $union->unions_bn_name }}
                                            @endisset</small></td>
                                <td class="text-left align-top"><small>{{ $pro_deed_master->moujas_bn_name }}</small></td>

                            </tr>
                            <tr>
                                <td colspan="2" class="text-left align-top"><small>জমির পরিমাপ</small></td>
                                <td colspan="2" class="text-left align-top"><small>জমির ধরন</small></td>
                                <td colspan="2" class="text-left align-top"><small>মূল্য</small></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-left align-top">
                                    <small>{{ $pro_deed_master->land_area }}</small>
                                    <small>{{ $pro_deed_master->land_unit_bn_nane }} </small></td>
                                <td colspan="2" class="text-left align-top">
                                    <small>{{ $pro_deed_master->land_type_bn_name }}</small></td>
                                <td colspan="2" class="text-left align-top">
                                    <small>{{ $pro_deed_master->land_price }}</small></td>
                            </tr>
                        </tbody>

                    </table>

                    @if (isset($pro_land_owner) && $pro_land_owner->count() != 0)
                        <h6 class="d-flex justify-content-center"><small>দলিল গ্রহীতার তথ্য</small></h6>
                        <div class="row table-bordered ml-1 mr-1">
                            @foreach ($pro_land_owner as $key => $value)
                                <div class="col-4">
                                    {{ $key + 1 }} : <small class="align-middle"
                                        style="margin-left: 20px;">{{ $value->owner_name_bang }}</small>

                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (isset($pro_land_seller) && $pro_land_seller->count() != 0)
                        <h6 class="d-flex justify-content-center mt-3"><small>দলিল দাতার তথ্য ও হস্তান্তরিত জমির হারাহারি
                                মালিকানার বিবরণ</small></h6>
                        @foreach ($pro_land_seller as $key => $value)
                            <div class="row table-bordered ml-1 mr-1">
                                <div class="col-2 ">{{ $key + 1 }}</div>
                                <div class="col-4 d-flex justify-content-start">
                                    <small>{{ $value->seller_name_bang }}</small></div>
                                <div class="col-4 d-flex justify-content-end"><small>{{ $value->land_area }}</small> <small
                                        class="align-middle ml-1">
                                        {{ $value->land_unit_bn_nane }}</small> </div>
                            </div>
                        @endforeach
                    @endif

                    @if ($pro_tapsil)
                        <h6 class="text-center d-flex justify-content-center mt-3"><small>সম্পত্তির তফসিল</small></h6>
                        <div class="row">
                            <div class="col-2">
                                <h6 class="text-center d-flex justify-content-start"><small>তফসিল পরিচয় : </small></h6>
                            </div>
                            <div class="col-10">
                                <h6 class="text-center d-flex justify-content-start">
                                    <small>@if(isset($union->unions_bn_name))
                                             {{ 'বিভাগ : ' . $pro_deed_master->divisions_bn_name.' '. ', জেলা : ' . $pro_deed_master->district_bn_name.' '. ', উপজিলা/থানা : ' . $pro_deed_master->upazilas_bn_name.' '. ', ইউনিয়ন : ' . $union->unions_bn_name.' '. ', মৌজা : ' . $pro_deed_master->moujas_bn_name }}
                                    @else
                                    {{ 'বিভাগ : ' . $pro_deed_master->divisions_bn_name.' '. ', জেলা : ' . $pro_deed_master->district_bn_name.' '. ', উপজিলা/থানা : ' . $pro_deed_master->upazilas_bn_name.' '. ', মৌজা : ' . $pro_deed_master->moujas_bn_name }}
                                @endif</small>
                                </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3"><small>জে এল নম্বর :</small></div>
                            <div class="col-3"><small>সি,এস : {{ $pro_tapsil->jl_cs }}</small> </div>
                            <div class="col-3"><small>এস,এ : {{ $pro_tapsil->jl_sa }}</small></div>
                            <div class="col-3"><small>আর,এস : {{ $pro_tapsil->jl_rs }}</small></div>
                        </div>
                        <div class="row">
                            <div class="col-3"><small>খতিয়ান নম্বর :</small></div>
                            <div class="col-3"><small>সি,এস : {{ $pro_tapsil->khatian_cs }}</small></div>
                            <div class="col-3"><small>এস,এ : {{ $pro_tapsil->khatian_sa }}</small></div>
                            <div class="col-3"><small>আর,এস : {{ $pro_tapsil->khatian_rs }}</small></div>
                        </div>
                        <div class="row">
                            <div class="col-3"><small>দাগ নম্বর :</small></div>
                            <div class="col-3"><small>{{ $pro_tapsil->dag_bang }}</small></div>
                        </div>
                    @endif
                    @if (isset($pro_namjari) && $pro_namjari->count() != 0)
                        <div class="row table-bordered mt-2 ml-1 mr-1">
                            @foreach ($pro_namjari as $key => $value)
                                <div class="col-2">
                                    <small>{{ $key + 1 }}:</small>
                                </div>
                                <div class="col-5">
                                    <small>{{ $value->namjari_no }} </small>
                                </div>
                                <div class="col-5">
                                    <small> {{ $value->namjari_details_bang }}</small>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <hr>

                    <a href="{{ route('DeedMasterInfoBnPrint',$pro_deed_master->deed_master_id) }}" class="btn btn-info">Print</a>

                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection
