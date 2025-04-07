@extends('layouts.deed_app')
@section('content')
@php
$imageurl="../docupload/sqgroup/imagedeed/";
@endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Document Upload List</h1>
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
                                    <th class="text-left align-top">Doc File</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($pro_deed_masters as $key => $pro_deed_master)
                                        <tr>
                                            <td class="text-left align-top">{{ $key + 1 }}</td>
                                        <td class="text-left align-top">
                                            {{ $pro_deed_master->deed_sl }}<br>
                                            {{ $pro_deed_master->book_no }}<br>
                                            {{ $pro_deed_master->deed_no }}<br>
                                            {{ $pro_deed_master->deed_date }}
                                        </td>
                                        <td class="text-left align-top">
                                            <small>{{ $pro_deed_master->sub_registry_bang }}</small><br>
                                            <small> {{ $pro_deed_master->deed_type_bn_name }}</small>
                                        </td>
                                        <td class="text-left align-top">
                                            <small>{{ $pro_deed_master->divisions_bn_name }}</small><br>
                                            <small> {{ $pro_deed_master->district_bn_name }}</small><br>
                                            <small> {{ $pro_deed_master->upazilas_bn_name }}</small><br>
                                            <small>
                                                           @php
                                        $union= DB::table('pro_unions')->where('unions_id',$pro_deed_master->unions_id)->first();
                                                    @endphp
                                                    @isset( $union->unions_bn_name)
                                            {{ $union->unions_bn_name }}
                                            @endisset
                                            </small><br>
                                            <small>{{ $pro_deed_master->moujas_bn_name }}</small>
                                        </td>
                                        <td class="text-left align-top">
                                            {{ $pro_deed_master->land_area }} <small>
                                                {{ $pro_deed_master->land_unit_bn_nane }}</small><br>
                                            <small> {{ $pro_deed_master->land_type_bn_name }} </small><br>
                                            {{ $pro_deed_master->land_price }}
                                        </td>
                                        @php
                                            $deed_doc = DB::table('pro_doc_file')
                                                ->where('deed_no', '=', $pro_deed_master->deed_no)
                                                ->where('moujas_id', '=', $pro_deed_master->moujas_id)
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
                                                    @if ($type->doc_info_id == 2 || $type->doc_info_id == 7 || $type->doc_info_id == 8)
                                                    @else
                                                        {{ $type->doc_info_name }} <br>
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
                                                    @if ($type->doc_info_id == 2 || ($type->doc_info_id == 7 || ($type->doc_info_id == 8)))
                                                        {{ $type->doc_info_name }} <br>
                                                    @else
                                                    @endif
                                                </a>
                                            @endforeach

                                        </td>



                                        <td class="text-left align-top">
                                            @php
                                                $entry = DB::table('pro_tapsil')
                                                    ->where('deed_master_id', $pro_deed_master->deed_master_id)
                                                    ->first();
                                                $check_upload=DB::table('pro_deed_master')
                                                ->where('deed_master_id', '=', $pro_deed_master->deed_master_id)
                                                ->where('upload_status', '=','1')
                                                ->first();
                                            @endphp
                                            @if ($entry && $check_upload === null )
                                                <a
                                                    href="{{ route('doc_file', $pro_deed_master->deed_master_id) }}">Upload</a>
                                            @else
                                            @endif
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
