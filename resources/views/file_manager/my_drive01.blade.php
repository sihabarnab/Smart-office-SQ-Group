@extends('layouts.file_manager_app')

@section('content')
    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $m_user_id = Auth::user()->emp_id;
        $m_folder = DB::table('pro_folder')
            ->where('user_id', $m_user_id)
            ->where('valid', 1)
            ->get();
        $m_file = DB::table('pro_file')
            ->where('user_id', $m_user_id)
            ->where('folder_id', null)
            ->get();
    @endphp

    {{-- //Folder --}}



    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <a href="#" class="btn bg-green" style="width:150px;" data-toggle="modal"
                        data-target="#folderModel"><strong>+</strong> Folder</a>
                    <a href="#" class="btn bg-green" style="width:150px;" data-toggle="modal"
                        data-target="#fileModel"><strong>+</strong> File</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-primary m-0">
                    <h3>My Drive</h3>
                </div>
                <div class="card-body">


                    
                
                </div><!-- /.card body -->
            </div><!-- /.card -->
        </div><!-- /.container-fluid -->
    </div>



    <!-- Folder Model -->
    <div class="modal fade" id="folderModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('folder_store') }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-2 mt-2">
                            <div class="col-12">
                                <input type="text" class="form-control" name="txt_folder" id="txt_folder"
                                    value="{{ old('txt_folder') }}" placeholder="Folder Name">
                                @error('txt_folder')
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

                    </div> <!-- /.Body-->
                </form>
            </div>
        </div>
    </div>

    <!-- File Model -->
    <div class="modal fade" id="fileModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('file_store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-2 mt-2">
                            <div class="col-12">
                                <input type="text" class="form-control" id="txt_file" name="txt_file"
                                    value="{{ old('txt_file') }}" placeholder="File Upload"
                                    onfocus="(this.type='file')">
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="row mb-2 mt-2">
                        <div class="col-12 mb-2">
                            <textarea class="form-control" name="txt_link" id="txt_link" placeholder="URL" cols="10" rows="5"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div> <!-- /.Body -->
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function shr(x) {
            $("#id_" + x).toggle();
        }

        function fhr(x) {
            $("#fid_" + x).toggle();
        }

        function share(x) {
            if (x) {
                $("#txt_link").val(x);
            } else {
                $("#txt_link").val('');
            }
        }
    </script>
@endsection
