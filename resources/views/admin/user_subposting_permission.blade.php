@extends('layouts.admin_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Sub-Posting Permission.</h1>
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
                        <form action="{{ route('user_subposting_permission_store') }}" method="Post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                        <option value="0">--Company--</option>
                                        @foreach ($companies as $company)
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
                                    <select name="cbo_placeofposting_id" id="cbo_placeofposting_id" class="form-control">
                                        <option value="">--Select Posting--</option>
                                        @foreach ($m_placeofposting as $row)
                                        <option value="{{ $row->placeofposting_id }}">
                                            {{ $row->placeofposting_name }}
                                        </option>
                                    @endforeach
                                    </select>
                                    @error('cbo_placeofposting_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <select name="cbo_placeofposting_sub_id" id="cbo_placeofposting_sub_id"
                                        class="form-control">
                                        <option value="">--Select Sub Posting--</option>
                                    </select>
                                    @error('cbo_placeofposting_sub_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-3 ">
                                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                        <option value="">--Employee--</option>
                                    </select>
                                    @error('cbo_employee_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-10"></div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary btn-block mt-2">Submit</button>
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
            $('select[name="cbo_company_id"]').on('change', function() {
                getEmployee();
            });
            $('select[name="cbo_placeofposting_id"]').on('change', function() {
                getSubPosting();
                getEmployee();
            });
            $('select[name="cbo_placeofposting_sub_id"]').on('change', function() {
                getEmployee();
                employeeDivShow();
            });
        });


        // posting to sub posting 
        function getSubPosting() {
            var cbo_placeofposting_id = $('#cbo_placeofposting_id').val();
            var cbo_placeofposting_sub_id = $('#cbo_placeofposting_sub_id').val();
            if(cbo_placeofposting_sub_id<=0){
                employeeDivShow();
            }
            if (cbo_placeofposting_id) {
                $.ajax({
                    url: "{{ url('/get/admin/placeofsubposting/') }}/" + cbo_placeofposting_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                      if(data.length > 0){
                         employeeDivHide();
                      }
                        $('select[name="cbo_placeofposting_sub_id"]').empty();
                        $('select[name="cbo_placeofposting_sub_id"]').append(
                            '<option value="">--Select Sub Posting--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_placeofposting_sub_id"]').append(
                                '<option value="' + value.placeofposting_sub_id + '">' + value
                                .sub_placeofposting_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_placeofposting_sub_id"]').empty();
            }
        }


        // Get Employee 
        function getEmployee() {
            var cbo_placeofposting_id = $('#cbo_placeofposting_id').val();
            var cbo_company_id = $("#cbo_company_id").val();
            var cbo_placeofposting_sub_id = $("#cbo_placeofposting_sub_id").val();

            console.log(cbo_placeofposting_sub_id);
            console.log(cbo_placeofposting_id);
            if(cbo_placeofposting_sub_id){
             var sub_posting = cbo_placeofposting_sub_id;
            }else{
              var sub_posting = 0;
            }
            if (cbo_company_id && cbo_placeofposting_id) {
                $.ajax({
                    url: "{{ url('/get/admin/employee/') }}/" + cbo_placeofposting_id + '/' +
                    sub_posting+'/'+cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                       $('select[name="cbo_employee_id"]').empty();
                        $('select[name="cbo_employee_id"]').append(
                            '<option value="">--Employee--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_employee_id"]').append(
                                '<option value="' + value.employee_id + '">' +
                                value.employee_id + ' | ' + value
                                .employee_name + '</option>');
                        });
                    },
                });

            }else{
                $('select[name="cbo_employee_id"]').empty(); 
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



<script>
    $(document).ready(function () {
    //change selectboxes to selectize mode to be searchable
    $("select").select2();
    });
</script>  


@endsection
