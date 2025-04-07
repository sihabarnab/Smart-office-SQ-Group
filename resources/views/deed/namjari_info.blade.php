@extends('layouts.deed_app')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Deed Information | দলিলের তথ্য</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if ($pro_deed_masters)
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body">
                            <table id="" class="table table-bordered table-striped table-sm small">
                                <tr>
                                    <td width="10%">ক্রমিক নং :</td>
                                    <td width="15%">{{ $pro_deed_masters->deed_sl }}</td>
                                    <td width="10%">বহি নং :</td>
                                    <td width="10%">{{ $pro_deed_masters->book_no }}</td>
                                    <td width="10%">দলিল নং :</td>
                                    <td width="10%">{{ $pro_deed_masters->deed_no }}</td>
                                    <td width="20%">তারিখ :</td>
                                    <td width="15%">{{ $pro_deed_masters->deed_date }}</td>
                                </tr>
                                <tr>
                                    <td width="" colspan="2">সাব-রেজিস্ট্রি :</td>
                                    <td width="" colspan="3">{{ $pro_deed_masters->sub_registry_bang }}</td>
                                    <td colspan="3">{{ $pro_deed_masters->sub_registry_eng }}</td>
                                </tr>
                                <tr>
                                    <td width="100%" colspan="8" class="text-center">দলিলের সার সংক্ষেপ</td>
                                </tr>
                                </table>
                                <table id="" class="table table-bordered table-striped table-sm small">
                                <tr>
                                    <td width="18%">দলিলের প্রকৃতি</td>
                                    <td width="17%">বিভাগ</td>
                                    <td width="17%">জেলা</td>
                                    <td width="18%">উপজিলা/থানা</td>
                                    <td width="15%">ইউনিয়ন</td>
                                    <td width="15%">মৌজা</td>
                                </tr>
                                <tr>
                                    <td>{{ $pro_deed_masters->deed_type_bn_name }}</td>
                                    <td>{{ $pro_deed_masters->divisions_bn_name }}</td>
                                    <td>{{ $pro_deed_masters->district_bn_name }}</td>
                                    <td>{{ $pro_deed_masters->upazilas_bn_name }}</td>
                                    <td>@isset( $pro_deed_masters->unions_bn_name)
                                            {{ $pro_deed_masters->unions_bn_name }}
                                            @endisset</td>
                                    <td>{{ $pro_deed_masters->moujas_bn_name }}</td>
                                </tr>
                                <tr>
                                    <td>জমির পরিমাপ : </td>
                                    <td>{{ $pro_deed_masters->land_area }} {{ $pro_deed_masters->land_unit_bn_nane }}</td>
                                    <td>জমির ধরন : </td>
                                    <td>{{ $pro_deed_masters->land_type_bn_name }}</td>
                                    <td>মূল্য : </td>
                                    <td>{{ $pro_deed_masters->land_price }}</td>
                                </tr>

                            </table>
                            <table id="" class="table table-bordered table-striped table-sm small">
                                <tr>
                                    <td width="100%" class="text-center">দলিল গ্রহীতার তথ্য</td>
                                </tr>
                            </table>
                            @if (isset($pro_land_owner))
                            <table id="" class="table table-bordered table-striped table-sm small">
                            @foreach ($pro_land_owner as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->owner_name_bang}}</td>
                                <td>{{ $value->owner_name_bang}}</td>
                            </tr>
                            @endforeach
                            </table>
                            @endif


                            @if (isset($pro_land_seller))
                                <table id="" class="table table-bordered table-striped table-sm small">
                                    <tr>
                                        <td width="100%" class="text-center">দলিল দাতার তথ্য ও হস্তান্তরিত জমির হারাহারি মালিকানার
                                        বিবরণ</td>
                                    </tr>
                                </table>
                            <table id="" class="table table-bordered table-striped table-sm small">

                            @foreach ($pro_land_seller as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->seller_name_bang}}</td>
                                <td>{{ $value->seller_name_eng}}</td>
                                <td>{{ $value->land_area}}  {{ $value->land_unit_bn_nane }}</td>
                            </tr>
                            @endforeach
                            </table>
                            @endif


                                <table id="" class="table table-bordered table-striped table-sm small">
                                    <tr>
                                        <td width="100%" class="text-center">সম্পত্তির তফসিল পরিচয়</td>
                                    </tr>
                                </table>
                            <table id="" class="table table-bordered table-striped table-sm small">

                            <tr>
                                <td>@if(isset($pro_deed_masters->unions_bn_name))
                                             {{ 'বিভাগ : ' . $pro_deed_masters->divisions_bn_name.' '. ', জেলা : ' . $pro_deed_masters->district_bn_name.' '. ', উপজিলা/থানা : ' . $pro_deed_masters->upazilas_bn_name.' '. ', ইউনিয়ন : ' . $pro_deed_masters->unions_bn_name.' '. ', মৌজা : ' . $pro_deed_masters->moujas_bn_name }}
                                    @else
                                    {{ 'বিভাগ : ' . $pro_deed_masters->divisions_bn_name.' '. ', জেলা : ' . $pro_deed_masters->district_bn_name.' '. ', উপজিলা/থানা : ' . $pro_deed_masters->upazilas_bn_name.' '. ', মৌজা : ' . $pro_deed_masters->moujas_bn_name }}
                                @endif</td>
                            </tr>
                            </table>
                            @if ($pro_tapsil)
                            <table id="" class="table table-bordered table-striped table-sm small">
                            <tr>
                                <td>জে এল নম্বর:</td>
                                <td>সি,এস : {{ $pro_tapsil->jl_cs }}</td>
                                <td>এস,এ : {{ $pro_tapsil->jl_sa }}</td>
                                <td>আর,এস: {{ $pro_tapsil->jl_rs }}</td>
                            </tr>
                            <tr>
                                <td>খতিয়ান নম্বর:</td>
                                <td>সি,এস : {{ $pro_tapsil->khatian_cs }}</td>
                                <td>এস,এ : {{ $pro_tapsil->khatian_sa }}</td>
                                <td>আর,এস: {{ $pro_tapsil->khatian_rs }}</td>
                            </tr>
                            <tr>
                                <td>দাগ নম্বর :</td>
                                <td colspan="3">{{ $pro_tapsil->dag_bang }}</td>
                            </tr>
                            </table>
                            @endif

                            @if (isset($pro_namjari))
                            <table id="" class="table table-bordered table-striped table-sm small">
                            @foreach ($pro_namjari as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->namjari_details_bang }}</td>
                            </tr>
                            @endforeach
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <section class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('DeedNamjariStore') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                @if (isset($pro_deed_masters))
                                    <input type="hidden" name="deed_master_id"
                                        value="{{ $pro_deed_masters->deed_master_id }}">
                                @endif

                                <div class="form-group">
                                    <input type="text" class="form-control" id="txt_"
                                        value="{{ old('txt_namjari_no') }}" name="txt_namjari_no" placeholder="Namjari No">
                                    @error('txt_namjari_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" id="txt_namjari_details_bang"
                                        value="{{ old('txt_namjari_details_bang') }}" name="txt_namjari_details_bang"
                                        placeholder="নামজারী">
                                    @error('txt_namjari_details_bang')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="txt_namjari_details_eng"
                                        value="{{ old('txt_namjari_details_eng') }}" name="txt_namjari_details_eng"
                                        placeholder="Namjari">
                                    @error('txt_namjari_details_eng')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="Submit" class="btn btn-primary float-left">Add More</button>
                                <a href="{{ route('deed_master_info') }}" class="btn btn-primary float-right">Final</a>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
