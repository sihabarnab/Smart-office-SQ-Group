@extends('layouts.hrm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Date Wise Punch Time</h1>
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
                        <div align="left" class=""></div>
                        <form action="{{ route('hrmbackdaily_punch_report_02') }}" method="GET">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                        <option value="0">--Company--</option>
                                        @foreach ($user_company as $company)
                                            <option value="{{ $company->company_id }}">
                                                {{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <select name="cbo_posting" id="cbo_posting" class="form-control">
                                        <option value="">--Posting--</option>
                                          @foreach ($m_user_posting as $row_user_posting)
                                              <option value="{{ $row_user_posting->placeofposting_id }}" {{ $row_user_posting->placeofposting_id == old('cbo_posting')? 'selected':'' }}>
                                                  {{ $row_user_posting->placeofposting_name }}
                                              </option>
                                          @endforeach
                                    </select>
                                    @error('cbo_posting')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <select name="cbo_sub_posting" id="cbo_sub_posting" class="form-control">
                                      <option value="0">--Sub Posting--</option>
                                    </select>
                                    @error('cbo_sub_posting')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_date" name="txt_date"
                                        placeholder="From Date" value="{{ old('txt_date') }}" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    <div id='err_txt_form_date'>
                                    </div>
                                    @error('txt_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    &nbsp;
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_posting"]').on('change', function() {
                getSubPosting();

            });
        });

        // posting to sub posting 
        function getSubPosting() {
            var cbo_posting = $('#cbo_posting').val();
            if (cbo_posting) {
                $.ajax({
                    url: "{{ url('/get/sub_posting/') }}/" + cbo_posting,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_sub_posting"]').empty();
                        if(data){
                          $('select[name="cbo_sub_posting"]').append(
                              '<option value="0">--Select Sub-Posting --</option>');
                          $.each(data, function(key, value) {
                              $('select[name="cbo_sub_posting"]').append(
                                  '<option value="' + value.placeofposting_sub_id + '">' +
                                  value.sub_placeofposting_name + '</option>');
                          });
                        } // if(data){
                    },
                });

           }else{
             $('select[name="cbo_sub_posting"]').empty();
           } 
        }
    </script>
@endsection
