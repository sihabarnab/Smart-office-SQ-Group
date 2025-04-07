@extends('layouts.finance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Fund Requsition Indent</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($m_fund_req_detail_edit))
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Edit' }}</h5>
                        </div>
                        <form action="{{ route('FinanceFundReqDetailUpdate', [$m_fund_req_detail_edit->fund_req_detail_id, $m_fund_req_detail_edit->company_id]) }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="hidden" class="form-control" id="cbo_company_id" name="cbo_company_id" readonly
                                        value="{{ $m_fund_req_detail_edit->company_id }}">

                                    <input type="text" class="form-control" id="txt_company_name" name="txt_company_name" readonly
                                        value="{{ $m_fund_req_detail_edit->company_name }}">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_fund_req_master_id" name="txt_fund_req_master_id" readonly
                                        value="{{ $m_fund_req_detail_edit->fund_req_master_id }}">
                                </div>
                                <div class="col-2">
                                    <input type="hidden" class="form-control" id="txt_fund_req_date" name="txt_fund_req_date" readonly
                                        value="{{ $m_fund_req_detail_edit->fund_req_date }}">

                                    <input type="text" class="form-control" id="txt_from_date" name="txt_from_date" readonly
                                        value="{{ $m_fund_req_detail_edit->req_form }}">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_to_date" name="txt_to_date" readonly
                                        value="{{ $m_fund_req_detail_edit->req_to }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="txt_description" name="txt_description"
                                        placeholder="Description / Particular's" value="{{ $m_fund_req_detail_edit->description }}">
                                    @error('txt_description')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_transfer" name="txt_transfer"
                                        placeholder="Transfer Amount" value="{{ $m_fund_req_detail_edit->req_transfer }}">
                                    @error('txt_transfer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_cash" name="txt_cash"
                                        placeholder="Cash Amount" value="{{ $m_fund_req_detail_edit->req_cash }}">
                                    @error('txt_cash')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_chq" name="txt_chq"
                                        placeholder="Bank Amount" value="{{ $m_fund_req_detail_edit->req_chq }}">
                                    @error('txt_chq')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_remarks" name="txt_remarks"
                                        placeholder="Remarks" value="{{ $m_fund_req_detail_edit->remarks }}">
                                    @error('txt_remarks')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-2"></div>
                                <div class="col-8">

                                </div>
                                <div class="col-2">
                                   
                                    <button type="submit" class="form-control  bg-primary">Update</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form action="{{ route('FinanceFundReqDetailStore', $m_pro_fund_req_master->company_id) }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="hidden" class="form-control" id="cbo_company_id" name="cbo_company_id" readonly
                                        value="{{ $m_pro_fund_req_master->company_id }}">

                                    <input type="text" class="form-control" id="txt_company_name" name="txt_company_name" readonly
                                        value="{{ $m_pro_fund_req_master->company_name }}">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_fund_req_master_id" name="txt_fund_req_master_id" readonly
                                        value="{{ $m_pro_fund_req_master->fund_req_master_id }}">
                                </div>
                                <div class="col-2">
                                    <input type="hidden" class="form-control" id="txt_fund_req_date" name="txt_fund_req_date" readonly
                                        value="{{ $m_pro_fund_req_master->fund_req_date }}">

                                    <input type="text" class="form-control" id="txt_from_date" name="txt_from_date" readonly
                                        value="{{ $m_pro_fund_req_master->req_form }}">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_to_date" name="txt_to_date" readonly
                                        value="{{ $m_pro_fund_req_master->req_to }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="txt_description" name="txt_description"
                                        placeholder="Description / Particular's" value="{{ old('txt_description') }}">
                                    @error('txt_description')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_transfer" name="txt_transfer"
                                        placeholder="Transfer Amount" value="{{ old('txt_transfer') }}">
                                    @error('txt_transfer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_cash" name="txt_cash"
                                        placeholder="Cash Amount" value="{{ old('txt_cash') }}">
                                    @error('txt_cash')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_chq" name="txt_chq"
                                        placeholder="Bank Amount" value="{{ old('txt_chq') }}">
                                    @error('txt_chq')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_remarks" name="txt_remarks"
                                        placeholder="Remarks" value="{{ old('txt_remarks') }}">
                                    @error('txt_remarks')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-8"></div>
                                <div class="col-2">
                                    <button type="submit" class="form-control btn  bg-primary">Add Another</button>
                                </div>
                                <div class="col-2">
                                
                                    <a href="{{ route('FinanceFundReqDetailFinal', [$m_pro_fund_req_master->fund_req_master_id, $m_pro_fund_req_master->company_id]) }}" class="form-control btn bg-primary">Final</a>
                                    
                                    
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('finance.fund_req_detail_list')
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var fff = "{{$errors->first('txt_fund_req_detail_file')}}";
            if (fff) {
                var element = document.querySelector(".ctm_anim");
                if (element) {
                    element.classList.remove("ctm_anim");
                }
                $('#FileUpModal').modal('show');
              
            }
            
        });

        function showPDF(pdf) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }

            $('#showPdf').attr('src', '');
            if (pdf) {
                $('#showPdf').attr('src', pdf);
            } else {
                $('#showPdf').attr('src', '');
            }

        }

        function OkFunction(company_id, fund_req_detail_id) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }

            $('#txt_company_id').val('');
            $('#txt_fund_req_detail_id').val('');

            $('#txt_company_id').val(company_id);
            $('#txt_fund_req_detail_id').val(fund_req_detail_id);

        }
    </script>
@endsection
