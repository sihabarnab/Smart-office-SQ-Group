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
@if(isset($mm_employee_info))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form action="{{ route('HrmReportingBosUpdate', $m_level_step->level_step_id) }}" method="Post">
            @csrf
              <div class="row mb-2">
                <div class="col-3">
                  <input type="hidden" class="form-control" id="cbo_company_id" name="cbo_company_id"
                      readonly value="{{ $mm_employee_info->company_id }}">

                  <input type="text" class="form-control" id="txt_company_name" name="txt_company_name"
                      readonly value="{{ $mm_employee_info->company_name }}">
                </div>
                <div class="col-4">
                  <input type="hidden" class="form-control" id="cbo_employee_id" name="cbo_employee_id"
                      readonly value="{{ $mm_employee_info->employee_id }}">

                  <input type="text" class="form-control" id="txt_employee_name" name="txt_employee_name"
                      readonly value="{{ $mm_employee_info->employee_id }} | {{ $mm_employee_info->employee_name }}">
                </div>
                <div class="col-1">
                  <input type="text" class="form-control" name="txt_level_step" id="txt_level_step" value="{{ $m_level_step->level_step }}"  placeholder="Step">
                  @error('txt_level_step')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-4">
                    <select name="cbo_report_to_id" id="cbo_report_to_id" class="form-control">
                        <option value="00000000">Select Report</option>
                        @foreach ($ci_employee_info as $row_employee_info)
                            <option value="{{ $row_employee_info->employee_id }}"
                                {{ $m_level_step->report_to_id == $row_employee_info->employee_id ? 'selected' : '' }}>
                                {{ $row_employee_info->employee_id }} |
                                {{ $row_employee_info->employee_name }}
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
                  <button type="submit" class="btn btn-primary btn-block">Update</button>
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
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="{{ route('HrmReportingBossStore') }}" method="Post">
            @csrf
              <div class="row mb-2">
                <div class="col-3">
                  <input type="hidden" class="form-control" id="cbo_company_id" name="cbo_company_id"
                      readonly value="{{ $m_employee_info->company_id }}">

                  <input type="text" class="form-control" id="txt_company_name" name="txt_company_name"
                      readonly value="{{ $m_employee_info->company_name }}">
                </div>
                <div class="col-4">
                  <input type="hidden" class="form-control" id="cbo_employee_id" name="cbo_employee_id"
                      readonly value="{{ $m_employee_info->employee_id }}">

                  <input type="text" class="form-control" id="txt_employee_name" name="txt_employee_name"
                      readonly value="{{ $m_employee_info->employee_id }} | {{ $m_employee_info->employee_name }}">
                </div>
                <div class="col-1">
                    <input type="text" class="form-control" id="txt_level_step" name="txt_level_step"
                        placeholder="Step" value="{{ old('txt_level_step') }}">
                    @error('txt_level_step')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-4">
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
@include('/hrm/reporting_boss_list')
@endif
@section('script')
<script>
  $(document).ready(function () {
  //change selectboxes to selectize mode to be searchable
     $("select").select2();
  });
</script>  
    
@endsection

@endsection
