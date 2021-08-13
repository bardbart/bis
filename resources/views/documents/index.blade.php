<x-layout>

    <style>
        th{
            cursor: pointer;
        }
    </style>

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
    @if ($message = Session::get('danger'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="mx-auto float-end">
        <div>
            <form action="{{ route('documents.index') }}" method="GET" role="search">

                <div class="input-group">
                    <span class="input-group-btn mr-5 mt-1">
                        <button class="btn btn-primary me-3" type="submit" title="Search">
                            <span class="fas fa-search"></span>
                        </button>
                    </span>
                    <input type="text" class="form-control mr-2" size="30" name="term" placeholder="Search User Last Name" id="term">
                    <a href="{{ route('documents.index') }}" class=" mt-1">
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
    <table id="myTable2" class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
            <th onclick="sortTable(0)">No.</th>
            <th onclick="sortTable(1)">Name</th>
            <th onclick="sortTable(2)">Email</th>
            <th onclick="sortTable(3)">Document</th>
            <th onclick="sortTable(4)">Purpose</th>
            <th onclick="sortTable(5)">Barangay ID</th>
            <th onclick="sortTable(6)">Status</th>
            <th width="280px">Action</th>
            </tr>
        </thead>
    @if ($data->count() > 0)
        @foreach ($data as $trans)
            @if ($trans->docType != null)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $trans->firstName. ' ' .$trans->lastName}}</td>
                    <td>{{ $trans->email }}</td>
                    <td>{{ $trans->docType }}</td>
                    <td>{{ $trans->purpose }}</td>
                    <td>
                        <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal{{$trans->id}}">Show ID</button>
                    </td>
                    @if ($trans->status == "Unpaid" || $trans->status == "Disapproved" || $trans->status == "Cancelled")
                        <td class="text-danger"><b>{{ $trans->status }}</b></td>
                    @else
                        <td class="text-success"><b>{{ $trans->status }}</b></td>    
                    @endif
                    <td>
                        @if($trans->status == 'Unpaid')
                            <a class="btn btn-primary"  onclick="return confirm('Are you sure to process the request?')" href="documents/process/{{ $trans->id }}/{{ $trans->userId }}">Process</a>
                            <a class="btn btn-danger" onclick="return confirm('Are you sure to disapprove the request?')" href="documents/disapprove/{{ $trans->id }}/{{ $trans->userId }}">Disapprove</a>
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
            @endif
            <div class="modal fade" id="exampleModal{{$trans->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Barangay ID of {{ $trans->firstName. ' ' .$trans->lastName}}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
    
                    <div class="modal-body" style="display: flex; justify-content:center">
                        <img style="margin:auto; width: 75%;"src="{{ asset('images/barangayId/'.$trans->barangayIdPath) }}" alt="brgyId" style="height: 300px">
                    </div>
    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
        @endforeach
    @else
        <h5 style="color: rgb(255, 0, 0)">No available data</h5> 
    @endif
    </table> 
    <div class="float-end">{{ $data->links('pagination::bootstrap-4') }}</div>
    <footer>
        <p class="text-center text-primary"><small>By Team Bard</small></p>
    </footer>
    
    <script>
        function sortTable(n) {
          var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
          table = document.getElementById("myTable2");
          switching = true;
          // Set the sorting direction to ascending:
          dir = "asc";
          /* Make a loop that will continue until
          no switching has been done: */
          while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
              // Start by saying there should be no switching:
              shouldSwitch = false;
              /* Get the two elements you want to compare,
              one from current row and one from the next: */
              x = rows[i].getElementsByTagName("TD")[n];
              y = rows[i + 1].getElementsByTagName("TD")[n];
              /* Check if the two rows should switch place,
              based on the direction, asc or desc: */
              if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                  // If so, mark as a switch and break the loop:
                  shouldSwitch = true;
                  break;
                }
              } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                  // If so, mark as a switch and break the loop:
                  shouldSwitch = true;
                  break;
                }
              }
            }
            if (shouldSwitch) {
              /* If a switch has been marked, make the switch
              and mark that a switch has been done: */
              rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
              switching = true;
              // Each time a switch is done, increase this count by 1:
              switchcount ++;
            } else {
              /* If no switching has been done AND the direction is "asc",
              set the direction to "desc" and run the while loop again. */
              if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
              }
            }
          }
        }
        </script>
</x-layout>




