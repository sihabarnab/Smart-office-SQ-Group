@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requsition List for Issue</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.inventory_status', '1')
            ->get();
        // $company_id = DB::table('pro_user_company')
        //     ->Where('employee_id', $m_user_id)
        //     ->pluck('company_id');

        // $company_id = [1];
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="myForm" action="{{ route('company_wise_requsition_list_for_issue') }}" method="post">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-12">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="0">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}">
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <div class="row mb-2">
                            <div class="col-10">
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                <label for="AYC">Are you Confirm</label>
                            </div>
                            <div class="col-2">
                                <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                    disabled>Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    @if (isset($mr_master))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Company</th>
                                        <th>Project</th>
                                        <th>Section</th>
                                        <th>Requsition No/Date</th>
                                        <th>Prepared By</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mr_master as $key => $value)
                                        @php
                                            $prepared_by = '';
                                            if ($value->user_id) {
                                                $user = DB::table('pro_employee_info')
                                                    ->where('employee_id', $value->user_id)
                                                    ->first();
                                                if ($user == null) {
                                                    $prepared_by = '';
                                                } else {
                                                    $prepared_by = $user->employee_name;
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->company_name }}</td>
                                            <td>{{ $value->project_name }}</td>
                                            <td>{{ $value->section_name }}</td>
                                            <td>{{ $value->mrm_no }} <br> {{ $value->mrm_date }}</td>
                                            <td>
                                                {{ $prepared_by }}
                                            </td>
                                            <td><a
                                                    href="{{ route('inventory_req_material_issue', [$value->mrm_no, $value->company_id]) }}">Create
                                                    Issue</a></td>
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
