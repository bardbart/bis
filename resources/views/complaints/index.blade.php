<x-layout>
  @section('title', 'Complaints')
  <div class="row">
      <div class="col-lg-12 margin-tb">
          <div class="pull-left">
              <h2>Complaint Management</h2>
          </div>
      </div>
  </div>

  @if ($message = Session::get('success'))
  <div class="alert alert-success" >
    <p>{{ $message }}</p>
  </div>
  @endif
  <div class="mx-auto float-end">
      <div class="">
            <form action="{{ route('complaints.index') }}" method="GET" role="search">

                <div class="input-group">
                    <span class="input-group-btn mr-5 mt-1">
                        <button class="btn btn-info me-3" type="submit" title="Search user">
                            <span class="fas fa-search"></span>
                        </button>
                    </span>
                    <input type="text" class="form-control mr-4" size="30" name="term" placeholder="Search user" id="term">
                    <a href="{{ route('complaints.index') }}" class=" mt-1">
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
  <table class="table table-bordered" >
      <thead class="table-dark">
          <tr>
          <th>No.</th>
          <th>Complainant</th>
          <th>Complainant's Address</th>
          <th>Respondent</th>
          <th>Respondent's Address</th>
          <th>Complaint Details</th>
          <th>Status</th>
          <th width="400px">Action</th>
          </tr>
      </thead>
      @foreach ($data as $comp)
          <tr>
              <td>{{ ++$i }}</td>
              <td>{{ $comp->firstName. ' ' .$comp->lastName }}</td>
              <td>{{ $comp->houseNo . ' ' . $comp->street . ' ' . $comp->city . ' ' . $comp->province }}</td>
              <td>{{ $comp->respondents }}</td>
              <td>{{ $comp->respondentsAdd }}</td>
              <td>
                  <button type="button" class="btn btn-info"  data-bs-toggle="modal" data-bs-target="#exampleModal{{$comp->id}}">Show Details</button>
              </td>
              <td>{{ $comp->status }}</td>
              <td>
                <div style="display: flex; flex-wrap: wrap; justify-content:space-around;">

                  @if ($comp->status == "Unsettled")
                    <a class="btn btn-success" href="complaints/settle/{{ $comp->id }}/{{ $comp->userId }}">Settle</a> 
                    <a class="btn btn-warning" href="complaints/escalate/{{ $comp->id }}/{{ $comp->userId }}">Escalate</a> 
                    <a class="btn btn-secondary" href="view-complaint-pdf/{{ $comp->id }}/{{ $comp->userId }}" target="_blank">View Complaint Form</a>
                    <a class="btn btn-primary" href="generate-complaint-pdf/{{ $comp->id }}/{{ $comp->userId }}">Save Complaint Form</a> 
                  @elseif ($comp->status == "Settled") 
                    <a class="btn btn-secondary" href="view-settle-pdf/{{ $comp->id }}/{{ $comp->userId }}" target="_blank">View Settle Form</a>
                    <a class="btn btn-primary" href="generate-settle-pdf/{{ $comp->id }}/{{ $comp->userId }}">Save Settle Form</a> 
                  @else
                    <a class="btn btn-secondary" href="view-escalate-pdf/{{ $comp->id }}/{{ $comp->userId }}" target="_blank">View Escalation Form</a>
                    <a class="btn btn-primary" href="generate-escalate-pdf/{{ $comp->id }}/{{ $comp->userId }}">Save Escalation Form</a> 
                  @endif
                </div>
                
              </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{$comp->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Complaint Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
  
                  <div class="modal-body">
                    <form>
                      <div class="form-group">
                          <textarea disabled class="form-control" id="message-text">{{ $comp->complainDetails }}</textarea>   
                      </div>
                    </form>
                  </div>
  
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </table>
  {{ $data->links('pagination::bootstrap-4') }}
  <p class="text-center text-primary"><small>By Team Bard</small></p>
</x-layout>



