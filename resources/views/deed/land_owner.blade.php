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
                        <div class="card">
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

                            <form action="{{ route('DeedLandOwnerStore') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                @if (isset($pro_deed_masters))
                                    <input type="hidden" name="deed_master_id"
                                        value="{{ $pro_deed_masters->deed_master_id }}">
                                @endif

                                <div class="row mb-2">
                                    <div class="col-3"></div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <select name="cbo_land_owner_info_id" id="cbo_land_owner_info_id "
                                                class="form-control">
                                                <option value="">--নাম পছন্দ করুন--</option>
                                                @foreach ($pro_land_owner_info as $value)
                                                    <option value="{{ $value->land_owner_info_id }}">
                                                        {{ $value->land_owner_info_id }} | {{ $value->owner_name_eng }} | {{ $value->owner_name_bang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('cbo_land_owner_info_id')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between">
                                            <button type="submit" class="btn bg-primary">Add More</button>
                                            @php
                                                $check = DB::table('pro_land_owner')
                                                    ->where('deed_master_id', '=', $pro_deed_masters->deed_master_id)
                                                    ->first();
                                            @endphp
                                            @if (isset($check))
                                                <a href="{{ route('DeedLandSellerInfo', $pro_deed_masters->deed_master_id) }}"
                                                    class="btn bg-primary">Next</a>
                                            @else
                                                <a href="#" class="btn bg-primary">Next</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-3"></div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
