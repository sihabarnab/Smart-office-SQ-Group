<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product Information</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Product Category</th>
                                <th>Group</th>
                                <th>Sub Group</th>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($data as $key=>$row)
                            @php
                            $ci_product_group=DB::table('pro_product_group')->Where('pg_id',$row->pg_id)->first();
                            $txt_pg_name=$ci_product_group->pg_name;

                            if ($row->pg_sub_id=='0')
                            {
                               $txt_pg_sub_name='N/A'; 
                            } else {
                                $ci_product_sub_group=DB::table('pro_product_sub_group')->Where('pg_sub_id',$row->pg_sub_id)->first();
                                $txt_pg_sub_name=$ci_product_sub_group->pg_sub_name;
                            }


                            if ($row->product_category=='0')
                            {
                               $txt_product_category_name='N/A'; 
                            } else {
                                $ci_product_cat=DB::table('pro_product_cat')->Where('product_cat_id',$row->product_category)->first();
                                $txt_product_category_name=$ci_product_cat->product_category_name;
;
                            }


                            $ci_units=DB::table('pro_units')->Where('unit_id',$row->unit)->first();
                            $txt_unit_name=$ci_units->unit_name;

                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $txt_product_category_name }}</td>
                                <td>{{ $txt_pg_name }}</td>
                                <td>{{ $txt_pg_sub_name }}</td>
                                <td>{{ $row->product_name }}</td>
                                <td>{{ $txt_unit_name }}</td>
                                <td>{{ $row->product_description }}</td>
                                <td>
                                    <a href="{{ route('inventoryproductedit',$row->product_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
