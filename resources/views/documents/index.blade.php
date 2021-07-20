<x-layout>
    @section('title', 'Documents')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Documents Management</h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
        <p>{{ $message }}</p>
        </div>
    @endif
    <div class="mx-auto float-end">
            <div class="">
                <form action="{{ route('documents.index') }}" method="GET" role="search">

                    <div class="input-group">
                        <span class="input-group-btn mr-5 mt-1">
                            <button class="btn btn-info me-3" type="submit" title="Search user">
                                <span class="fas fa-search"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control mr-2" size="30" name="term" placeholder="Search user" id="term">
                        <a href="{{ route('documents.index') }}" class=" mt-1">
                            <span class="input-group-btn">
                                <button class="btn btn-danger ms-3" type="button" title="Refresh page">
                                    <span class="fas fa-sync-alt"></span>
                                </button>
                            </span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Document</th>
            <th>Purpose</th>
            <th>Barangay ID</th>
            <th>Status</th>
            <th width="280px">Action</th>
            </tr>
        </thead>
        @foreach ($data as $trans)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $trans->firstName. ' ' .$trans->lastName}}</td>
                <td>{{ $trans->email }}</td>
                <td>{{ $trans->docType }}</td>
                <td>{{ $trans->purpose }}</td>
                <td>
                    <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal{{$trans->id}}">Show ID</button>
                </td>
                <td>{{ $trans->status }}</td>
                <td>
                    @if($trans->status == 'Unpaid')
                        <a class="btn btn-primary" href="documents/process/{{ $trans->id }}/{{ $trans->userId }}">Process</a>
                    @elseif($trans->status == 'Ready to Claim')
                        <a class="btn btn-primary" href="documents/paid/{{ $trans->id }}/{{ $trans->userId }}">Paid</a>
                        <a class="btn btn-secondary" href="view-document-pdf/{{ $trans->id }}/{{ $trans->userId }}" target="_blank">View</a>
                        <a class="btn btn-success" href="generate-document-pdf/{{ $trans->id }}/{{ $trans->userId }}">Save PDF</a>
                    @elseif($trans->status == 'Paid')
                        <a class="btn btn-secondary" href="view-document-pdf/{{ $trans->id }}/{{ $trans->userId }}" target="_blank">View</a>
                        <a class="btn btn-success" href="generate-document-pdf/{{ $trans->id }}/{{ $trans->userId }}">Save PDF</a>
                    @endif
                </td>
            </tr>
            <div class="modal fade" id="exampleModal{{$trans->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Barangay ID of {{ $trans->firstName. ' ' .$trans->lastName}}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
    
                    <div class="modal-body" style="margin: 0px 0px 0px 80px; width: 50%; ">
                        <img src="{{ asset('images/barangayId/'.$trans->barangayIdPath) }}" alt="brgyId" style="height: 300px">
                    </div>
    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
        @endforeach
    </table>
    <div class="float-end">{{ $data->links('pagination::bootstrap-4') }}</div>
    <p class="text-center text-primary"><small>By Team Bard</small></p>
    
</x-layout>




