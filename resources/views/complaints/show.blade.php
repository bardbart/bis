<x-layout>
    @section('title', 'Complaint Details')
    <div class="container">
        <div class="row justify-content-center">
            
                <div class="col-sm-6">
                  <div class="card">
                    <div style="background-color: rgb(253, 135, 155);" class="card-header">Complaint Details</div>
                    <div class="card-body">
                      {{-- <h5 class="card-title"><b>Complainant:</b></h5> --}}
                        <p class="card-text"><b>Complainant:</b> {{ $data->firstName . ' ' . $data->lastName }}</p>
                        <p class="card-text"><b>Address:</b> {{ $data->address }}</p>
                        <p class="card-text"><b>Respondent(s):</b> {{ $data->respondents }}</p>
                        <p class="card-text"><b>Address:</b> {{ $data->respondentsAdd }}</p>
                        <p class="card-text"><b>Hearings/Summons:</b> 0 of 3</p>
                        <p class="card-text"><b>Status:</b> <b class="text-danger">{{ $data->status }}</b></p>
                        <button type="button" class="btn btn-warning"  data-bs-toggle="modal" data-bs-target="#exampleModal{{$data->id}}">Show Details</button>
                      <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Complaint Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                
                                <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <textarea disabled class="form-control" id="message-text">{{ $data->complainDetails }}</textarea>   
                                    </div>
                                </form>
                                </div>
                
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                            </div>
                        </div>
                     <!-- End of Modal -->    
                      <hr>
                      <a href="#" class="btn btn-success float-start">Record Hearing</a>
                      <a href="/complaints" class="btn btn-primary float-end">Back</a>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6" style="width: 400px">
                  <div class="card">
                    <div style="background-color: rgb(253, 135, 155);" class="card-header">Actions</div>
                    <div class="card-body">
                        <a class="btn btn-success my-2" href="complaints/settle/{{ $data->id }}/{{ $data->userId }}">Settle</a> 
                        {{-- <a class="btn btn-warning my-2" href="complaints/escalate/{{ $data->id }}/{{ $data->userId }}">Escalate</a>  --}}
                        <a class="btn btn-danger my-2" href="complaints/reject/{{ $data->id }}/{{ $data->userId }}">Dismiss</a> 
                        {{-- <a class="btn btn-secondary my-2" href="view-complaint-pdf/{{ $data->id }}/{{ $data->userId }}" target="_blank">View Complaint Form</a> --}}
                        <a class="btn btn-primary my-2" href="generate-complaint-pdf/{{ $data->id }}/{{ $data->userId }}">Save Complaint Form</a> 
                    </div>
                  </div>
                </div>
                      
        </div>
    </div>
</x-layout>

