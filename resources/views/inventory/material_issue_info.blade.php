@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Issue</h1>
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
                        <form id="myForm" action="{{ route('inventory_req_material_issue_store',$mr_master->company_id) }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                        <label for="">Company</label>
                                      <input type="text" readonly class="form-control" value="{{ $mr_master->company_name }}" readonly>
                                      
                                </div>
                                <div class="col-3">
                                        <label for="">Project</label>
                                      <input type="text" readonly class="form-control" id="txt_project_id" name="txt_project_id" value="{{ $mr_master->project_name }}" readonly>
                                      
                                </div>
                                <div class="col-2">
                                        <label for="">Section</label>
                                        <input type="text" readonly class="form-control" id="txt_section_id" name="txt_section_id" value="{{ $mr_master->section_name }}" readonly>
                                      
                                </div>
                                <div class="col-2">
                                        <label for="">Requsition No.</label>
                                        <input type="text" class="form-control" name="txt_requsition_no"
                                          readonly  id="txt_requsition_no" value="{{  $mr_master->mrm_no }}"
                                            placeholder="Requsition Numbers" readonly>
                                        @error('txt_requsition_no')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                </div>

                                <div class="col-2">
                                    <label for="">Requsition Date</label>
                                    <input type="text" class="form-control" id="txt_requsition_date"
                                    readonly  name="txt_requsition_date" value="{{ $mr_master->mrm_date }}">
                                    @error('txt_requsition_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3">
                                        <input type="text" class="form-control" name="txt_job_no" id="txt_job_no"
                                          readonly  value="{{ $mr_master->jo_no }}" placeholder="Job No." readonly>
                                        @error('txt_job_no')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="col-9">
                                        <input type="text" class="form-control" name="txt_job_info" id="txt_job_info"
                                            value="{{ old('txt_job_info') }}" placeholder="Job ">
                                        @error('txt_job_info')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                        <input type="text" class="form-control" name="txt_Remarks" id="txt_Remarks"
                                            value="{{ old('txt_Remarks') }}" placeholder="Remarks">
                                        @error('txt_Remarks')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-10">
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                                <div class="col-2">
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                        disabled>Next</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div> 

@endsection
@section('script')
    <script>
        function BTON() {

            if ($('#confirm_action').prop('disabled')) {
                $("#confirm_action").prop("disabled", false);
            } else {
                $("#confirm_action").prop("disabled", true);
            }
        }

        function BTOFF() {
            if ($('#confirm_action').prop('disabled')) {
                $("#confirm_action").prop("disabled", true);
            } else {
                $("#confirm_action").prop("disabled", true);
            }
            document.getElementById("myForm").submit();
        }
    </script>
@endsection