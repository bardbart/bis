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
          <th>Complainant</th>
          <th>Complainant's Address</th>
          <th>Respondent</th>
          <th>Respondent's Address</th>
          <th>Complaint Details</th>
          <th>Status</th>
          <th width="280px">Action</th>
          </tr>
      </thead>
      @foreach ($data as $comp)
          <tr>
              <td>{{ $comp->id }}</td>
              <td>{{ $comp->name }}</td>
              <td>{{ $comp->address }}</td>
              <td>{{ $comp->respondents }}</td>
              <td>{{ $comp->respondentsAdd }}</td>
              <td>
                  {{-- <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">Show</button> --}}
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Show
                  </button>
              </td>
              <td>{{ $comp->status }}</td>
              <td>
                  <a class="btn btn-outline-danger" href="view-complaint-pdf/{{ $comp->userId }}">View</a>
                  <a class="btn btn-outline-success" href="generate-complaint-pdf/{{ $comp->userId }}">Save PDF</a> 
              </td>
          </tr>
  </table>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  
  
  <p class="text-center text-primary"><small>By Team Bard</small></p>
  
  
  {{-- <script>
      // display a modal (large modal)
      $(document).on('click', '#largeButton', function(event) {
          event.preventDefault();
          let href = $(this).attr('data-attr');
          $.ajax({
              url: href,
              beforeSend: function() {
                  $('#loader').show();
              },
              // return the result
              success: function(result) {
                  $('#largeModal').modal("show");
                  $('#largeBody').html(result).show();
              },
              complete: function() {
                  $('#loader').hide();
              },
              error: function(jqXHR, testStatus, error) {
                  console.log(error);
                  alert("Page " + href + " cannot open. Error:" + error);
                  $('#loader').hide();
              },
              timeout: 8000
          })
      });
  </script> --}}
</x-layout>



