@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Receiving Report</h1>
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
                        <form id="myForm" action="{{ route('inventory_indent_receiving_report_store', $pro_indent_master->company_id) }}"
                            method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <label>Company</label>

                                    <input type="text" class="form-control" readonly
                                        value="{{ $pro_indent_master->company_name }}">
                                </div>
                                <div class="col-3">
                                    <label>Project</label>
                                    <input type="hidden" class="form-control" name="txt_indent_project"
                                        id="txt_indent_project" value="{{ $pro_indent_master->project_id }}">
                                    <input type="text" class="form-control" readonly
                                        value="{{ $pro_indent_master->project_name }}">
                                </div>
                                <div class="col-2">
                                    <label>Indent Category</label>
                                    <input type="hidden" class="form-control" name="txt_indent_category"
                                        id="txt_indent_category" value="{{ $pro_indent_master->indent_category }}">
                                    <input type="text" class="form-control" readonly
                                        value="{{ $pro_indent_master->category_name }}">
                                </div>
                                <div class="col-2">
                                    <label>Indent No</label>
                                    <input type="text" class="form-control" name="txt_indent_no" id="txt_indent_no"
                                        readonly value="{{ $pro_indent_master->indent_no }}">
                                </div>
                                <div class="col-2">
                                    <label>Indent Date</label>
                                    <input type="text" class="form-control" name="txt_indent_date" id="txt_indent_date"
                                        readonly value="{{ $pro_indent_master->entry_date }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select name="cbo_supplier" id="cbo_supplier" class="form-control">
                                        <option value="">--Select Supplier--</option>
                                        @foreach ($pro_supplier_information as $value)
                                            <option value="{{ $value->supplier_id }}">
                                                {{ $value->supplier_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_supplier')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-9">
                                    <input type="text" name="txt_supplier_address" readonly id="txt_supplier_address"
                                        class="form-control" value="{{ old('txt_supplier_address') }}">
                                    @error('txt_supplier_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" name="txt_lc_no" id="txt_lc_no" class="form-control"
                                        value="{{ old('txt_lc_no') }}" placeholder="LC No.">
                                    @error('txt_lc_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_lc_date" name="txt_lc_date"
                                        placeholder="LC Date" value="{{ old('txt_lc_date') }}" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_lc_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" name="txt_challan_no" id="txt_challan_no" class="form-control"
                                        value="{{ old('txt_challan_no') }}" placeholder="Challan No.">
                                    @error('txt_challan_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_challan_date" name="txt_challan_date"
                                        placeholder="Challan Date" value="{{ old('txt_challan_date') }}"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_challan_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" name="txt_trnsport_company" id="txt_trnsport_company"
                                        class="form-control" value="{{ old('txt_trnsport_company') }}"
                                        placeholder="Trnsport Company">
                                    @error('txt_trnsport_company')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" name="txt_trnsport_no" id="txt_trnsport_no"
                                        class="form-control" value="{{ old('txt_trnsport_no') }}"
                                        placeholder="Trnsport No">
                                    @error('txt_trnsport_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" name="txt_remarks" id="txt_remarks" class="form-control"
                                        value="{{ old('txt_remarks') }}" placeholder="Remarks">
                                    @error('txt_remarks')
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
                                        disabled>Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('inventory.rr_current_stock')

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

    {{-- //Supply Address --}}
    <script type="text/javascript">
        $(document).ready(function() {
            // document.getElementById("cbo_supplier").value="{{ old('cbo_supplier') }}";
            $('#cbo_supplier').val("{{ old('cbo_supplier') }}");
            $('#txt_supplier_address').val("{{ old('txt_supplier_address') }}");

            $('select[name="cbo_supplier"]').on('change', function() {
                var suplly = $('#cbo_supplier').val();
                var company = "{{$pro_indent_master->company_id}}";
                if (suplly) {
                    $.ajax({
                        url: "{{ url('/get/supply_address/') }}/" + suplly+'/'+company,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="txt_supplier_address"]').empty();
                            document.getElementById("txt_supplier_address").value = data
                                .supplier_address;
                        },
                    });
                } else {
                    $('select[name="txt_supplier_address"]').empty();
                }

            });
        });
    </script>
@endsection
@endsection
