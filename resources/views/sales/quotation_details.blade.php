@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUATATION DETAILS</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($quotation_details_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="myForm"
                                action="{{ route('quotation_details_update',[ $quotation_details_edit->quotation_details_id, $quotation_details_edit->company_id]) }}"
                                method="post">
                                @csrf
                                <div class="row mb-1">
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $quotation_master_edit->quotation_master_id }}"
                                            id="txt_quatation_number" name="txt_quatation_number">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $quotation_master_edit->quotation_date }}" id="txt_quatation_date"
                                            name="txt_quatation_date">
                                    </div>
                                       <div class="col-4">
                                        <input type="text" class="form-control" id="txt_customer_name"
                                            name="txt_customer_name" value="{{ $quotation_master_edit->customer_name }}"
                                            readonly>
                                        @error('txt_customer_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-1">
                                 
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_mobile_number"
                                            name="txt_mobile_number" value="{{ $quotation_master_edit->customer_mobile }}" placeholder="Mobile Number"
                                            readonly>
                                        @error('txt_mobile_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="txt_address" name="txt_address"
                                            value="{{ $quotation_master_edit->customer_address }}" placeholder="Address" readonly>
                                        @error('txt_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                            readonly value="{{ $quotation_master_edit->subject }}" placeholder="Subject">
                                        @error('txt_subject')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_reference_name"
                                            name="txt_reference_name" placeholder="Reference Name" readonly
                                            value="{{ $quotation_master_edit->reference }}">
                                        @error('txt_reference_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_reference_number"
                                            name="txt_reference_number" placeholder="Reference Number" readonly
                                            value="{{ $quotation_master_edit->reference_mobile }}">
                                        @error('txt_reference_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_product_name" name="cbo_product_name">
                                            <option value="0">-Select Product Name-</option>
                                            @foreach ($m_product as $value)
                                                <option value="{{ $value->product_id }}"
                                                    {{ $value->product_id == $quotation_details_edit->product_id ? 'selected' : '' }}>
                                                    {{ $value->product_name }}</option>
                                            @endforeach

                                        </select>
                                        @error('cbo_product_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_rate_policy" name="cbo_rate_policy">
                                            <option value="0">-Select Rate Policy-</option>
                                            @foreach ($m_rate_policy as $value)
                                                <option value="{{ $value->rate_policy_id }}"
                                                    {{ $value->rate_policy_id == $quotation_details_edit->rate_policy_id ? 'selected' : '' }}>
                                                    {{ $value->rate_policy_name }}</option>
                                            @endforeach

                                        </select>
                                        @error('cbo_rate_policy')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_quantity" name="txt_quantity"
                                            value="{{ $quotation_details_edit->qty }}" placeholder="Quantity">
                                        @error('txt_quantity')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row ">
                                    <div class="col-8">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-2">
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="myForm" action="{{ route('quotation_details_store',[$m_quotation_master->quotation_id, $m_quotation_master->company_id]) }}"
                                method="post">
                                @csrf
                                <div class="row mb-1">
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_quotation_master->quotation_master_id }}"
                                            id="txt_quatation_number" name="txt_quatation_number">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $m_quotation_master->quotation_date }}" id="txt_quatation_date"
                                            name="txt_quatation_date">
                                    </div>
                                     <div class="col-4">
                                        <input type="text" class="form-control" id="txt_customer_name"
                                            name="txt_customer_name" value="{{ $m_quotation_master->customer_name }}"
                                            readonly>
                                        @error('txt_customer_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-1">
                                  
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_mobile_number"
                                            name="txt_mobile_number" value="{{ $m_quotation_master->customer_mobile }}" placeholder="Mobile Number"
                                            readonly>
                                        @error('txt_mobile_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="txt_address" name="txt_address"
                                            value="{{ $m_quotation_master->customer_address }}" placeholder="Address" readonly>
                                        @error('txt_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                             value="{{ $m_quotation_master->subject }}" placeholder="Subject" readonly>
                                        @error('txt_subject')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_reference_name"
                                            name="txt_reference_name" placeholder="Reference Name" 
                                            value="{{ $m_quotation_master->reference }}" readonly>
                                        @error('txt_reference_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_reference_number"
                                            name="txt_reference_number" placeholder="Reference Number" readonly
                                            value="{{ $m_quotation_master->reference_mobile }}">
                                        @error('txt_reference_number')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_product_name" name="cbo_product_name">
                                            <option value="0">-Select Product Name-</option>
                                            @foreach ($m_product as $value)
                                                <option value="{{ $value->product_id }}">{{ $value->product_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('cbo_product_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_rate_policy" name="cbo_rate_policy">
                                            <option value="0">-Select Rate Policy-</option>
                                            @foreach ($m_rate_policy as $value)
                                                <option value="{{ $value->rate_policy_id }}">
                                                    {{ $value->rate_policy_name }}</option>
                                            @endforeach

                                        </select>
                                        @error('cbo_rate_policy')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_quantity" name="txt_quantity"
                                            value="{{ old('txt_quantity') }}" placeholder="Quantity">
                                        @error('txt_quantity')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row ">
                                    <div class="col-8">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id="confirm_action"
                                            class="btn btn-primary btn-block" id="confirm_action" onclick="BTOFF()" disabled>Add</button>
                                    </div>
                                    <div class="col-2">
                                        @php
                                            $quotation_details = DB::table("pro_quotation_details_$m_quotation_master->company_id")
                                                ->where('quotation_id', $m_quotation_master->quotation_id)
                                                ->first();
                                        @endphp
                                        @if (isset($quotation_details))
                                            <a href="{{ route('quotation_details_more', [$m_quotation_master->quotation_id,$m_quotation_master->company_id]) }}"
                                                id="confirm_action2" onclick="BTOFF2()" class="btn btn-primary btn-block disabled">Continue</a>
                                        @else
                                            <a href="#" class="btn btn-primary btn-block disabled">Continue</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('sales.quotation_details_list')
    @endif
@endsection
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
@endsection