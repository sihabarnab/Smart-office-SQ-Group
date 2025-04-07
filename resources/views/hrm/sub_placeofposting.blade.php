@extends('layouts.hrm_app')
@section('content')
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Sub Place Of Posting</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <div class="container-fluid">
      @include('flash-message')
    </div>

    @if(session()->has('placeofposting_id'))
       @php
        $placeofposting_id = session('placeofposting_id');
       @endphp
    @else
       @php
        $placeofposting_id = '';
       @endphp
    @endif

  <div class="container-fluid">    
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
          <form method="post" action="{{ route('sub_placeofposting_store') }}">
            @csrf
            {{-- <div align="center" class=""> --}}

              <div class="row mb-2">
                  <div class="col-6">
                    <select name="cbo_posting" id="cbo_posting" class="form-control">
                      <option value="" >--Select Posting--</option>
                      @foreach ($m_placeofposting as $row_placeofposting)
                          <option value="{{ $row_placeofposting->placeofposting_id }}" {{$row_placeofposting->placeofposting_id == $placeofposting_id?"selected":""}}>
                              {{ $row_placeofposting->placeofposting_name }}
                          </option>
                      @endforeach
                    </select>
                    @error('cbo_posting')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-6">
                      <input type="text" name="txt_sub_posting" id="txt_sub_posting" class="form-control" value="{{old('txt_sub_posting')}}" placeholder="Sub Posting Name">
                      @error('txt_sub_posting')
                          <div class="text-warning">{{ $message }}</div>
                      @enderror
                  </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  
                </div>
                <div class="col-2">
                  <button type="submit"  class="btn btn-primary btn-block">Save</button>
                </div>
              </div>
            {{-- </div> --}}
          </form>
        </div>
      </div>
    </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="sub_posting_list" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Posting</th>
                                <th>Sub Posting</th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                         
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@section('script')
<script>
        $(document).ready(function() {
          //
           getSubPosting();
           //
           $('select[name="cbo_posting"]').on('change', function() {
             getSubPosting();
           });


        }); // end document

        function getSubPosting(posting_id){
          var posting_id = $('#cbo_posting').val();
          if(posting_id){
            var k = 1;
            $.ajax({
                url: "{{ url('/get/SubPosting_list') }}/"+posting_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                if ($.fn.DataTable.isDataTable("#sub_posting_list")) {
                    $('#sub_posting_list').DataTable().clear().destroy();
                  }

                    $('#sub_posting_list').dataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        dom: 'Blfrtip',
                        buttons: [{
                                extend: 'csvHtml5',
                                title: 'Sub Posting Information'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Sub Posting Information'
                                // orientation: 'landscape',
                                // pageSize: 'LEGAL'
                            },
                            {
                                extend: 'print',
                                title: 'Sub Posting Information',
                                autoPrint: true,
                                exportOptions: {
                                    columns: ':visible'
                                },
                            },
                            'colvis',
                        ],
                        "data": data,
                        "columns": [{
                                data: null,
                                render: function(data, type, full) {
                                    return k++;
                                }
                            },
                            {
                                "data": "placeofposting_name"
                            },
                            {
                                "data": "sub_placeofposting_name"
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return '<a href="{{ url('/') }}/hrm/sub_placeofposting_edit/' +
                                        data.placeofposting_sub_id +
                                        '" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>';
                                }
                            },
                        ], // end colume
                    }); // end dataTable
                }, // End Sucess
            }); // end Ajax
          }
        }
    </script>
@endsection