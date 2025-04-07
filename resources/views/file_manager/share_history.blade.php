@extends('layouts.file_manager_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dawonload History</h1>
                    {{$form}} TO {{$to}}
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('share_history_search') }}" method="GET">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-5">
                                <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">
                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">
                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <button type="Submit" id="save_event" class="btn btn-primary btn-block">Search</button>
                            </div>
                        </div><!-- /.row -->
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data2" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Send Email</th>
                                        <th>File</th>
                                        <th>Expire Date</th>
                                        <th>Dawonload Date/Time</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($my_data as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->to_email }}</td>
                                            <td>{{ $row->file_name }}</td>
                                            <td>{{ $row->expire_date }}</td>
                                            <td>{{ $row->dawonload_date }} <br> {{ $row->dawonload_time }}</td>
                                            <td>{{ $row->dawonload }} time dawonload</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
