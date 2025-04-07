@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Finished Product Stock Details</h1>
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
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th colspan="2">{{$m_finish_product->product_name}}</th>
                                </tr>
                                <tr>
                                    <th class="text-left align-top">Date</th>
                                    <th class="text-left align-top">QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($my_date as $key => $row)
                                    @php
                                        $qty = DB::table("pro_fpsd_$company_id")
                                            ->where('company_id', $company_id)
                                            ->where('product_id', $m_finish_product->product_id)
                                            ->where('fpsm_date', $row)
                                            ->sum('qty');
                                    @endphp
                                    <tr>
                                       
                                        <td>{{ $row }}</td>
                                        <td>{{ $qty }}</td>
                                     </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
