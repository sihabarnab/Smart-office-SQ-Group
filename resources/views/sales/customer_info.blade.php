@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Customer Information</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>


    @if (isset($m_customer))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form id="myForm" method="post"
                                action="{{ route('customer_info_update', $m_customer->customer_id) }}">
                                @csrf
                                {{-- {{method_field('patch')}} --}}
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_company" name="cbo_company">
                                            <option value="">--Select Company--</option>
                                            @foreach ($user_company as $value)
                                                <option value="{{ $value->company_id }}"  {{$m_customer->company_id == $value->company_id?"selected":''}}>
                                                    {{ $value->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="txt_customer_id"
                                            name="txt_customer_id" placeholder="" readonly
                                            value="{{ $m_customer->customer_id }}">

                                        <input type="text" class="form-control"mid="txt_customer_name"
                                            name="txt_customer_name" placeholder="Customer Name"
                                            value="{{ $m_customer->customer_name }}">
                                        @error('txt_customer_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control"mid="txt_customer_add"
                                            name="txt_customer_add" placeholder="Customer Address"
                                            value="{{ $m_customer->customer_address }}">
                                        @error('txt_customer_add')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-control" name="cbo_customer_type_id" id="cbo_customer_type_id">
                                            <option value="">Customer Type</option>
                                            @foreach ($customer_type as $value)
                                                <option value="{{ $value->customer_type_id }}"
                                                    {{ $value->customer_type_id == $m_customer->customer_type ? 'selected' : '' }}>
                                                    {{ $value->customer_type }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_customer_type_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_zip" name="txt_zip"
                                            placeholder="Zip" value="{{ $m_customer->customer_zip }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_city" name="txt_city"
                                            placeholder="City" value="{{ $m_customer->customer_city }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_country" name="txt_country"
                                            placeholder="Country" value="{{ $m_customer->customer_country }}">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control"mid="txt_customer_phone"
                                            name="txt_customer_phone" placeholder="Contact Number"
                                            value="{{ $m_customer->customer_phone }}">
                                        @error('txt_customer_phone')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_customer_fax"
                                            name="txt_customer_fax" placeholder="Fax"
                                            value="{{ $m_customer->customer_fax }}">
                                        @error('txt_customer_fax')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_customer_url"
                                            name="txt_customer_url" placeholder="URL"
                                            value="{{ $m_customer->customer_url }}">
                                        @error('txt_customer_url')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control"mid="txt_customer_email"
                                            name="txt_customer_email" placeholder="Email"
                                            value="{{ $m_customer->customer_email }}">
                                        @error('txt_customer_email')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control"mid="txt_contact_person"
                                            name="txt_contact_person" placeholder="Contact Person"
                                            value="{{ $m_customer->contact_person }}">
                                        @error('txt_contact_person')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form id="myForm" action="{{ route('customer_info_store') }}" method="Post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_company" name="cbo_company">
                                            <option value="">--Select Company--</option>
                                            @foreach ($user_company as $value)
                                                <option value="{{ $value->company_id }}"  {{old('cbo_company') == $value->company_id?"selected":''}}>
                                                    {{ $value->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_customer_name"
                                            name="txt_customer_name" placeholder="Customer Name"
                                            value="{{ old('txt_customer_name') }}">
                                        @error('txt_customer_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_customer_add"
                                            name="txt_customer_add" placeholder="Customer Address"
                                            value="{{ old('txt_customer_add') }}">
                                        @error('txt_customer_add')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-control" name="cbo_customer_type_id"
                                            id="cbo_customer_type_id">
                                            <option value="">Customer Type</option>
                                            @foreach ($customer_type as $value)
                                                <option value="{{ $value->customer_type_id }}">
                                                    {{ $value->customer_type }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_customer_type_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_zip" name="txt_zip"
                                            placeholder="Zip" value="{{ old('txt_zip') }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_city" name="txt_city"
                                            placeholder="City" value="{{ old('txt_city') }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_country" name="txt_country"
                                            placeholder="Country" value="{{ old('txt_country') }}">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_customer_phone"
                                            name="txt_customer_phone" placeholder="Contact Number"
                                            value="{{ old('txt_customer_phone') }}">
                                        @error('txt_customer_phone')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_customer_fax"
                                            name="txt_customer_fax" placeholder="Fax"
                                            value="{{ old('txt_customer_fax') }}">
                                        @error('txt_customer_fax')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_customer_url"
                                            name="txt_customer_url" placeholder="URL"
                                            value="{{ old('txt_customer_url') }}">
                                        @error('txt_customer_url')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_customer_email"
                                            name="txt_customer_email" placeholder="Email"
                                            value="{{ old('txt_customer_email') }}">
                                        @error('txt_customer_email')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_contact_person"
                                            name="txt_contact_person" placeholder="Contact Person"
                                            value="{{ old('txt_contact_person') }}">
                                        @error('txt_contact_person')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>




                                <div class="row mb-2">
                                    <div class="col-10">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-2">
                                        <button id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary btn-block" disabled>Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sales.customer_info_list')
        &nbsp;
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
