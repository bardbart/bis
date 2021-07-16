<x-layout>
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
    <table class="table table-bordered" >
        <thead class="table-dark">
            <tr>
            <th>Transaction No.</th>
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
                <td>{{ $trans->id }}</td>
                <td>{{ $trans->name}}</td>
                <td>{{ $trans->email }}</td>
                <td>{{ $trans->docType }}</td>
                <td>{{ $trans->purpose }}</td>
                <td>
                    <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal{{$trans->id}}">Show ID</button>
                </td>
                <td>{{ $trans->status }}</td>
                <td>
                    @if($trans->status == 'Paid')
                        <a class="btn btn-danger" href="view-document-pdf/{{ $trans->id }}/{{ $trans->userId }}" target="_blank">View</a>
                        <a class="btn btn-success" href="generate-document-pdf/{{ $trans->id }}/{{ $trans->userId }}">Save PDF</a>
                    @else
                        <a class="btn btn-primary" href="{{ url('documents/process/'.$trans->id.'/'.$trans->userId) }}">Process</a>
                    @endif
                </td>
            </tr>
            <div class="modal fade" id="exampleModal{{$trans->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Barangay ID of {{ $trans->name }}</h5>
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
    <p class="text-center text-primary"><small>By Team Bard</small></p>
</x-layout>





