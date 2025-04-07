@extends('layouts.hrm_app')
@section('content')
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Sub Place Of Posting</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <div class="container-fluid">
      @include('flash-message')
    </div>

  <div class="container-fluid">    
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
          <form method="post" action="{{ route('sub_placeofposting_update',$m_sub_placeofposting->placeofposting_sub_id) }}">
            @csrf
            {{-- <div align="center" class=""> --}}

              <div class="row mb-2">
                  <div class="col-6">
                    <select name="cbo_posting" id="cbo_posting" class="form-control">
                      <option value="" >--Select Posting--</option>
                      @foreach ($m_placeofposting as $row_placeofposting)
                          <option value="{{ $row_placeofposting->placeofposting_id }}"{{$row_placeofposting->placeofposting_id == $m_sub_placeofposting->placeofposting_id?"selected":""}}>
                              {{ $row_placeofposting->placeofposting_name }}
                          </option>
                      @endforeach
                    </select>
                    @error('cbo_posting')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-6">
                      <input type="text" name="txt_sub_posting" id="txt_sub_posting" class="form-control" value="{{$m_sub_placeofposting->sub_placeofposting_name}}" placeholder="Sub Posting Name">
                      @error('txt_sub_posting')
                          <div class="text-warning">{{ $message }}</div>
                      @enderror
                  </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  
                </div>
                <div class="col-2">
                  <button type="submit"  class="btn btn-primary btn-block">Update</button>
                </div>
              </div>
            {{-- </div> --}}
          </form>
        </div>
      </div>
    </div>


@endsection
