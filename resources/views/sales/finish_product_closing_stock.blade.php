@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Finish Product Closing Stock</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('finish_product_closing_stock_store') }}" method="POST">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}"
                                            {{ $value->company_id == old('cbo_company_id') ? 'selected' : '' }}>
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                    <option value="">--Transformer / CTPT--</option>
                                    <option value="28" {{ old('cbo_transformer') == '28' ? 'selected' : '' }}>
                                        TRANSFORMER
                                    </option>
                                    <option value="33" {{ old('cbo_transformer') == '33' ? 'selected' : '' }}>CTPT
                                    </option>
                                </select>
                                @error('cbo_transformer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <div class="input-group date" id="sedate3" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="txt_month"
                                        name="txt_month" placeholder="Year Month" value="{{ old('txt_month') }}"
                                        data-target="#sedate3">
                                    <div class="input-group-append" data-target="#sedate3" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                @error('txt_month')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <button type="Submit" id="save_event" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>

                </div><!-- /.row -->

                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    </div>
@endsection
@section('script')
    <script>
        $('#sedate3').datetimepicker({
            format: 'YYYY-MM'
        });
    </script>
@endsection