<x-layout>
    @section('title', 'Complaint Details')
    <div class="container">
        <div class="row justify-content-center">
          @if ($message = Session::get('success'))
            <div class="alert alert-success" >
              <p>{{ $message }}</p>
            </div>
           @endif
          <div class="col-sm-6">
              <div class="card">
                <div style="background-color: rgb(253, 135, 155);" class="card-header">Complaint Details</div>
                <div class="card-body">
                  {{-- <h5 class="card-title"><b>Complainant:</b></h5> --}}
                    <p class="card-text"><b>Date Filed:</b> {{ Carbon\Carbon::parse($td->date)->format('jS F, Y') }} </p>
                    <p class="card-text"><b>Complainant:</b> {{ $td->firstName . ' ' . $td->lastName }}</p>
                    <p class="card-text"><b>Address:</b> {{ $td->houseNo. ', ' .$td->street}}</p>
                    <p class="card-text"><b>Respondent(s):</b> {{ $td->respondents }}</p>
                    <p class="card-text"><b>Address:</b> {{ $td->respondentsAdd }}</p>
                    <p class="card-text"><b>Hearings/Summons:</b> {{ $hearingCounts }} of 3</p>
                    <p class="card-text"><b>Status:</b>
                    @if ($td->status == "Settled") 
                      <b class="text-success">{{ $td->status }}</b>
                    @elseif ($td->status == "Escalated" || $td->status == "On Going")
                      <b class="text-warning">{{ $td->status }}</b>
                    @elseif ($td->status == "Dismissed")
                      <b class="text-danger">{{ $td->status }}</b>
                    @else
                      <b class="text-dark">{{ $td->status }}</b>
                    @endif
                    </p>
                    <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#compDetails{{$td->id}}">Show Complain Details</button>
                  <!-- Modal -->
                    <div class="modal fade" id="compDetails{{$td->id}}" tabindex="-1" aria-labelledby="compDetailsLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="compDetailsLabel">Complaint Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
            
                            <div class="modal-body">
                              {{-- <form>
                                  <div class="form-group">
                                      <textarea readonly class="form-control" id="message-text" rows="10">{{ $td->compDetails }}</textarea>   
                                  </div>
                              </form> --}}
                              <b>Hearing Details:</b><br>
                              <p>{{ $td->compDetails }}</p>
                            </div>
            
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>
                  <!-- End of Modal -->    
                  <hr>
                  <a class="btn @if ( $hearingCounts == 3 || $td->status == 'Dismissed' || $td->status == 'Escalated' || $td->status == 'Settled') return disabled @endif btn-success float-start" data-bs-toggle="modal" data-bs-target="#record-hearing">Record Hearing</a>
                  <a onclick="history.back()" class="btn btn-primary float-end">Back</a>
                </div>
              </div>
              {{-- Modal for Record Hearing --}}
              <div class="modal fade" id="record-hearing" tabindex="-1" aria-labelledby="recordhearingLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="recordhearingLabel">Hearing Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="/complaints/show/hearing/{{ $td->id }}/{{ $td->transId }}">
                        @csrf
                        <div class="my-1">
                          <label for="details" class="col-form-label"><b>Input Hearing Details:</b></label>
                          <textarea class="form-control summernote" name="details" id="details" rows="10" placeholder="Input details here..."></textarea>
                        </div>
                        <div class="float-end my-3">
                          <button type="submit" class="btn btn-primary">Save Details</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              {{-- End of Modal --}}
            </div>
            <div class="col-sm-6" style="width: 400px">
              <div class="card">
                <div style="background-color: rgb(253, 135, 155);" class="card-header">Actions</div>
                <div class="card-body">
                  <h5 class="card-title">Status</h5>
                  @if ($td->status == "Settled")
                    <a class="btn btn-secondary my-2" href="/view-settle-pdf/{{ $td->id }}/{{ $td->userId }}" target="_blank">View Settle Form</a><br>
                    <a class="btn btn-primary my-2" href="/generate-settle-pdf/{{ $td->id }}/{{ $td->userId }}">Save Settle Form</a><br>
                  @elseif ($td->status == "Escalated")
                    <a class="btn btn-secondary my-2" href="/view-escalate-pdf/{{ $td->id }}/{{ $td->userId }}" target="_blank">View Escalation Form</a><br>
                    <a class="btn btn-primary my-2" href="/generate-escalate-pdf/{{ $td->id }}/{{ $td->userId }}">Save Escalation Form</a><br>
                  @elseif ($td->status == "Dismissed") 
                    <b class="text-danger">No Actions Required</b>
                  @elseif ($hearingCounts == 3)
                    @role('Admin')
                      <a class="btn btn-outline-success my-2" title="Settle the Complaint" href="/complaints/show/settle/{{ $td->transId }}">Settle</a>
                      <a class="btn btn-outline-warning my-2" title="Escalate the Complaint" href="/complaints/show/escalate/{{ $td->transId }}">Escalate</a>
                      <a class="btn btn-outline-danger my-2" title="Dismiss the Complaint" href="/complaints/show/reject/{{ $td->transId }}">Dismiss</a><br>
                    @endrole 
                    <a class="btn btn-outline-primary my-2" href="/complaints/show/view-complaint-pdf/{{ $td->id }}/{{ $td->userId }}" target="_blank">View Complaint Form</a><br> 
                    <a class="btn btn-outline-secondary my-2" href="/complaints/show/generate-complaint-pdf/{{ $td->id }}/{{ $td->userId }}">Save Complaint Form</a><br> 
                  @else
                    @role('Admin')
                      <a class="btn btn-outline-success my-2" title="Settle the Complaint" href="/complaints/show/settle/{{ $td->transId }}">Settle</a> 
                      <a class="btn btn-outline-danger my-2" title="Dismiss the Complaint" href="/complaints/show/dismiss/{{ $td->transId }}">Dismiss</a><br>
                    @endrole 
                    <a class="btn btn-outline-primary my-2" href="/complaints/show/view-complaint-pdf/{{ $td->id }}/{{ $td->userId }}" target="_blank">View Complaint Form</a><br> 
                    <a class="btn btn-outline-secondary my-2" href="/complaints/show/generate-complaint-pdf/{{ $td->id }}/{{ $td->userId }}">Save Complaint Form</a><br> 
                  @endif
                  <hr>
                  <h5 class="card-title">Hearing Details</h5>
                  @if($hearingCounts == 0)
                    <b class="text-danger">No Hearings Conducted</b><br>
                  @endif
                  @for ($ctr = 1; $ctr <= $hearingCounts; $ctr++)
                    <button type="button" class="btn btn-outline-info my-2" data-bs-toggle="modal" data-bs-target="#hearing-{{$ctr}}">Hearing No. {{ $ctr }}</button><br>
                      <!-- Hearing View Modal -->
                      <div class="modal fade" id="hearing-{{$ctr}}" tabindex="-1" aria-labelledby="hearingLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="hearingLabel">Hearing No. {{ $ctr }} Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>          
                          <div class="modal-body">
                            {{-- <form>
                                <div class="form-group">
                                    <textarea readonly class="form-control" id="message-text" rows="10">{{ $hearings[$ctr - 1] }}</textarea>   
                                </div>
                            </form> --}}
                            <b>Hearing Details:</b><br>
                            <p>{{ $hearings[$ctr - 1]->details }}</p><br>
                            <b>Date Hearing Recorded:</b><br>
                            <p>{{ Carbon\Carbon::parse($hearings[$ctr - 1]->date)->format('jS F, Y')}}</b>
                          </div>          
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                      </div>
                    <!-- End of Hearing View Modal -->
                  @endfor
                </div>
              </div>
            </div>              
        </div>
    </div>
</x-layout>