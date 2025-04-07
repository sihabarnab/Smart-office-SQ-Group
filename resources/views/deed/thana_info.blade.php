@extends('layouts.deed_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thana info<br>থানার তথ্য</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($pro_thana_info_edit))
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-5">{{ 'Edit' }}</h3>
                        <form action="{{ route('DeedUpzilaUpdate',$pro_thana_info_edit->upazilas_id) }}" method="Post">
                            @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_division_id" id="cbo_division_id" class="form-control">
                                    <option value="">--বিভাগ--</option>
                                    @foreach($pro_divisions as $pro_division)
                                    <option value="{{$pro_division->divisions_id}}"  {{$pro_division->divisions_id == $pro_thana_info_edit->divisions_id? 'selected':''}}>
                                        {{$pro_division->divisions_id}}|{{$pro_division->divisions_name}}|{{$pro_division->divisions_bn_name}}</option>
                                    @endforeach
                                </select>
                                @error('cbo_division_id')
                                 <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select name="cbo_district_id" id="cbo_district_id" class="form-control">
                                    <option value="">--জেলা--</option>
                                </select>
                                @error('cbo_district_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control"mid="txt_upazilas_bn_name" name="txt_upazilas_bn_name" placeholder="থানা / উপজিলা" value="{{ $pro_thana_info_edit->upazilas_bn_name }}">
                                  @error('txt_upazilas_bn_name')
                                    <div class="text-warning">{{ $message }}</div>
                                  @enderror
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control"mid="txt_upazilas_name" name="txt_upazilas_name" placeholder="Thana / Upazila" value="{{ $pro_thana_info_edit->upazilas_name }}">
                                  @error('txt_upazilas_name')
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
                        <h3 class="mb-5">{{ 'Add' }}</h3>

                        <form action="{{ route('DeedThanaInfoStore') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select name="cbo_division_id" id="cbo_division_id" class="form-control">
                                        <option value="">--বিভাগ--</option>
                                        @foreach($pro_divisions as $pro_division)
                                        <option value="{{$pro_division->divisions_id}}">
                                            {{$pro_division->divisions_id}} | {{$pro_division->divisions_name}} | {{$pro_division->divisions_bn_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_division_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select name="cbo_district_id" id="cbo_district_id" class="form-control">
                                        <option value="">--জেলা--</option>
                                    </select>
                                    @error('cbo_district_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_upazilas_bn_name"
                                        value="{{ old('txt_upazilas_bn_name') }}" name="txt_upazilas_bn_name" placeholder="থানা / উপজিলা">
                                    @error('txt_upazilas_bn_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_upazilas_name"
                                        value="{{ old('txt_upazilas_name') }}" name="txt_upazilas_name" placeholder="Thana / Upazila">
                                    @error('txt_upazilas_name')
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

{{-- Thana info list --}}
@include('/deed/thana_info_list')
@endif

@section('script')

@if(isset($pro_thana_info_edit))
<script type="text/javascript">
    $('select[name="cbo_district_id"]').append('<option selected value="'+{{$pro_thana_info_edit->districts_id}}+'" >'+"{{ $pro_thana_info_edit->districts_id.'|'.$pro_thana_info_edit->district_name.'|'.$pro_thana_info_edit->district_bn_name}}"+'</option>');
</script>
@endif

{{-- @section('script') --}}
  {{-- //Division to District --}}
<script type="text/javascript">
    $(document).ready(function(){
   $('select[name="cbo_division_id"]').on('change',function(){
    console.log('ok')
        var cbo_division_id = $(this).val();
        if (cbo_division_id) {

          $.ajax({
            url: "{{ url('/get/district/') }}/"+ cbo_division_id,
            type:"GET",
            dataType:"json",
            success:function(data) {
            var d =$('select[name="cbo_district_id"]').empty();
            $('select[name="cbo_district_id"]').append('<option value="">--জেলা--</option>');
            $.each(data, function(key, value){
            $('select[name="cbo_district_id"]').append('<option value="'+ value.districts_id + '">' +value.districts_id +' | '+ value.district_name+' | '+ value.district_bn_name + '</option>');
            });
            },
          });

        }else{
          alert('danger');
        }

          });
    });
</script>
@endsection

@endsection
