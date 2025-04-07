@extends('layouts.servicing_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cheque Report</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h3 class="mb-5">Add</h3> --}}

                        <form action="{{ route('BpackChequeReportList') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="cbo_bank_id">Bank Name:</label>
                                        <select name="cbo_bank_id" id="cbo_bank_id" class="form-control">
                                            <option value="0">--Select--</option>
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->bank_id }}">
                                                    {{-- {{ $bank->bank_name }}| --}} {{ $bank->bank_sname }}|{{ $bank->branch_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_bank_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="cbo_acc_no_id">Account No:</label>
                                        <select name="cbo_acc_no_id" id="cbo_acc_no_id" class="form-control">
                                            <option value="0">--Select--</option>
                                        </select>
                                        @error('cbo_acc_no_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn bg-primary float-right">Submit</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($Reports))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{-- <h1>Report</h1> --}}
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-left align-top">SL No.</th>
                                        <th class="text-left align-top">Bank/Branch</th>
                                        <th class="text-left align-top">Account No.</th>
                                        <th class="text-left align-top">Book No.</th>
                                        <th class="text-left align-top">Cheque No</th>
                                        <th class="text-left align-top">Cheque Issue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Reports as $key => $value)
                                        <tr>
                                            <td class="text-left align-top">{{ $key + 1 }}</td>
                                            <td class="text-left align-top">
                                                {{ $value->bank_sname . ' | ' . $value->branch_name }}</td>
                                            <td class="text-left align-top">
                                                @php
                                                    $nccount_no = DB::table('bpack_acc_information')
                                                        ->where('acc_id', $value->acc_id)
                                                        ->first();
                                                @endphp
                                                {{ $nccount_no->acc_no }}
                                            </td>
                                            <td class="text-left align-top">
                                                @php
                                                    $book_no = DB::table('bpack_cheque_info')
                                                        ->where('cheque_id', $value->cheque_id)
                                                        ->first();
                                                @endphp
                                                {{ $book_no->cheque_book_no }}
                                            </td>

                                            <td class="text-left align-top">{{ $value->cheque_no }}</td>
                                            <td class="text-left align-top">
                                                @php
                                                    $issue = DB::table('bpack_cheque_issue')
                                                        ->where('acc_id', $value->acc_id)
                                                        ->where('cheque_no', $value->cheque_no)
                                                        ->first();
                                                @endphp
                                                @if ($issue)
                                                    <p>Yes</p>
                                                @else
                                                    <p>No</p>
                                                @endif

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
    @endif




@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_bank_id"]').on('change', function() {
                console.log('ok')
                var cbo_bank_id = $(this).val();
                if (cbo_bank_id) {

                    $.ajax({
                        url: "{{ url('/get/account_no/') }}/" + cbo_bank_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_acc_no_id"]').empty();
                            $('select[name="cbo_acc_no_id"]').append(
                                '<option value="0">Select Option</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_acc_no_id"]').append(
                                    '<option value="' + value.acc_id + '">' + value
                                    .acc_no + '</option>');
                            });
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>
@endsection
@endsection
