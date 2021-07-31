<x-layout>
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
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success" >
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <h4>{{ __('Welcome '. Auth::user()->firstName .'!') }}</h4>

                    @role('User')
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
                            <div class="card card-body">                               
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date Requested</th>
                                            <th>Document Type</th>
                                            <th>Purpose</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
                                                <form action="{{ route('home.destroy', $docu->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <td><button onclick="return confirm('Are you sure you want to cancel?')" class="btn btn-danger">Cancel</button></td>
                                                </form>
                                            @elseif($docu->status == "Disapproved")
                                                <td class="text-danger"><b>{{ $docu->status }}</b></td>
                                                <td><b>None</b></td>
                                            @else
                                                <td class="text-success"><b>{{ $docu->status }}</b></td>
                                                <td><b>None</b></td>
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
                        {{-- Complaints --}}
                        <div class="collapse" id="complaints">
                            <div class="card-header"><b>All Filed Complaints</b></div>
                            <div class="card card-body">
                                
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date Filed</th>
                                                <th>Complain Type</th>
                                                <th>Complain Details</th>
                                                <th>Respondents</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($complaints->count() > 0)   
                                            @foreach ($complaints as $comp)
                                            <tr>
                                                <td>{{ $comp->date }}</td>
                                                <td>{{ $comp->complainType }}</td>
                                                <td>{{ $comp->complainDetails }}</td>
                                                <td>{{ $comp->respondents }}</td>
                                                @if ($comp->status == "Settled")
                                                    <td class="text-success"><b>{{ $comp->status }}</b></td>
                                                @elseif ($comp->status == "Escalated")
                                                    <td class="text-warning"><b>{{ $comp->status }}</b></td>
                                                @else
                                                    <td class="text-danger"><b>{{ $comp->status }}</b></td>
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
                        {{-- Blotters --}}
                        <div class="collapse" id="blotters">
                            <div class="card-header"><b>All Filed Blotters</b></div>
                            <div class="card card-body">
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
                                            <td>{{ $blot->blotterDetails }}</td>
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
                        <div class="collapse" id="xdocuments">
                            <div class="card-header"><b>Cancelled Document Requests</b></div>
                            <div class="card card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date Requested</th>
                                            <th>Date Canceled</th>
                                            <th>Document Type</th>
                                            <th>Purpose</th>
                                            <th>Status</th>
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
                    @endrole    
                        
                    </div>
                </div>
            </div>           
        </div>
    </div>
{{-- <script>
$(document).ready(function(){
    $(document).on('click','.pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    function fetch_data(page)
    {
        $.ajax({
            url:"/home/fetch_data?page="+page,
            success:function(data)
            {
                $('#table_data').html(data);
            }
        });
    }
});
</script> --}}
</x-layout>

