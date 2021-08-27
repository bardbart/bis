<x-layout>
    <style>
        .scroll {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
    @section('title', 'Home')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div style="background-color: rgb(253, 135, 155);" class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h4>{{ __('Welcome '. Auth::user()->firstName .'!') }}</h4>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success" >
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                    {{-- @role('Resident') --}}
                        <hr>
                        <h5 class="text-center">See your transactions for each module</h5>
                        {{-- Collapse Buttons --}}
                        <div class="d-flex justify-content-center">
                            {{-- <button class="btn btn-outline-primary me-2">All Transactions</button> --}}
                            <button class="btn btn-outline-primary me-2" data-bs-toggle="collapse" href="#documents" role="button" aria-expanded="false" aria-controls="documents">Requested Documents</button>
                            <button class="btn btn-outline-warning me-2" data-bs-toggle="collapse" href="#complaints" role="button" aria-expanded="false" aria-controls="complaints">Complaints Filed</button>
                            <button class="btn btn-outline-success me-2" data-bs-toggle="collapse" href="#blotters" role="button" aria-expanded="false" aria-controls="blotters">Blotters Filed</button>
                            <button class="btn btn-outline-danger me-2" data-bs-toggle="collapse" href="#xdocuments" role="button" aria-expanded="false" aria-controls="xdocuments">Cancelled Requests</button>
                        </div>
                        <hr>
                        <p><b>Results</b></p>
                        {{-- Collapse Items --}}
                        {{-- Documents Collapse --}}
                        <div class="collapse" id="documents">
                            <div class="card-header"><b>All Documents</b></div>
                            <div class="card card-body scroll">                               
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date Requested</th>
                                            <th>Document Type</th>
                                            <th>Purpose</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($documents->count() > 0)                                       
                                        @foreach ($documents as $docu)
                                        <tr>
                                            <td>{{ $docu->date }}</td>
                                            <td>{{ $docu->docType }}</td>
                                            <td>{{ $docu->purpose }}</td>
                                            @if ($docu->status == "Unpaid")
                                                <td class="text-danger"><b>{{ $docu->status }}</b></td>
                                                <td><button data-bs-toggle="modal" data-bs-target="#cancel{{ $docu->transId }}" class="btn btn-danger">Cancel</button></td>
                                                {{-- Cancel Reason Modal --}}
                                                <div class="modal fade" id="cancel{{ $docu->transId }}" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="cancelLabel">Cancellation</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="documents/process/{{ $docu->id }}/{{ $docu->transId }}/{{ $docu->userId }}" method="POST">
                                                                    <b>Reason for Cancelling</b><br>
                                                                    @csrf
                                                                    <div class="form-group my-1"> 
                                                                        <input type="radio"name="reason" value="Unable to go to Barangay Hall" onclick="cancelOthers{{ $docu->id }}()">
                                                                        <label>Not able to go to Barangay Hall</label>
                                                                    </div>

                                                                    <div class="form-group my-1"> 
                                                                        <input type="radio" name="reason" value="Existing Document" onclick="cancelOthers{{ $docu->id }}()">
                                                                        <label>Existing Document</label>
                                                                    </div>

                                                                    <div class="form-group my-1"> 
                                                                        <input type="radio" name="reason" value="Changed my mind" onclick="cancelOthers{{ $docu->id }}()">
                                                                        <label>Change my mind</label>
                                                                    </div>

                                                                    <div class="form-group my-1">
                                                                        <input type="radio" id="otherC{{ $docu->id }}" name="reason" value="Other" onclick="cancelOthers{{ $docu->id }}()">
                                                                        <label>Other</label>
                                                                    </div>  

                                                                    <div class="form-group my-1" style="display:none;" id="othersC{{ $docu->id }}">
                                                                        <label for="otherReason" class="my-1">Specify other reason:</label>
                                                                        <input type="text" class="form-control" id="otherReason" name="otherReason" placeholder="Input reason here...">
                                                                    </div>
                                                                    <div class="float-end my-1">
                                                                        <button type="submit" name="submit" value="cancel" onclick="return confirm('Are your sure to cancel request?')" class="btn btn-danger">Cancel Request</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- End of Process Reason Modal --}}
                                                <td class="text-warning"><b>{{ $docu->reason }}</b></td>
                                            @elseif($docu->status == "Disapproved")
                                                <td class="text-danger"><b>{{ $docu->status }}</b></td>
                                                <td><b>None</b></td>
                                                <td class="text-danger"><b>{{ $docu->reason }}</b></td>
                                            @else
                                                <td class="text-success"><b>{{ $docu->status }}</b></td>
                                                <td><b>None</b></td>
                                                <td class="text-success"><b>Done</b></td>
                                            @endif
                                        </tr>
                                        <script>
                                            function cancelOthers{{ $docu->id }}() {
                                                if (document.getElementById('otherC{{ $docu->id }}').checked) {
                                                    document.getElementById('othersC{{ $docu->id }}').style.display = 'block';
                                                }
                                                else document.getElementById('othersC{{ $docu->id }}').style.display = 'none';
                                            }
                                        </script>
                                        @endforeach
                                        @else
                                            <p style="color: rgb(255, 0, 0)">No available data</p>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Complaints --}}
                        <div class="collapse" id="complaints">
                            <div class="card-header"><b>All Filed Complaints</b></div>
                            <div class="card card-body scroll">       
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date Filed</th>
                                            {{-- <th>Complain Type</th> --}}
                                            {{-- <th>Complain Details</th> --}}
                                            <th>Respondents</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($complaints->count() > 0)   
                                        @foreach ($complaints as $comp)
                                        <tr>
                                            <td>{{ $comp->date }}</td>
                                            {{-- <td>{{ $comp->complainType }}</td> --}}
                                            {{-- <td>{{ $comp->compDetails }}</td> --}}
                                            <td>{{ $comp->respondents }}</td>
                                            @if ($comp->status == "Settled")
                                                <td class="text-success"><b>{{ $comp->status }}</b></td>
                                            @elseif ($comp->status == "Escalated")
                                                <td class="text-warning"><b>{{ $comp->status }}</b></td>
                                            @else
                                                <td class="text-danger"><b>{{ $comp->status }}</b></td>
                                            @endif 
                                            <td><a class="btn btn-primary my-2" href="complaints/show/{{ $comp->id }}/{{ $comp->userId }}">View</a></td>
                                        </tr>
                                        @endforeach
                                        @else
                                            <p style="color: rgb(255, 0, 0)">No available data</p>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                        {{-- Blotters --}}
                        <div class="collapse" id="blotters">
                            <div class="card-header"><b>All Filed Blotters</b></div>
                            <div class="card card-body scroll">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date Filed</th>
                                            <th>Blotter Details</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($blotters->count() > 0) 
                                        @foreach ($blotters as $blot)
                                        <tr>
                                            <td>{{ $blot->date }}</td>
                                            <td>{{ $blot->blotDetails }}</td>
                                            @if ($blot->status == "Unread")  
                                                <td class="text-danger"><b>{{ $blot->status }}</b></td>
                                            @else
                                                <td class="text-success"><b>{{ $blot->status }}</b></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        @else
                                            <p style="color: rgb(255, 0, 0)">No available data</p>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Cancelled Requests --}}
                        <div class="collapse" id="xdocuments">
                            <div class="card-header"><b>Cancelled Document Requests</b></div>
                            <div class="card card-body scroll">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date Requested</th>
                                            <th>Date Canceled</th>
                                            <th>Document Type</th>
                                            <th>Purpose</th>
                                            <th>Status</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($xdocus->count() > 0)                                       
                                        @foreach ($xdocus as $xdocu)
                                        <tr>
                                            <td>{{ $xdocu->date }}</td>
                                            <td>{{ $xdocu->cancelDate }}</td>
                                            <td>{{ $xdocu->docType }}</td>
                                            <td>{{ $xdocu->purpose }}</td>
                                            <td class="text-danger"><b>{{ $xdocu->status }}</b></td>
                                            <td class="text-danger"><b>{{ $xdocu->reason }}</b></td>
                                        </tr>
                                        @endforeach
                                        @else
                                            <p style="color: rgb(255, 0, 0)">No available data</p>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- @endrole     --}}
                        
                    </div>
                </div>
            </div>           
        </div>
    </div>
</x-layout>

