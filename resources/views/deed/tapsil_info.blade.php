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
            <div class="row">
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
                                    <td>
                                        @isset($pro_deed_masters->unions_bn_name)
                                            {{ $pro_deed_masters->unions_bn_name }}
                                        @endisset
                                    </td>
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
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->owner_name_bang }}</td>
                                            <td>{{ $value->owner_name_bang }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif


                            @if (isset($pro_land_seller))
                                <table id="" class="table table-bordered table-striped table-sm small">
                                    <tr>
                                        <td width="100%" class="text-center">দলিল দাতার তথ্য ও হস্তান্তরিত জমির হারাহারি
                                            মালিকানার
                                            বিবরণ</td>
                                    </tr>
                                </table>
                                <table id="" class="table table-bordered table-striped table-sm small">

                                    @foreach ($pro_land_seller as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->seller_name_bang }}</td>
                                            <td>{{ $value->seller_name_eng }}</td>
                                            <td>{{ $value->land_area }} {{ $value->land_unit_bn_nane }}</td>
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
                                    <td>
                                        @if (isset($pro_deed_masters->unions_bn_name))
                                            {{ 'বিভাগ : ' . $pro_deed_masters->divisions_bn_name . ' ' . ', জেলা : ' . $pro_deed_masters->district_bn_name . ' ' . ', উপজিলা/থানা : ' . $pro_deed_masters->upazilas_bn_name . ' ' . ', ইউনিয়ন : ' . $pro_deed_masters->unions_bn_name . ' ' . ', মৌজা : ' . $pro_deed_masters->moujas_bn_name }}
                                        @else
                                            {{ 'বিভাগ : ' . $pro_deed_masters->divisions_bn_name . ' ' . ', জেলা : ' . $pro_deed_masters->district_bn_name . ' ' . ', উপজিলা/থানা : ' . $pro_deed_masters->upazilas_bn_name . ' ' . ', মৌজা : ' . $pro_deed_masters->moujas_bn_name }}
                                        @endif
                                    </td>
                                </tr>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (isset($pro_tapsil))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('DeedTapsilInfoStore') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                @if (isset($pro_deed_masters))
                                    <input type="hidden" name="deed_master_id"
                                        value="{{ $pro_deed_masters->deed_master_id }}">
                                @endif

                                <div class="row">
                                    <div class="col-2">
                                        <small>জে এল নম্বর:</small>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_jl_cs"
                                                value="{{ $pro_tapsil->jl_cs }}" name="txt_jl_cs" placeholder="JL CS">
                                            @error('txt_jl_cs')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_jl_sa"
                                                value="{{ $pro_tapsil->jl_sa }}" name="txt_jl_sa" placeholder="JL SA">
                                            @error('txt_jl_sa')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_jl_rs"
                                                value="{{ $pro_tapsil->jl_rs }}" name="txt_jl_rs" placeholder="JL RS">
                                            @error('txt_jl_rs')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-2">
                                        <small>খতিয়ান নম্বর:</small>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_khatian_cs"
                                                value="{{ $pro_tapsil->khatian_cs }}" name="txt_khatian_cs"
                                                placeholder="Khatian CS">
                                            @error('txt_khatian_cs')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_khatian_sa"
                                                value="{{ $pro_tapsil->khatian_sa }}" name="txt_khatian_sa"
                                                placeholder="Khatian SA">
                                            @error('txt_khatian_sa')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_khatian_rs"
                                                value="{{ $pro_tapsil->khatian_rs }}" name="txt_khatian_rs"
                                                placeholder="Khatian RS">
                                            @error('txt_khatian_rs')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-2">
                                        <small>দাগ নম্বর:</small>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_dag_bang"
                                                value="{{ $pro_tapsil->dag_bang }}" name="txt_dag_bang"
                                                placeholder="দাগ">
                                            @error('txt_dag_bang')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_dag_eng"
                                                value="{{ $pro_tapsil->dag_eng }}" name="txt_dag_eng" placeholder="Dag">
                                            @error('txt_dag_eng')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-9"></div>
                                    <div class="col-2">
                                        <button type="Submit" class="btn btn-primary btn-block">Update</button>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('DeedNamjari', $pro_deed_masters->deed_master_id) }}" class="btn btn-primary btn-block">skip</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('DeedTapsilInfoStore') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                @if (isset($pro_deed_masters))
                                    <input type="hidden" name="deed_master_id"
                                        value="{{ $pro_deed_masters->deed_master_id }}">
                                @endif

                                <div class="row">
                                    <div class="col-2">
                                        <small>জে এল নম্বর:</small>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_jl_cs"
                                                value="{{ old('txt_jl_cs') }}" name="txt_jl_cs" placeholder="JL CS">
                                            @error('txt_jl_cs')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_jl_sa"
                                                value="{{ old('txt_jl_sa') }}" name="txt_jl_sa" placeholder="JL SA">
                                            @error('txt_jl_sa')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_jl_rs"
                                                value="{{ old('txt_jl_rs') }}" name="txt_jl_rs" placeholder="JL RS">
                                            @error('txt_jl_rs')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-2">
                                        <small>খতিয়ান নম্বর:</small>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_khatian_cs"
                                                value="{{ old('txt_khatian_cs') }}" name="txt_khatian_cs"
                                                placeholder="Khatian CS">
                                            @error('txt_khatian_cs')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_khatian_sa"
                                                value="{{ old('txt_khatian_sa') }}" name="txt_khatian_sa"
                                                placeholder="Khatian SA">
                                            @error('txt_khatian_sa')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_khatian_rs"
                                                value="{{ old('txt_khatian_rs') }}" name="txt_khatian_rs"
                                                placeholder="Khatian RS">
                                            @error('txt_khatian_rs')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-2">
                                        <small>দাগ নম্বর:</small>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_dag_bang"
                                                value="{{ old('txt_dag_bang') }}" name="txt_dag_bang" placeholder="দাগ">
                                            @error('txt_dag_bang')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_dag_eng"
                                                value="{{ old('txt_dag_eng') }}" name="txt_dag_eng" placeholder="Dag">
                                            @error('txt_dag_eng')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn bg-primary float-right">Next</button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
