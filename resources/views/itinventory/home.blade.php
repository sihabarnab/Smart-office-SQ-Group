@extends('layouts.itinventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">IT INVENTORY </h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <style>
        .small-box {
            position: relative;
        }

        .small-box .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.588);
            /* Black overlay with 50% opacity */
            z-index: 1;
            /* Make sure the overlay stays behind the text */
        }

        .small-box .inner {
            position: relative;
            z-index: 2;
            /* Ensure the content is on top of the overlay */
            color: #fff;
            /* White text for contrast */
        }
    </style>


    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                @php
                $m_product_type = DB::table('pro_product_type')->where('valid','1')->get();
                @endphp

                @foreach($m_product_type as $row)
                @php
                $data = DB::table('pro_itassets')->where('pro_itassets.product_type_id',$row->product_type_id)->count();
                $icon = $row->product_type_icon == null ? '':$row->product_type_icon;
                @endphp
                    <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info"
                        style="background-image: url('{{ asset("public/image/dashboard/itinventory/$icon") }}'); background-size: cover; background-repeat: round; box-shadow: 0 4px 8px rgba(255, 255, 255, 0.5);">
                        <div class="overlay"></div> <!-- Black overlay -->
                        <div class="inner">
                            <h3 class="value" count="{{ $data }}">0</h3>
                            <p>{{$row->product_type_name}}</p>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <script>
            const counters = document.querySelectorAll(".value");
            const speed = 1000;

            counters.forEach((counter) => {
                const animate = () => {
                    const value = +counter.getAttribute("count");
                    const data = +counter.innerText;

                    const time = value / speed;
                    if (data < value) {
                        counter.innerText = Math.ceil(data + time);
                        setTimeout(animate, 1);
                    } else {
                        counter.innerText = value;
                    }
                };

                animate();
            });
        </script>

    </div>
@endsection
@section('img')
    <div class="row">
        <div class="col-12" style="position: relative">
            <img src="../../docupload/sqgroup/img/sq_group_logo_01.png" class=""
                style="position: absolute; top:-124px; right:33%;" height="100px">
        </div>

    </div>
@endsection
