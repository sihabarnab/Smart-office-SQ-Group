@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Supplier Information</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.inventory_status', '1')
            ->get();
    @endphp

    @if (isset($m_supplier))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form id="myForm" method="post"
                                action="{{ route('inventorysupplierinfoupdate', $m_supplier->supplier_id) }}">
                                @csrf
                                <div class="row mb-2">

                                    <div class="col-3">
                                        <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                            <option value="">--Select Company--</option>
                                            @foreach ($user_company as $value)
                                                <option value="{{ $value->company_id }}"
                                                    {{ $value->company_id == $m_supplier->company_id ? 'selected' : '' }}>
                                                    {{ $value->company_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div><!-- /.col -->

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_supplier_name"
                                            name="txt_supplier_name" value="{{ $m_supplier->supplier_name }}"
                                            placeholder="Supplier Name">
                                        @error('txt_supplier_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_supplier_type" name="cbo_supplier_type">
                                            <option value="0">--Select Type--</option>
                                            <option value="1" {{ $m_supplier->supplier_type == 1 ? 'selected' : '' }}>
                                                Wholeseller</option>
                                            <option value="2" {{ $m_supplier->supplier_type == 2 ? 'selected' : '' }}>
                                                Importer</option>
                                            <option value="3" {{ $m_supplier->supplier_type == 3 ? 'selected' : '' }}>
                                                Retailer</option>
                                            <option value="4" {{ $m_supplier->supplier_type == 4 ? 'selected' : '' }}>
                                                Direct Sales</option>
                                            <option value="5" {{ $m_supplier->supplier_type == 5 ? 'selected' : '' }}>
                                                Dealer</option>
                                            <option value="6" {{ $m_supplier->supplier_type == 6 ? 'selected' : '' }}>
                                                Showroom</option>
                                        </select>
                                        @error('cbo_supplier_type')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_contact_person"
                                            name="txt_contact_person" value="{{ $m_supplier->supplier_contact }}"
                                            placeholder="Contact Person">
                                        @error('txt_contact_person')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_address" name="txt_address"
                                            value="{{ $m_supplier->supplier_address }}" placeholder="Address">
                                        @error('txt_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_zip_code" name="txt_zip_code"
                                            value="{{ $m_supplier->supplier_zip }}" placeholder="Zip Code">
                                        @error('txt_zip_code')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_city" name="txt_city"
                                            value="{{ $m_supplier->supplier_city }}" placeholder="City">
                                        @error('txt_city')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_country" name="txt_country"
                                            value="{{ $m_supplier->supplier_country }}" placeholder="Country">
                                        @error('txt_country')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_state" name="txt_state"
                                            value="{{ $m_supplier->supplier_state }}" placeholder="State">
                                        @error('txt_state')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_phone" name="txt_phone"
                                            value="{{ $m_supplier->supplier_phone }}" placeholder="Phone">
                                        @error('txt_phone')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_mobile" name="txt_mobile"
                                            value="{{ $m_supplier->supplier_mobile }}" placeholder="Mobile">
                                        @error('txt_mobile')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_fax" name="txt_fax"
                                            value="{{ $m_supplier->supplier_fax }}" placeholder="Fax">
                                        @error('txt_fax')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_email" name="txt_email"
                                            value="{{ $m_supplier->supplier_email }}" placeholder="Email">
                                        @error('txt_email')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_url" name="txt_url"
                                            value="{{ $m_supplier->supplier_url }}" placeholder="Url">
                                        @error('txt_url')
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
                                        <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                            disabled>Update</button>
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
                            <form id="myForm" action="{{ route('inventorysupplierinfostore') }}" method="Post">
                                @csrf

                                <div class="row mb-2">

                                    <div class="col-3">
                                        <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                            <option value="">--Select Company--</option>
                                            @foreach ($user_company as $value)
                                                <option value="{{ $value->company_id }}">
                                                    {{ $value->company_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div><!-- /.col -->

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_supplier_name"
                                            name="txt_supplier_name" value="{{ old('txt_supplier_name') }}"
                                            placeholder="Supplier Name">
                                        @error('txt_supplier_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_supplier_type" name="cbo_supplier_type">
                                            <option value="0">--Select Type--</option>
                                            <option value="1">Wholeseller</option>
                                            <option value="2">Importer</option>
                                            <option value="3">Retailer</option>
                                            <option value="4">Direct Sales</option>
                                            <option value="5">Dealer</option>
                                            <option value="6">Showroom</option>
                                        </select>
                                        @error('cbo_supplier_type')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_contact_person"
                                            name="txt_contact_person" value="{{ old('txt_contact_person') }}"
                                            placeholder="Contact Person">
                                        @error('txt_contact_person')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_address" name="txt_address"
                                            value="{{ old('txt_address') }}" placeholder="Address">
                                        @error('txt_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_zip_code" name="txt_zip_code"
                                            value="{{ old('txt_zip_code') }}" placeholder="Zip Code">
                                        @error('txt_zip_code')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_city" name="txt_city"
                                            value="{{ old('txt_city') }}" placeholder="City">
                                        @error('txt_city')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_country" name="txt_country"
                                            value="{{ old('txt_country') }}" placeholder="Country">
                                        @error('txt_country')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_state" name="txt_state"
                                            value="{{ old('txt_state') }}" placeholder="State">
                                        @error('txt_state')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_phone" name="txt_phone"
                                            value="{{ old('txt_phone') }}" placeholder="Phone">
                                        @error('txt_phone')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_mobile" name="txt_mobile"
                                            value="{{ old('txt_mobile') }}" placeholder="Mobile">
                                        @error('txt_mobile')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_fax" name="txt_fax"
                                            value="{{ old('txt_fax') }}" placeholder="Fax">
                                        @error('txt_fax')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_email" name="txt_email"
                                            value="{{ old('txt_email') }}" placeholder="Email">
                                        @error('txt_email')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_url" name="txt_url"
                                            value="{{ old('txt_url') }}" placeholder="Url">
                                        @error('txt_url')
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
                                        <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                            disabled>Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('inventory.supplier_info_list')
        &nbsp;
    @endif
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            getsupply_info();

            $('select[name="cbo_company_id"]').on('change', function() {
                getsupply_info();
            });
        });
    </script>

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

    <script>
        function getsupply_info() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                var k = 1;
                $.ajax({
                    url: "{{ url('/get/supply_info') }}/" + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#supply_info').dataTable({
                            "responsive": true,
                            "lengthChange": false,
                            "autoWidth": false,
                            dom: 'Blfrtip',
                            buttons: [{
                                    extend: 'csvHtml5',
                                    title: 'Supply Information'
                                },
                                {
                                    extend: 'pdfHtml5',
                                    title: 'Supply Information'
                                    // orientation: 'landscape',
                                    // pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'print',
                                    title: 'Supply Information',
                                    autoPrint: true,
                                    exportOptions: {
                                        columns: ':visible'
                                    },
                                },
                                'colvis',
                            ],
                            "data": data,
                            "columns": [{
                                    data: null,
                                    render: function(data, type, full) {
                                        return k++;
                                    }
                                },
                                {
                                    "data": "supplier_name"
                                },
                                {
                                    "data": "supplier_address"
                                },
                                {
                                    data: null,
                                    render: function(data, type, full) {
                                        return 'Phone: ' + data.supplier_phone +
                                            '<br> Mobile: ' + data.supplier_mobile +
                                            '<br> Fax: ' + data.supplier_fax +
                                            '<br> Email: ' +
                                            data.supplier_email;
                                    }
                                },
                                {
                                    data: null,
                                    render: function(data, type, full) {
                                        return '<a href="{{ url('/') }}/inventory/supplier_info/edit/' +
                                            data.supplier_id +'/'+data.company_id+
                                            '" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>';
                                    }
                                },
                            ], // end colume
                        }); // end dataTable
                    }, // End Sucess
                }); // end Ajax

            } //endif companny
        }
    </script>
@endsection
@section('css')
    #supply_info_filter {
    width: 100px;
    float: right;
    margin: 6px 150px 0px 0px;
    }
@endsection
