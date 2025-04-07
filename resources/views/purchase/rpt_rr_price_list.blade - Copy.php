@extends('layouts.purchase_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">RR List For Price</h1>
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
                                <th class="text-left align-top">SL No.</th>
                                <th class="text-left align-top">Project<br>Indent Category</th>
                                <th class="text-left align-top">Indent No / Date</th>
                                <th class="text-left align-top">RR No/Date</th>
                                <th class="text-left align-top">Challan No/Date</th>
                                <th class="text-left align-top">LC No/Date</th>
                                <th class="text-left align-top">Supplier</th>
                                <th class="text-left align-top">View/Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_indent_master as $key => $value)
                                <tr>
                                    <td class="text-left align-top">{{ $key+1 }}</td>
                                    <td class="text-left align-top">{{ $value->project_name }}<br>{{ $value->category_name }}</td>
                                    <td class="text-left align-top">{{ $value->indent_no }} <br> {{ $value->indent_date }} </td>
                                    <td class="text-left align-top">{{ $value->grr_no }} <br> {{ $value->grr_date }} </td>
                                    <td class="text-left align-top">{{ $value->chalan_no }} <br> {{ $value->chalan_date }} </td>
                                    <td class="text-left align-top">{{ $value->glc_no }} <br> {{ $value->glc_date }} </td>
                                    <td class="text-left align-top">{{ $value->supplier_name }} <br> {{ $value->supplier_address }}</td>
                                    <td class="text-left align-top">
                                        <a href="{{ route('rpt_rr_price_list_view',$value->grr_master_id ) }}">View</a>
                                    </td>
                                    
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