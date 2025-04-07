@extends('layouts.deed_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Unions info<br>ইউনিয়ন তথ্য</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($pro_unions_edit))
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-5">{{ 'Edit' }}</h3>
                        <form action="{{ route('DeedMoujaInfoUpdate',$pro_moujas_edit->moujas_id) }}" method="Post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-2">
                                    <select name="cbo_division_id" id="cbo_division_id" class="form-control">
                                        <option value="">--বিভাগ--</option>
                                        @foreach($pro_divisions as $pro_division)
                                        <option value="{{$pro_division->divisions_id}}"  {{$pro_division->divisions_id == $pro_moujas_edit->divisions_id? 'selected':''}}>
                                            {{$pro_division->divisions_id}} | {{$pro_division->divisions_name}} | {{$pro_division->divisions_bn_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_division_id')
                                     <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <select name="cbo_district_id" id="cbo_district_id" class="form-control">
                                        <option value="">--জেলা--</option>
                                    </select>
                                    @error('cbo_district_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <select name="cbo_upazila_id" id="cbo_upazila_id" class="form-control">
                                        <option value="">--উপজিলা/থানা--</option>
                                    </select>
                                    @error('cbo_upazila_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_moujas_bn_name" name="txt_moujas_bn_name" placeholder="মৌজা" value="{{ $pro_moujas_edit->moujas_bn_name }}">
                                      @error('txt_moujas_bn_name')
                                        <div class="text-warning">{{ $message }}</div>
                                      @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_moujas_name" name="txt_moujas_name" placeholder="Mouja" value="{{ $pro_moujas_edit->moujas_name }}">
                                      @error('txt_moujas_name')
                                        <div class="text-warning">{{ $message }}</div>
                                      @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" class="btn btn-primary btn-block">Update</button>
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
                        <h3 class="mb-5">Add</h3>

                        <form action="{{ route('DeedUnionInfoStore') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-2">
                                    <select name="cbo_division_id" id="cbo_division_id" class="form-control">
                                        <option value="">--বিভাগ--</option>
                                        @foreach ($pro_divisions as $pro_division)
                                            <option value="{{ $pro_division->divisions_id }}">
                                                {{ $pro_division->divisions_id }} | {{ $pro_division->divisions_name }} | {{ $pro_division->divisions_bn_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_division_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <select name="cbo_district_id" id="cbo_district_id" class="form-control">
                                        <option value="">--জেলা--</option>
                                    </select>
                                    @error('cbo_district_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <select name="cbo_upazila_id" id="cbo_upazila_id" class="form-control">
                                        <option value="">--উপজিলা/থানা--</option>
                                    </select>
                                    @error('cbo_upazila_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_unions_bn_name"
                                        value="{{ old('txt_unions_bn_name') }}" name="txt_unions_bn_name"
                                        placeholder="ইউনিয়ন">
                                    @error('txt_unions_bn_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_unions_name"
                                        value="{{ old('txt_unions_name') }}" name="txt_unions_name"
                                        placeholder="Union">
                                    @error('txt_unions_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Union info list --}}
    @include('/deed/union_info_list')
    @endif

@section('script')

@if(isset($pro_moujas_edit))
<script type="text/javascript">
    $('select[name="cbo_district_id"]').append('<option selected value="'+{{$pro_moujas_edit->districts_id}}+'" >'+"{{ $pro_moujas_edit->districts_id.' | '.$pro_moujas_edit->district_name.' | '.$pro_moujas_edit->district_bn_name}}"+'</option>');
    $('select[name="cbo_upazila_id"]').append('<option selected value="'+{{$pro_moujas_edit->upazilas_id}}+'" >'+"{{ $pro_moujas_edit->upazilas_id.' | '.$pro_moujas_edit->upazilas_name.' | '.$pro_moujas_edit->upazilas_bn_name}}"+'</option>');
</script>
@endif

{{-- //divison to District Use Ajax--}}
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="cbo_division_id"]').on('change', function() {
            console.log('ok')
            var cbo_division_id = $(this).val();
            if (cbo_division_id) {

                $.ajax({
                    url: "{{ url('/get/district/') }}/" + cbo_division_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var d = $('select[name="cbo_district_id"]').empty();
                        $('select[name="cbo_district_id"]').append(
                            '<option value="">--জেলা--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_district_id"]').append(
                                '<option value="' + value.districts_id + '">' +
                                value.districts_id + ' | ' + value.district_name +
                                ' | ' + value.district_bn_name + '</option>');
                        });
                    },
                });

            } else {
                alert('danger');
            }

        });
    });
</script>

{{-- //District to upazilas use Ajax--}}
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="cbo_district_id"]').on('change', function() {
            console.log('ok')
            var cbo_district_id = $(this).val();
            if (cbo_district_id) {

                $.ajax({
                    url: "{{ url('/get/upazilas/') }}/" + cbo_district_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var d = $('select[name="cbo_upazila_id"]').empty();
                        $('select[name="cbo_upazila_id"]').append(
                            '<option value="">--উপজিলা/থানা--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_upazila_id"]').append(
                                '<option value="' + value.upazilas_id + '">' +
                                value.upazilas_id + ' | ' + value.upazilas_name +
                                ' | ' + value.upazilas_bn_name + '</option>');
                        });
                    },
                });

            } else {
                alert('danger');
            }

        });
    });
</script>
@endsection

@endsection
