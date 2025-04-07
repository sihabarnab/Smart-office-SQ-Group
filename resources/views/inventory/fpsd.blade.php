@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Finish Product Stock Details</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($m_fpsd_edit))
        @php
            $company_id = $m_fpsm_edit->company_id;
        @endphp
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form id="myForm"
                                action="{{ route('FinishProductDetailsUpdate', [$m_fpsd_edit->fpsd_id, $m_fpsm_edit->company_id]) }}"
                                method="post">
                                @csrf

                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_fpsm_id" name="txt_fpsm_id"
                                            readonly value="{{ $m_fpsm_edit->fpsm_id }}">
                                        <input type="hidden" class="form-control" id="cbo_company_id" name="cbo_company_id"
                                            readonly value="{{ $m_fpsd_edit->fpsd_id }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_fpsm_date" name="txt_fpsm_date"
                                            readonly value="{{ $m_fpsm_edit->fpsm_date }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="cbo_company_id" name="cbo_company_id"
                                            readonly value="{{ $m_fpsm_edit->company_id }}">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_fpsm_edit->company_name }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" readonly id="cbo_pg_id" name="cbo_pg_id"
                                            value="{{ $m_fpsm_edit->pg_id }}">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_fpsm_edit->pg_name }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" readonly id="cbo_pg_sub_id"
                                            name="cbo_pg_sub_id" value="{{ $m_fpsm_edit->pg_sub_id }}">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_fpsm_edit->pg_sub_name }}">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" readonly id="txt_remarks"
                                            name="txt_remarks" value="{{ $m_fpsm_edit->remarks }}">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <select name="cbo_product_id" id="cbo_product_id" class="form-control">
                                            <option value="0">--Product--</option>
                                            @foreach ($m_finish_product as $row_finish_product)
                                                <option value="{{ $row_finish_product->product_id }}"
                                                    {{ $row_finish_product->product_id == $m_fpsd_edit->product_id ? 'selected' : '' }}>
                                                    {{ $row_finish_product->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_qty" id="txt_qty"
                                            value="{{ $m_fpsd_edit->qty }}" placeholder="Quantity">
                                        @error('txt_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-4">
                                        <input type="hidden" name="txt_unit_id" class="form-control" id="txt_unit_id"
                                            readonly value="{{ $m_fpsd_edit->unit_id }}">
                                        <input type="text" class="form-control" name="txt_unit_name" id="txt_unit_name"
                                            readonly value="{{ $m_fpsd_edit->unit_name }}">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-10">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary btn-block" disabled>Update</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @php
            $company_id = $id2;
        @endphp
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form id="myForm" action="{{ route('FinishProductDetailsStore', $id2) }}" method="post">
                                @csrf
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_fpsm_id" name="txt_fpsm_id"
                                            readonly value="{{ $m_fpsm->fpsm_id }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_fpsm_date"
                                            name="txt_fpsm_date" readonly value="{{ $m_fpsm->fpsm_date }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="cbo_company_id"
                                            name="cbo_company_id" readonly value="{{ $id2 }}">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_fpsm->company_name }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" readonly id="cbo_pg_id"
                                            name="cbo_pg_id" value="{{ $m_fpsm->pg_id }}">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_fpsm->pg_name }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" readonly id="cbo_pg_sub_id"
                                            name="cbo_pg_sub_id" value="{{ $m_fpsm->pg_sub_id }}">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_fpsm->pg_sub_name }}">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" readonly id="txt_remarks"
                                            name="txt_remarks" value="{{ $m_fpsm->remarks }}">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <select name="cbo_product_id" id="cbo_product_id" class="form-control">
                                            <option value="0">--Product--</option>
                                            @foreach ($m_finish_product as $row_finish_product)
                                                <option value="{{ $row_finish_product->product_id }}">
                                                    {{ $row_finish_product->product_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_qty" id="txt_qty"
                                            value="{{ old('txt_req_qty') }}" placeholder="Qty">
                                        @error('txt_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="txt_unit_id" name="txt_unit_id"
                                            value="">
                                        <input type="text" class="form-control" name="txt_unit_name"
                                            id="txt_unit_name" readonly value="" placeholder="">
                                    </div>

                                </div>
                               

                                <div class="row">
                                    <div class="col-7">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-5">
                                        <a id="confirm_action2"
                                           href="{{ route('FinishProductDetailsFinal', [$m_fpsm->fpsm_id, $m_fpsm->company_id]) }}"
                                            onclick="BTOFF2()"
                                            class="btn btn-primary float-right pl-5 pr-5 disabled">Final</a>

                                        <button id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary float-right pl-3 pr-3 mr-2 " disabled>
                                            Add Another</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('inventory.fpsd_list')
    @endif

@section('script')
    <script>
        function BTON() {
            if ($('#confirm_action').prop('disabled')) {
                $("#confirm_action").prop("disabled", false);
            } else {
                $("#confirm_action").prop("disabled", true);
            }

            if ($('#confirm_action2').hasClass('disabled')) {
                $("#confirm_action2").removeClass('disabled')
            } else {
                $("#confirm_action2").addClass('disabled');
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

        function BTOFF2() {
            if ($('#confirm_action2').hasClass('disabled')) {
                $("#confirm_action2").addClass('disabled');
            } else {
                $("#confirm_action2").addClass('disabled');
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product_id"]').on('change', function() {
                $('#txt_unit_id').empty();
                $('#txt_unit_name').empty();
                var cbo_product_id = $(this).val();
                if (cbo_product_id) {
                    $.ajax({
                        url: "{{ url('/get/matrial_requsition/unit/product_list/') }}/" +
                            cbo_product_id + '/' + "{{ $company_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_unit_id').val(data.unit_id);
                            $('#txt_unit_name').val(data.unit_name);
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>
@endsection

@endsection
