@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product Unit</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            @include('flash-message')
        </div>
        @if (isset($m_unit))
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Edit' }}</h5>
                        </div>
                        <form id="myForm" method="post" action="{{ route('prounitupdate', $m_unit->unit_id) }}">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="hidden" class="form-control" id="txt_unit_id" name="txt_unit_id"
                                        value="{{ $m_unit->unit_id }}">
                                    <input type="text" class="form-control" id="txt_unit_name" name="txt_unit_name"
                                        value="{{ $m_unit->unit_name }}">
                                    @error('txt_unit_name')
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
    </section>
@else
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div align="left" class="">
                    <h5>{{ 'Add' }}</h5>
                </div>
                <form id="myForm" method="post" action="{{ route('unitstore') }}">
                    @csrf

                    <div class="row mb-2">
                        <div class="col-12">
                            <input type="text" class="form-control" id="txt_unit_name" name="txt_unit_name"
                                value="{{ old('txt_unit_name') }}" placeholder="Unit Name">
                            @error('txt_unit_name')
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
    </section>
    @endif
    @include('inventory.product_unit_list')
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
