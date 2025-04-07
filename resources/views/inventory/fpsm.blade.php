@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Finish Product Stock</h1>
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
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form id="myForm" action="{{ route('FinishProductStockMasterStore') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                        <option value="0">--Select Company--</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}">
                                                {{ $value->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="form-control" id="cbo_pg_id" name="cbo_pg_id">
                                        <option value="0">Product Group</option>
                                        <option value="28">TRANSFORMER</option>
                                        <option value="33">CTPT</option>
                                    </select>
                                    @error('cbo_pg_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                  <select name="cbo_pg_sub_id" id="cbo_pg_sub_id" class="form-control">
                                      <option value="0">Product Sub Group</option>
                                  </select>
                                  @error('cbo_pg_sub_id')
                                      <div class="text-warning">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_stock_date" name="txt_stock_date"
                                        placeholder="Stock Date" value="{{ old('txt_stock_date') }}"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_stock_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" name="txt_remarks" id="txt_remarks" placeholder="Remarks" 
                                        value="{{ old('txt_remarks') }}" placeholder=" ">
                                    @error('txt_remarks')
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
    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_pg_id"]').on('change', function() {
                console.log('ok')
                var cbo_pg_id = $(this).val();
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_pg_id && cbo_company_id) {

                    $.ajax({
                        url: "{{ url('/get/pg/') }}/" + cbo_pg_id +'/'+cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_pg_sub_id"]').empty();
                            $('select[name="cbo_pg_sub_id"]').append(
                                '<option value="0">Product Sub Group</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_pg_sub_id"]').append(
                                    '<option value="' + value.pg_sub_id + '">' +
                                    value.pg_sub_id + ' | ' + value.pg_sub_name + '</option>');
                            });
                        },
                    });

                }

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
@endsection