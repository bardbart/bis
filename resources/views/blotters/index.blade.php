<x-layout>
  @section('title', 'Blotters')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Blotters Management</h2>
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
                <th>Reporter</th>
                <th>Reporter's Address</th>
                <th>Blotter Details</th>
                <th>Status</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        @foreach ($data as $blot)
            <tr>
                <td>{{ $blot->id }}</td>
                <td>{{ $blot->name }}</td>
                <td>{{ $blot->address }}</td>
                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $blot->id }}">Show</button>
                </td>
                <td>{{ $blot->status }}</td>
                <td>
                  @if ($blot->status == "Noted")
                    <a class="btn disabled btn-success" href="blotters/note/{{ $blot->id }}/{{ $blot->userId }}">Note</a>
                  @else
                    <a class="btn btn-success" href="blotters/note/{{ $blot->id }}/{{ $blot->userId }}">Note</a> 
                  @endif
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{ $blot->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Blotter Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="form-group">
                          <textarea disabled class="form-control" id="message-text">{{ $blot->blotterDetails }}</textarea>   
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
  
  
  
  