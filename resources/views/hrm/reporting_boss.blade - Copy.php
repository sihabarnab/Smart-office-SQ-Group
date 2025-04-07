@extends('layouts.hrm_app')
@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Reporting Step</h1>
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
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="" method="Post">
            @csrf
              <div class="row mb-2">
                <div class="col-4">
                  <input type="hidden" class="form-control" id="txt_emp_id" name="txt_emp_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">

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
                <div class="col-4">
                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                        <option value="0">--Employee--</option>
                    </select>
                    @error('cbo_employee_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-1">
                    <input type="text" class="form-control" id="txt_level_step" name="txt_level_step"
                        placeholder="Step" value="{{ old('txt_level_step') }}">
                    @error('txt_level_step')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">

                    <select name="cbo_report_to_id" id="cbo_report_to_id" class="form-control">
                        <option value="00000000">--Report--</option>
                        @foreach ($ci_employee_info as $rpt_emp_info)
                            <option value="{{ $rpt_emp_info->employee_id }}">
                                {{ $rpt_emp_info->employee_id }} | {{ $rpt_emp_info->employee_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cbo_report_to_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  &nbsp;
                </div>
                <div class="col-2">
                  <button type="Submit" class="btn btn-primary btn-block">Add</button>
                </div>
              </div>
            
            </form>
          </div>
      </div>
    </div>
  </div>
</div>

{{-- @include('/hrm/reporting_boss_list') --}}
@section('script')

    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                console.log('ok')
                var cbo_company_id = $(this).val();
                if (cbo_company_id) {

                    $.ajax({
                        url: "{{ url('/get/employee/') }}/" + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_employee_id"]').empty();
                            $('select[name="cbo_employee_id"]').append(
                                '<option value="0">--Employee--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_employee_id"]').append(
                                    '<option value="' + value.employee_id + '">' +
                                    value.employee_id + ' | ' + value.employee_name + '</option>');
                            });
                        },
                    });

                }

            });
        });
    </script>

    <script>
    $(document).ready(function () {
    //change selectboxes to selectize mode to be searchable
       $("select").select2();
    });
    </script>  
    
@endsection

@endsection
