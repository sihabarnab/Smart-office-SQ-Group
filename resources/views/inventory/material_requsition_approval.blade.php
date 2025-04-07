@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requsition Approval</h1>
                    {{$mr_master->company_name}}
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

                        <div class="row">
                            <div class="col-2">
                                <label>Project</label>
                                <p class="form-control">{{ $mr_master->project_name }}</p>
                            </div>
                            <div class="col-2">
                                <label>mrm no</label>
                                <p class="form-control">{{ $mr_master->mrm_no }}</p>
                            </div>
                            <div class="col-2">
                                <label>mrm Date</label>
                                <p class="form-control">{{ $mr_master->mrm_date }}</p>
                            </div>
                            <div class="col-3">
                                <label>Section</label>
                                <p class="form-control">{{ $mr_master->section_name }}</p>
                            </div>
                            <div class="col-3">
                                <label>Prepared By</label>
                                <p class="form-control">{{ $mr_master->user_id }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <label>SL No</label>
                            </div>
                            <div class="col-2">
                                <label>Product Name</label>
                            </div>
                            <div class="col-2">
                                <label for="txt_app_unit">Unit</label>
                            </div>
                            <div class="col-2">
                                <label>Requsition Qty</label>
                            </div>
                            <div class="col-3">
                                <label for="txt_remarks">Remarks</label>

                            </div>
                            <div class="col-1">

                            </div>
                        </div>
                        @foreach ($mr_details as $key => $value)
                            <form id="myForm{{$key}}" action="{{ route('inventory_material_req_approval_ok', [$value->mrd_id,$value->company_id]) }}"
                                method="post">
                                @csrf

                                <input type="hidden" name="txt_mrm_no" value="{{ $value->mrm_no }}">

                                <div class="row mb-1">
                                    <div class="col-2">
                                            <p class="form-control">{{ $key + 1 }}</p>
                                    </div>
                                    <div class="col-2">
                                            <input class="form-control" readonly value="{{ $value->product_name }}">
                                    </div>
                                    <div class="col-2">
                                            <input readonly value="{{ $value->unit_name }}" class="form-control">
                                    </div>

                                    <div class="col-2">
                                            <input class="form-control" name="txt_approved_qty"
                                                value="{{ $value->requsition_qty }}">
                                    </div>
                                    <div class="col-3">
                                            <input type="text" readonly class="form-control" name="txt_approved_remarks"
                                                value="{{ $value->remarks }}">
                                            @error('txt_remarks')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <div class="col-1 d-flex flex-row">
                                        <input type="checkbox" id="AYC" onclick='BTON("{{ $key }}")'
                                            name="AYC" class="mr-2">
                                        <button type="submit" id="confirm_action{{ $key }}"
                                            onclick='BTOFF("{{ $key }}")' class="btn btn-primary m-2"
                                            disabled>ok</button>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function BTON(key) {
            var btname = `confirm_action${key}`;
            if ($(`#${btname}`).prop('disabled')) {
                $(`#${btname}`).prop("disabled", false);
            } else {
                $(`#${btname}`).prop("disabled", true);
            }
        }

        function BTOFF(key) {
            var btname = `confirm_action${key}`;
            if ($(`#${btname}`).prop('disabled')) {
                $(`#${btname}`).prop("disabled", true);
            } else {
                $(`#${btname}`).prop("disabled", true);
            }
            document.getElementById(`myForm${key}`).submit();

        }
    </script>
@endsection