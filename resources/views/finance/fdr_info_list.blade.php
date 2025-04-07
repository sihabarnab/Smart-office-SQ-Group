 <div class="container-fluid">
     <div class="row">
         <div class="col-12">
             <div class="card">
                 <div class="card-body">
                     <table id="data1" class="table table-bordered table-striped table-sm">
                         <thead>
                             <tr>
                                 <th>SL No</th>
                                 <th>Company<br>FDR Name</th>
                                 <th>Bank</th>
                                 <th> Branch</th>
                                 <th>FDR # & <br> Block #</th>
                                 <th>Issue <br> Maturity</th>
                                 <th>Period</th>
                                 <th>Principal <br> Rate</th>
                                 <th>Interest</th>
                                 <th>Tax</th>
                                 <th>Return</th>
                                 <th></th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($m_fdr_list as $key => $row)
                                 <tr>
                                     <td>{{ $key + 1 }}</td>
                                     <td>{{ $row->company_name }}<br>
                                        @if ($row->fdr_name == 1)
                                            {{ "A Z M Shofiuddin" }}
                                        @elseif($row->fdr_name == 2)
                                            {{ "Shohel Ahmed" }}
                                        @elseif($row->fdr_name == 3)
                                            {{ "A Z M Nurul Kader" }}
                                        @elseif($row->fdr_name == 4)
                                            {{ "Afroza Sultana" }}
                                        @elseif($row->fdr_name == 5)
                                            {{ "TS PROVIDENT FUND" }}
                                        @endif
                                     </td>
                                     <td>{{ $row->bank_name }}</td>
                                     <th> {{ $row->branch_name }}</td>
                                     <td>{{ $row->fdr_no }}<br> {{ $row->block_no }}</td>
                                     <td>{{ $row->issue_date }}<br> {{ $row->maturity_date }}</td>
                                     <td>{{ $row->period }}</td>
                                     <td>{{ $row->principal_amount }}<br> {{ $row->rate }}</td>
                                     <td>{{ $row->interest }}</td>
                                     <td>{{ $row->tax }}</td>
                                     <td>{{ $row->return_amount }}</td>
                                     <td> <a href="{{ route('fdr_info_edit', $row->fdr_id) }}">Edit</a></td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
 </div>
