@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gate Pass </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

<div class="container-fluid" id='rr'>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                  <form action="{{route('gate_pass_store',[$delivery_chalan_master_id,$company_id])}}" method="POST">
                    @csrf
                    <div class="row mb-1">
                       
                        <div class="col-4">
                            <input type="text" class="form-control" id="txt_gate_pass_date" name="txt_gate_pass_date"
                                placeholder="Gate Pass Date" value="{{ old('txt_gate_pass_date') }}" onfocus="(this.type='date')"
                                onblur="if(this.value==''){this.type='text'}">
                            @error('txt_gate_pass_date')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-2">
                            <button type="Submit"  class="btn btn-primary btn-block">Submit</button>
                        </div>

                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection