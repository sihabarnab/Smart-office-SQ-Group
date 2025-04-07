@extends('layouts.hrm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1 class="m-0">Movement</h1>
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
                <form action="{{ route('hrmbackrptovementList') }}" method="post">
                    @csrf

                    <div class="row mb-2">
                        <div class="col-3">
                            <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                <option value="">--Select Company--</option>
                                @foreach ($user_company as $company)
                                    <option value="{{ $company->company_id }}"
                                        {{ $company->company_id == old('cbo_company_id') ? 'selected' : '' }}>
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
                                <option value="">--Select Posting--</option>
                              
                            </select>
                            @error('cbo_posting')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-3">
                            <select name="cbo_sub_posting" id="cbo_sub_posting" class="form-control">
                                <option value="">--Select Sub Posting--</option>
                            </select>
                            @error('cbo_sub_posting')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-3">
                            <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                <option value="">--Select Employee--</option>
                            </select>
                            @error('cbo_employee_id')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-3">
                            <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                placeholder="From Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                                onblur="if(this.value==''){this.type='text'}">
                            <div id='err_txt_form_date'>
                            </div>
                            @error('txt_from_date')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                placeholder="To Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                onblur="if(this.value==''){this.type='text'}">
                            @error('txt_to_date')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-4">

                        </div>

                        <div class="col-2">
                            <button type="submit" class="btn btn-primary btn-block mt-2">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getPosting();
            $('select[name="cbo_company_id"]').on('change', function() {
                getPosting();
                getEmployee();
            });
            $('select[name="cbo_posting"]').on('change', function() {
                getSubPosting();
                getEmployee();
            });
            $('select[name="cbo_sub_posting"]').on('change', function() {
                getEmployee();
                employeeDivShow();
            });
        });

        //Company to Posting 
        function getPosting() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get/hrm/placeofposting/') }}/" + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_posting"]').empty();
                        $('select[name="cbo_posting"]').append(
                            '<option value="">--Select Posting--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_posting"]').append(
                                '<option value="' + value.placeofposting_id + '">' + value
                                .placeofposting_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_posting"]').empty();
            }
        }

        // posting to sub posting 
        function getSubPosting() {
            var cbo_posting = $('#cbo_posting').val();
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_posting && cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get/hrm/placeofsubposting/') }}/" + cbo_posting + '/' +
                        cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                      if(data.length > 0){
                         employeeDivHide();
                      }
                        $('select[name="cbo_sub_posting"]').empty();
                        $('select[name="cbo_sub_posting"]').append(
                            '<option value="">--Select Sub Posting--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_sub_posting"]').append(
                                '<option value="' + value.placeofposting_sub_id + '">' + value
                                .sub_placeofposting_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_sub_posting"]').empty();
            }
        }


        // Get Employee 
        function getEmployee() {
            var cbo_posting = $('#cbo_posting').val();
            var cbo_company_id = $("#cbo_company_id").val();
            var cbo_sub_posting = $("#cbo_sub_posting").val();
            if(cbo_sub_posting){
             var sub_posting = cbo_sub_posting;
            }else{
              var sub_posting = 0;
            }
            if (cbo_company_id && cbo_posting) {
                $.ajax({
                    url: "{{ url('/get/hrm/employee/') }}/" + cbo_posting + '/' +
                    sub_posting+'/'+cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                      console.log(data);
                        var d = $('select[name="cbo_employee_id"]').empty();
                        $('select[name="cbo_employee_id"]').append(
                            '<option value="0">--Employee--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_employee_id"]').append(
                                '<option value="' + value.employee_id + '">' +
                                value.employee_id + ' | ' + value
                                .employee_name + '</option>');
                        });
                    },
                });

            }
        }

        function employeeDivHide()
        {
            $('#cbo_employee_id').attr('disabled', 'disabled');
        }
        function employeeDivShow()
        {
            $('#cbo_employee_id').removeAttr('disabled');
        }
    </script>
@endsection
