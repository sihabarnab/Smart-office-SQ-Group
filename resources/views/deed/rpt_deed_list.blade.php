@extends('layouts.deed_app')
@section('content')
@php
$imageurl="../docupload/sqgroup/imagedeed/";
@endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Deed Information</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm small">
                            <thead>
                                <tr>
                                    <th class="text-left align-top">SL</th>
                                    <th class="text-left align-top">ক্রমিক নং<br>বহি নং<br>দলিল নং<br>তারিখ</th>
                                    <th class="text-left align-top">সাব-রেজিস্ট্রি<br>দলিলের প্রকৃতি</th>
                                    <th class="text-left align-top">বিভাগ<br>জেলা<br>উপজিলা/থানা<br>ইউনিয়ন<br>মৌজা
                                        নাম</th>
                                    <th class="text-left align-top">জমির পরিমাপ<br>জমিরধরন<br>মূল্য</th>
                                    <th class="text-left align-top">দলিল<br>খতিয়ান সি,এস<br>খতিয়ান এস,এ<br>খতিয়ান
                                        আর,এস</th>
                                    <th class="text-left align-top">নামজারী<br>DCR<br>খাজনা</th>
                                    <th class="text-left align-top">সারসংক্ষেপ</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($rpt_deed_master as $key => $rpt_deed_master)
                                        <tr>
                                            <td class="text-left align-top">{{ $key + 1 }}</td>
                                            <td class="text-left align-top">
                                                {{ $rpt_deed_master->deed_sl }}<br>
                                                {{ $rpt_deed_master->book_no }}<br>
                                                {{ $rpt_deed_master->deed_no }}<br>
                                                {{ $rpt_deed_master->deed_date }}
                                            </td>
                                            <td class="text-left align-top">
                                                <small>{{ $rpt_deed_master->sub_registry_bang }}</small><br>
                                                <small> {{ $rpt_deed_master->deed_type_bn_name }}</small>
                                            </td>
                                            <td class="text-left align-top">
                                                <small>{{ $rpt_deed_master->divisions_bn_name }}</small><br>
                                                <small> {{ $rpt_deed_master->district_bn_name }}</small><br>
                                                <small> {{ $rpt_deed_master->upazilas_bn_name }}</small><br>
                                                <small>{{ $rpt_deed_master->unions_bn_name }}</small><br>
                                                <small>{{ $rpt_deed_master->moujas_bn_name }}</small>
                                            </td>
                                            <td class="text-left align-top">
                                                {{ $rpt_deed_master->land_area }} <small>
                                                    {{ $rpt_deed_master->land_unit_bn_nane }}</small><br>
                                                <small> {{ $rpt_deed_master->land_type_bn_name }} </small><br>
                                                {{ $rpt_deed_master->land_price }}
                                            </td>

                                        @php
                                            $deed_doc = DB::table('pro_doc_file')
                                                ->where('deed_no', '=', $rpt_deed_master->deed_no)
                                                ->where('moujas_id', '=', $rpt_deed_master->moujas_id)
                                                ->get();
                                        @endphp

                                        <td class="text-left align-top">
                                            @foreach ($deed_doc as $value)
                                                @php
                                                    $type = DB::table('pro_doc_info')
                                                        ->where('doc_info_id', '=', $value->doc_info_id)
                                                        ->first();
                                                @endphp
                                                <a target="_blank" href="{{ url("$imageurl$value->file_name") }}">
                                                    @if ($type->doc_info_id == 1 || ($type->doc_info_id == 3 || $type->doc_info_id == 4 || $type->doc_info_id == 5 || $type->doc_info_id == 6))
                                                        {{ $type->doc_info_name }}<br>
                                                    @else
                                                    @endif
                                                </a>
                                            @endforeach
                                        </td>

                                        <td class="text-left align-top">
                                            @foreach ($deed_doc as $value)
                                                @php
                                                    $type = DB::table('pro_doc_info')
                                                        ->where('doc_info_id', '=', $value->doc_info_id)
                                                        ->first();
                                                @endphp
                                                <a target="_blank" href="{{ url("$imageurl$value->file_name") }}">
                                                    @if ($type->doc_info_id == 2 || ($type->doc_info_id == 7 || $type->doc_info_id == 8))
                                                        {{ $type->doc_info_name }}<br>
                                                    @else
                                                    @endif
                                                </a>
                                            @endforeach

                                        </td>

                                        <td class="text-left align-top">
                                            <a
                                                href="{{ route('DeedMasterInfoEnglish', $rpt_deed_master->deed_master_id) }}"><small>English</small></a><br>
                                            <a
                                                href="{{ route('DeedMasterInfoBangla', $rpt_deed_master->deed_master_id) }}"><small>বাংলা</small></a><br>
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




@endsection
