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
  @if ($message = Session::get('danger'))
    <div class="alert alert-danger" >
      <p>{{ $message }}</p>
    </div>
  
  @endif
  <div class="mx-auto float-end">
      <div class="">
            <form action="{{ route('complaints.index') }}" method="GET" role="search">

                <div class="input-group">
                    <span class="input-group-btn mr-5 mt-1">
                        <button class="btn btn-primary me-3" type="submit" title="Search">
                            <span class="fas fa-search"></span>
                        </button>
                    </span>
                    <input type="text" class="form-control mr-4" size="30" name="term" placeholder="Search User Last Name" id="term">
                    <a href="{{ route('complaints.index') }}" class=" mt-1">
                        <span class="input-group-btn">
                            <button class="btn btn-success ms-3" type="button" title="Refresh Page">
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
          <th>Date Filed</th>
          <th>Complainant</th>
          {{-- <th>Complainant's Address</th> --}}
          <th>Respondent</th>
          {{-- <th>Respondent's Address</th> --}}
          {{-- <th>Complaint Details</th> --}}
          <th>Status</th>
          <th>Action</th>
          </tr>
      </thead>
    @if ($data->count() > 0)
      @foreach ($data as $comp)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $comp->date }}</td>
            <td>{{ $comp->firstName. ' ' .$comp->lastName }}</td>
            <td>{{ $comp->respondents }}</td>
            @if ($comp->status == "Settled") 
              <td class="text-success"><b>{{ $comp->status }}</b></td>
            @elseif ($comp->status == "Escalated" || $comp->status == "On Going")
              <td class="text-warning"><b>{{ $comp->status }}</b></td>
            @elseif ($comp->status == "Dismissed")
              <td class="text-danger"><b>{{ $comp->status }}</b></td>
            @else
              <td class="text-dark"><b>{{ $comp->status }}</b></td>
            @endif
            <td>
                <a class="btn btn-primary my-2" href="complaints/show/{{ $comp->id }}/{{ $comp->userId }}">View</a> 
            </td>
          </tr>
      @endforeach
    @else
      <h5 style="color: rgb(255, 0, 0)">No available data</h5> 
    @endif
  </table>
        <div class="float-end">{{ $data->links('pagination::bootstrap-4') }}</div>
  <p class="text-center text-primary"><small>By Team Bard</small></p>
</x-layout>



