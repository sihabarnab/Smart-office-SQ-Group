<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Description</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Extended Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                             @foreach ($m_repair_details as $key => $row)
                             @php
                             $m_unit = DB::table('pro_units')->where('unit_id',$row->unit)->where('valid', 1)->first();
                             if($m_unit){
                                $unit_name =  $m_unit->unit_name;
                             }else{
                                $unit_name =  '';
                             }
                                 $total = $row->total+$total;
                             @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>                                   
                                    <td>{{ $row->pro_des }}</td>
                                    <td>{{ $unit_name}}</td>
                                    <td class="text-right">{{ number_format($row->qty,2) }}</td>
                                    <td class="text-right">{{ number_format($row->unit_price,2) }}</td>
                                    <td class="text-right">{{ number_format($row->total,2) }}</td>
                                    <td>
                                        <a href="{{ route('repair_invoice_details_edit', [$row->reinvd_id,$row->company_id]) }}"
                                            class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach 

                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="5">Total</td>
                                <td class="text-right">{{number_format($total,2)}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
