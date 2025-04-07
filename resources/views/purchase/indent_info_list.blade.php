<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Indent List</h1>
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="text-left align-top">SL No.</th>
                                <th class="text-left align-top">Product Group</th>
                                <th class="text-left align-top">Product Sub Group</th>
                                <th class="text-left align-top">Product Name</th>
                                <th class="text-left align-top">Description</th>
                                <th class="text-left align-top">Section</th>
                                <th class="text-left align-top">Qty</th>
                                <th class="text-left align-top">Unit</th>
                                <th class="text-left align-top">Remarks</th>
                                <th class="text-left align-top">Product Require Date</th>
                                <th class="text-left align-top"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_indent_detail_all as $key => $value)
                                <tr>
                                    <td class="text-left align-top">{{ $key+1 }}</td>
                                    <td class="text-left align-top">{{ $value->pg_name }}</td>
                                    <td class="text-left align-top">{{ $value->pg_sub_name }}</td>
                                    <td class="text-left align-top">{{ $value->product_name }}</td>
                                    <td class="text-left align-top">{{ $value->description }}</td>
                                    <td class="text-left align-top">{{ $value->section_name }}</td>
                                    <td class="text-left align-top">{{ $value->qty }}</td>
                                    <td class="text-left align-top"> 
                                        @php
                                         $unit=DB::table('pro_units')->where('unit_id','=',$value->unit)->first();
                                        @endphp
                                         @if(isset($unit))
                                         {{  $unit->unit_name }}
                                         @endif
                                    </td>
                                    <td class="text-left align-top">{{ $value->remarks }}</td>
                                    <td class="text-left align-top">{{ $value->req_date }}</td>
                                    <td class="text-left align-top">
                                        <a href="{{ route('purchase_indent_update',[$value->indent_details_id,$value->company_id]) }}">Edit</a>
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
