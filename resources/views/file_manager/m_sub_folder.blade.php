@extends('layouts.file_manager_app')

@section('content')
    <div class="container-fluid mt-3">
        @include('flash-message')
    </div>


    {{-- //Folder --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <a href="{{ route('folder_view', $m_sub_folder->folder_id) }}" class="btn bg-green"
                        style="width:150px;">Back</a>
                    <a href="#" class="btn bg-green" style="width:150px; float: right; " data-toggle="modal"
                        data-target="#fileModel"><strong>+</strong> Add File</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-primary">
                    <h3>{{ $m_sub_folder->folder_name }}</h3>
                </div>
                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-12">

                            <div class="row">
                                @foreach ($m_file as $row)
                                    @php
                                        // $enc = encrypt("$row->file_id");
                                        // $enc = base64_encode(Hash::make("$row->file_id"));
                                        // $m_user_id = Auth::user()->emp_id;
                                        // $user = base64_encode("$m_user_id");
                                        // $myurl = 'http://localhost/smartoffice_sqgroup';
                                        // $mainurl = "$myurl/$user/$enc";
                                    @endphp
                                    <div class="col-md-6 col-sm-6 col-lg-4 mb-2">
                                        <div class="card">
                                            <div class="text-right m-0">
                                                <a href="#" class="btn text-right"
                                                    style="color: white; margin-bottom: -25px;"
                                                    onclick='fhr("{{ $row->file_id }}")'>
                                                    <i class="fas fa-ellipsis-h" style="font-size: 20px;"></i>
                                                </a>
                                                <ul class="list-group text-center" id="fid_{{ $row->file_id }}"
                                                    style="display: none; margin-top: 15px;">
                                                    <li class="list-group-item"><a href="" data-toggle="modal"
                                                            data-target="#viewlink"
                                                            onclick='setFileID("{{ $row->file_id }}")'>Share</a></li>
                                                    <li class="list-group-item"><a
                                                            href="{{ route('file_delete', $row->file_id) }}">Delete</a></li>
                                                    <li class="list-group-item"><a
                                                            href="{{ route('fileDawonload', $row->file_id) }}">Dawonload</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body text-start">
                                                @php
                                                    if (strlen($row->file_name) > 20) {
                                                        $file_name = substr($row->file_name, 0, 20) . '...';
                                                    } else {
                                                        $file_name = $row->file_name;
                                                    }
                                                @endphp
                                                <a href="{{ url($row->myFile) }}" target="_blank" style="color: white;">
                                                    <i class="fas fa-file fa-lg" style="font-size: 30px;">
                                                        <small class="ml-1 text-lowercase" style="font-size: 20px;">
                                                            {{ $file_name }}
                                                        </small>
                                                    </i>

                                                </a>
                                            </div>
                                            <div class="card-footer">
                                                <small style="font-size: 15px;"> Date: {{ $row->entry_date }} &nbsp; Size:
                                                    {{ $row->file_size }}</small>
                                            </div>
                                        </div>
                                    </div><!-- /.col -->
                                @endforeach


                            </div><!-- /.row -->



                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.card body -->
            </div><!-- /.card -->
        </div><!-- /.container-fluid -->
    </div>


    <!-- File Model -->
    <div class="modal fade" id="fileModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('sub_file_store', $m_sub_folder->folder_sub_id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-2 mt-2">
                            <div class="col-12">
                                <input type="text" class="form-control" id="txt_file" name="txt_file"
                                    value="{{ old('txt_file') }}" placeholder="File Upload" onfocus="(this.type='file')">
                                @error('txt_file')
                                    <span class="text-warning">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                    </div> <!-- /.Body -->
                </form>
            </div>
        </div>
    </div>

  {{-- //Share Link Modal --}}
    <div class="modal fade" id="viewlink" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('send') }}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="txt_file_id" id="txt_file_id" />

                        <table id="parentTable" class="table table-borderless">
                            <tbody id="parentBody">
                                <tr>
                                    <td width="90%">
                                        <input type="email" class="form-control" name="email[]"
                                            placeholder="Share E-mail address" />
                                    </td>
                                   
                                    <td width="5%">
                                         <a class="btn btn-success" onclick="addTr()"><i class="fas fa-plus"></i></a>
                                    </td>

                                     <td width="5%">
                                        <a class="btn btn-danger" onclick="removeMe(this);"><i class="fas fa-minus"></i></a>
                                    </td>

                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-6 text-left">
                               
                            </div>
                            <div class="col-6 text-right">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>

                </div> <!-- /.Body data-dismiss="modal" -->
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function fhr(x) {
            $("#fid_" + x).toggle();
        }

        // function share(x) {
        //     if (x) {
        //         $("#txt_link").val(x);
        //     } else {
        //         $("#txt_link").val('');
        //     }
        // }

        function setFileID(x) {
            $("#txt_file_id").val('');
            $("#txt_file_id").val(x);
        }
    </script>

    <script>
        function addTr() {
            $('#parentBody').append(

                `<tr>
                    <td width="90%">
                        <input type="email" class="form-control" name="email[]"
                            placeholder="Share E-mail address" />
                    </td>
                   
                    <td width="5%">
                         <a class="btn btn-success" onclick="addTr()"><i class="fas fa-plus"></i></a>
                    </td>

                     <td width="5%">
                        <a class="btn btn-danger" onclick="removeMe(this);"><i class="fas fa-minus"></i></a>
                    </td>
                    
                </tr>`

            );
        }

        function removeMe(that) {
            $(that).closest('tr').remove();
        }
    </script>
@endsection
