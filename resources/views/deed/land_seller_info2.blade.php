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


                                @if (isset($pro_land_seller2))
                                    <table id="" class="table table-bordered table-striped table-sm small">
                                        <tr>
                                            <td width="100%" class="text-center">দলিল দাতার তথ্য ও হস্তান্তরিত জমির হারাহারি মালিকানার
                                            বিবরণ</td>
                                        </tr>
                                    </table>
                                <table id="" class="table table-bordered table-striped table-sm small">

                                @foreach ($pro_land_seller2 as $key => $value)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $value->seller_name_bang}}</td>
                                    <td>{{ $value->seller_name_eng}}</td>
                                    <td>{{ $value->land_area}}  {{ $value->land_unit_bn_nane }}</td>
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


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('DeedLandSellerInfoStore2') }}" method="Post">
                            @csrf

                            @if (isset($pro_deed_masters))
                                <input type="hidden" name="deed_master_id"
                                    value="{{ $pro_deed_masters->deed_master_id }}">
                            @endif

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="cbo_land_owner_info_id"><small>বিক্রেতা / দাতা-দাত্রিগণের নাম
                                                :</small> </label>
                                        <select name="cbo_land_owner_info_id" id="cbo_land_owner_info_id "
                                            class="form-control">
                                            <option value="">--পছন্দ করুন--</option>
                                            @foreach ($pro_land_seller as $value)
                                                <option value="{{ $value->land_seller_id }}">
                                                    {{ $value->land_seller_id }}|{{ $value->seller_name_eng }}|{{ $value->seller_name_bang }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_land_owner_info_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">

                                    <div class="form-group">
                                        <label for="txt_land_area"> <small>মালিকানার অংশ :</small> </label>
                                        <input type="text" class="form-control" id="txt_land_area"
                                            value="{{ old('txt_land_area') }}" name="txt_land_area">
                                        @error('txt_land_area')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="cbo_land_unit_id"><small></small></label>
                                        <select name="cbo_land_unit_id" id="cbo_land_unit_id "
                                            class="form-control mt-2">
                                            <option value="">--পছন্দ করুন--</option>
                                            @foreach ($pro_land_unit as $value)
                                                <option value="{{ $value->land_unit_id }}">
                                                    {{ $value->land_unit_id }}|{{ $value->land_unit_nane }}|{{ $value->land_unit_bn_nane }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_land_unit_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="Submit" class="btn btn-primary float-left">Add More</button>
                            @php
                                $check = DB::table('pro_land_seller')
                                    ->where('deed_master_id', $pro_deed_masters->deed_master_id)
                                    ->where('land_area', '!=', '')
                                    ->first();
                            @endphp

                            @if(isset($check))
                            <a href="{{ route('DeedTapsilInfo', $pro_deed_masters->deed_master_id) }}" class="btn btn-primary float-right">Next</a>
                            @else
                            <a href="#" class="btn btn-primary float-right">Next</a>
                            @endif

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
