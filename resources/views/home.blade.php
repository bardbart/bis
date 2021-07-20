<x-layout>
    @section('title', 'Home')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
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
                        {{-- Collapse Buttons --}}
                        <div class="d-flex justify-content-center">
                            {{-- <button class="btn btn-outline-primary me-2">All Transactions</button> --}}
                            <button class="btn btn-outline-primary me-2" data-bs-toggle="collapse" href="#documents" role="button" aria-expanded="false" aria-controls="documents">Requested Documents</button>
                            <button class="btn btn-outline-danger me-2" data-bs-toggle="collapse" href="#complaints" role="button" aria-expanded="false" aria-controls="complaints">Complaints Filed</button>
                            <button class="btn btn-outline-success me-2" data-bs-toggle="collapse" href="#blotters" role="button" aria-expanded="false" aria-controls="blotters">Blotters Filed</button>
                        </div>
                        <hr>
                        <p><b>Results</b></p>
                        {{-- Collapse Items --}}
                        {{-- Documents Collapse --}}
                        <div class="collapse" id="documents">
                            <div class="card-header">All Documents</div>
                            <div class="card card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Document Type</th>
                                            <th>Purpose</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documents as $docu)
                                        <tr>
                                            <td>{{ $docu->date }}</td>
                                            <td>{{ $docu->docType }}</td>
                                            <td>{{ $docu->purpose }}</td>
                                            <td>{{ $docu->status }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Complaints --}}
                        <div class="collapse" id="complaints">
                            <div class="card-header">All Filed Complaints</div>
                            <div class="card card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Complain Type</th>
                                            <th>Complain Details</th>
                                            <th>Respondents</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($complaints as $comp)
                                        <tr>
                                            <td>{{ $comp->date }}</td>
                                            <td>{{ $comp->complainType }}</td>
                                            <td>{{ $comp->complainDetails }}</td>
                                            <td>{{ $comp->respondents }}</td>
                                            <td>{{ $comp->status }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                        {{-- Blotters --}}
                        <div class="collapse" id="blotters">
                            <div class="card-header">All Filed Blotters</div>
                            <div class="card card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Blotter Details</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($blotters as $blot)
                                        <tr>
                                            <td>{{ $blot->date }}</td>
                                            <td>{{ $blot->blotterDetails }}</td>
                                            <td>{{ $blot->status }}</td>
                                        </tr>
                                        @endforeach
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
</x-layout>

