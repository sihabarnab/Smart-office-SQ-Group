@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">MUSHOK</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $year = date('Y');
        $month = date('m');

        if ($month >= 7 && $month <= 12) {
            $next_year = $year + 1;
            $financial_year_name = "$year-$next_year";
        } elseif ($month >= 1 && $month <= 6) {
            $last_year = $year - 1;
            $financial_year_name = "$last_year-$year";
        }

        $m_financial_year = DB::table('pro_financial_year')
            ->where('valid', '1')
            ->get();
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="myForm" action="{{ route('mushok_store') }}" method="post">
                            @csrf
                            <div class="row mb-1">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="">-Select Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}">{{ $value->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="form-control" id="cbo_financial_year_id" name="cbo_financial_year_id">
                                        <option value="">-Select Financial Year-</option>
                                        @foreach ($m_financial_year as $row_financial_year)
                                            <option value="{{ $row_financial_year->financial_year_id }}">
                                                {{ $row_financial_year->financial_year_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_financial_year_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <input type="number" class="form-control" id="txt_mushok_serial"
                                        name="txt_mushok_serial" placeholder="Mushok No.">
                                    @error('txt_mushok_serial')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <input type="number" class="form-control" id="txt_mushok_qty" name="txt_mushok_qty"
                                        placeholder="Qty">
                                    @error('txt_mushok_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>{{-- end row --}}

                            <div class="row ">
                                <div class="col-10">
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                                <div class="col-2">
                                    <button type="Submit"  id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('m_musuk'))
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
                                        <th>SL</th>
                                        <th>Company Name</th>
                                        <th>Mushok Number</th>
                                        <th>Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (session('m_musuk') as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->company_name }}</td>
                                            <td>{{ $row->mushok_number }}</td>
                                            <td>{{ $row->financial_year_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@section('script')
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
