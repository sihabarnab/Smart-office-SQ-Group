@extends('layouts.purchase_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Indent List For RR</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


    @php
        $m_user_id = Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.purchase_status', '1')
            ->get();
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('company_wise_list_for_rr') }}" method="post">
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
                                &nbsp;
                            </div>
                            <div class="col-2">
                                <button type="Submit" id="save_event" class="btn btn-primary btn-block">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    {{-- @isset($pro_indent_master)
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-left align-top">SL No.</th>
                                        <th class="text-left align-top">Project</th>
                                        <th class="text-left align-top">Indent No / Date</th>
                                        <th class="text-left align-top">Indent Category</th>
                                        <th class="text-left align-top"></th>
                                        <th class="text-left align-top"></th>
                                        <th class="text-left align-top"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pro_indent_master as $key => $value)
                                        <tr>
                                            <td class="text-left align-top">{{ $key + 1 }}</td>
                                            <td class="text-left align-top">{{ $value->project_name }}</td>
                                            <td class="text-left align-top">{{ $value->indent_no }} <br>
                                                {{ $value->entry_date }} </td>
                                            <td class="text-left align-top">{{ $value->category_name }}</td>
                                            <td class="text-left align-top"></td>
                                            <td class="text-left align-top"></td>
                                            <td class="text-left align-top">
                                                <a
                                                    href="{{ route('PurchaseIndentReceivingReport', [$value->indent_no, $value->company_id]) }}">Create
                                                    RR</a>
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
    @endisset --}}

@endsection
