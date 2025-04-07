@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Finish Product Stock Details</h1>
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
                    <form action="{{ route('rpt_finish_product_stock_details_list') }}" method="POST">
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
                            <div class="col-2">
                                <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">

                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">
                                @error('txt_to_date')
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
