@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Movement Approval for Others</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_late_inform_master))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""></div>
            <form action="{{ route('move_app_for_approval_other_update',$m_late_inform_master->late_inform_master_id) }}" method="Post">
            @csrf
            @php
              $txt_emp_id=Auth::user()->emp_id;
              $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$m_late_inform_master->employee_id)->first();

              $txt_company_id=$ci_employee_info->company_id;
              $txt_employee_name=$ci_employee_info->employee_name;
              $txt_desig_id=$ci_employee_info->desig_id;

              $ci_company=DB::table('pro_company')->Where('company_id',$txt_company_id)->first();
              $txt_company=$ci_company->company_name;

              $ci_desig=DB::table('pro_desig')->Where('desig_id',$txt_desig_id)->first();
              $txt_desig=$ci_desig->desig_name;

              $ci_late_type=DB::table('pro_late_type')->Where('late_type_id',$m_late_inform_master->late_type_id)->first();
              $txt_late_type=$ci_late_type->late_type;

            @endphp

            <div class="row mb-2">
              <div class="col-2">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" readonly value="{{ Auth::user()->emp_id }}">
                <input type="text" class="form-control" id="txt_employee_id" name="txt_employee_id" readonly value="{{ $m_late_inform_master->employee_id }}">
              </div>
              <div class="col-4">
                <input type="hidden" class="form-control" id="txt_late_inform_master" name="txt_late_inform_master" readonly value="{{ $m_late_inform_master->late_inform_master_id }}">
                <input type="hidden" class="form-control" id="txt_company_id" name="txt_company_id" readonly value="{{ $txt_company_id }}">
                <input type="text" class="form-control" id="txt_company_name" name="txt_company_name" readonly value="{{ $txt_company }}">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_employee_name" name="txt_employee_name" readonly value="{{ $txt_employee_name }}">
              </div>
              <div class="col-3">
                <input type="hidden" class="form-control" id="txt_desig_id" name="txt_desig_id" readonly value="{{ $txt_desig_id }}">
                <input type="text" class="form-control" id="txt_desig_name" name="txt_desig_name" readonly value="{{ $txt_desig }}">
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-3">
                <input type="text" class="form-control" id="txt_leave_type" name="txt_leave_type" readonly value="{{ $txt_late_type }}">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_leave_form" name="txt_leave_form" readonly value="{{ $m_late_inform_master->late_form }}">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_leave_to" name="txt_leave_to" readonly value="{{ $m_late_inform_master->late_to }}">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_leave_total" name="txt_leave_total" readonly value="{{ $m_late_inform_master->late_total }} day">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <input type="text" class="form-control" id="txt_purpose_leave" name="txt_purpose_leave" readonly value="{{ $m_late_inform_master->purpose_late }}">               
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-3">&nbsp;
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                
               <input type="hidden" class="form-control" id="sele_late_type" name="sele_late_type" readonly value="{{ $m_late_inform_master->late_type_id}}" >

               <input type="text" class="form-control"  readonly value="{{ $txt_late_type }}" >
                

              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_from_date"
                    name="txt_from_date" placeholder="From Date"
                    value="{{ $m_late_inform_master->late_form }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}" readonly="">
                @error('txt_from_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_to_date"
                    name="txt_to_date" placeholder="To Date"
                    value="{{ $m_late_inform_master->late_to }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}" onchange="DateDiff(this.value)" readonly="">

                @error('txt_to_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_total" name="txt_total" readonly value="{{ $m_late_inform_master->late_total }}">
              </div>
              <div class="col-3">
                <select name="cbo_approved_id" id="cbo_approved_id" class="form-control">
                  <option value="">Report To</option>
                  @foreach ($ci_report as $row_report)
                      <option value="{{ $row_report->employee_id }}">
                        {{ $row_report->employee_id }} | {{ $row_report->employee_name }}
                      </option>
                  @endforeach
                </select>
                @error('cbo_approved_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>

            </div>
            <div class="row mb-2">
              <div class="col-8">
                &nbsp;
              </div>
              <div class="col-2">
                @if($ci_report->count() == 0)
                <button type="" class="btn btn-primary btn-block" disabled="">Add</button>
                @else
                <button type="Submit" class="btn btn-primary btn-block">Add</button>
                @endif
              </div>
              <div class="col-2">
                @if($ci_report->count() == 0)
                 <a href="{{route('move_app_for_approval_upload',$m_late_inform_master->late_inform_master_id)}}" class="btn btn-primary btn-block">Continue</a>
                 @else
                  <button  class="btn btn-primary btn-block" disabled="">Continue</button> 
                 @endif
              </div>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
{{-- @include('/hrm/leave_approval_others_list') --}}
@endif
  @section('script')
  <script>
          function DateDiff(val) {
           var date1 = new Date(document.getElementById("txt_from_date").value)
           var date2 = new Date(val);
           var Difference_In_Time = date2.getTime() - date1.getTime();
           var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
           document.getElementById("txt_total").value=Difference_In_Days+1;
          }
      </script>
  @endsection
@endsection