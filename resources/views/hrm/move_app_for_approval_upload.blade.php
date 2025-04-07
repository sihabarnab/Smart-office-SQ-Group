@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Upload File</h1>
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
            <form action="{{ route('move_file_store',$m_late_inform_master->late_inform_master_id) }}" method="Post" enctype="multipart/form-data">
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
                <input type="hidden" class="form-control" id="txt_late_info_master_id" name="txt_late_info_master_id" readonly value="{{ $m_late_inform_master->late_inform_master_id }}">
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
                <input type="text" class="form-control" id="txt_late_type" name="txt_late_type" readonly value="{{ $txt_late_type }}">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_late_form" name="txt_late_form" readonly value="{{ $m_late_inform_master->late_form }}">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_late_to" name="txt_late_to" readonly value="{{ $m_late_inform_master->late_to }}">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_late_total" name="txt_late_total" readonly value="{{ $m_late_inform_master->late_total }} day">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <input type="text" class="form-control" id="txt_purpose_late" name="txt_purpose_late" readonly value="{{ $m_late_inform_master->purpose_late }}">               
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-12">
                 <input type="file" name="txt_file" id='txt_file' class="form-control">
               @error('txt_file')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
            </div>


           

            <div class="row mb-2">
              <div class="col-10">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Upload</button>
              </div>
            </div>

            </form>
          </div>
      </div>
    </div>
  </div>
</div>


@endsection