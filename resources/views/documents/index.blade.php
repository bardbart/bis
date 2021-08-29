<x-layout>

    <style>
        th{
            cursor: pointer;
        }
    </style>

    @section('title', 'Documents')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
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

    <div class="float-end" style="padding-right: 50px;">
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
    
    <table id="myTable2" class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
            <th onclick="sortTable(0)">No.</th>
            <th onclick="sortTable(1)">Name</th>
            <th onclick="sortTable(2)">Date Requested</th>
            <th onclick="sortTable(3)">Email</th>
            <th onclick="sortTable(4)">Document</th>
            <th onclick="sortTable(5)">Purpose</th>
            <th onclick="sortTable(6)">Barangay ID</th>
            <th onclick="sortTable(7)">Status</th>
            <th width="280px">Action</th>
            </tr>
        </thead>
    @if ($data->count() > 0)
        @foreach ($data as $trans)
            @if ($trans->docType != null)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $trans->firstName. ' ' .$trans->lastName}}</td>
                    <td>{{ $trans->date}}</td>
                    <td>{{ $trans->email }}</td>
                    <td>{{ $trans->docType }}</td>
                    <td>{{ $trans->purpose }}</td>
                    <td>
                        <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#bargyId{{$trans->id}}">Show ID</button>
                        <div class="modal fade" id="bargyId{{$trans->id}}" tabindex="-1" aria-labelledby="bargyIdLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bargyIdLabel">Barangay ID of {{ $trans->firstName. ' ' .$trans->lastName}}</h5>
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
                    </td>
                    @if ($trans->status == "Disapproved" || $trans->status == "Cancelled")
                        <td class="text-danger"><b>{{ $trans->status }}</b></td>
                    @elseif ($trans->status == "Unpaid")
                        <td class="text-warning"><b>{{ $trans->status }}</b></td>
                    @else
                        <td class="text-success"><b>{{ $trans->status }}</b></td>    
                    @endif
                    <td>
                        @if($trans->status == 'Unpaid')
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#process{{ $trans->id }}">Process</a>
                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#disapprove{{ $trans->id }}">Disapprove</a>
                        @elseif($trans->status == 'Ready to Claim')
                            <a class="btn btn-primary" href="documents/paid/{{ $trans->transId }}">Paid</a>
                            <a class="btn btn-secondary" href="documents/view-document-pdf/{{ $trans->id }}/{{ $trans->userId }}" target="_blank">View</a>
                            <a class="btn btn-success" href="documents/generate-document-pdf/{{ $trans->id }}/{{ $trans->userId }}">Save PDF</a>
                        @elseif($trans->status == 'Paid')
                            <a class="btn btn-secondary" href="documents/view-document-pdf/{{ $trans->id }}/{{ $trans->userId }}" target="_blank">View</a>
                            <a class="btn btn-success" href="documents/generate-document-pdf/{{ $trans->id }}/{{ $trans->userId }}">Save PDF</a>
                        @endif
                        {{-- Process Reason Modal --}}
                        <div class="modal fade" id="process{{ $trans->id }}" tabindex="-1" aria-labelledby="processLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="processLabel">Processing</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="documents/process/{{ $trans->id }}/{{ $trans->transId }}/{{ $trans->userId }}" method="POST">
                                            <b>Reason to Process</b><br>
                                            @csrf

                                            <div class="form-group my-1"> 
                                                <input type="radio" id="vId" name="reason" value="Valid ID" onclick="processOthers{{ $trans->id }}()">
                                                <label>Valid ID</label>
                                            </div>

                                            <div class="form-group my-1"> 
                                                <input type="radio" id="sp" name="reason" value="Sufficient Purpose" onclick="processOthers{{ $trans->id }}()">
                                                <label>Sufficient Purpose</label>
                                            </div>

                                            <div class="form-group my-1">
                                                <input type="radio" id="otherP{{ $trans->id }}" name="reason" value="Other" onclick="processOthers{{ $trans->id }}()">
                                                <label>Other</label>
                                            </div>  

                                            <div class="form-group my-1" style="display:none;" id="othersP{{ $trans->id }}">
                                                <label for="otherReason" class="my-1">Specify other reason:</label>
                                                <input type="text" class="form-control" id="otherReason" name="otherReason" placeholder="Input reason here...">
                                            </div>
                                            <div class="float-end my-1">
                                                <button type="submit" name="submit" value="process" onclick="return confirm('Are your sure to proceed?')" class="btn btn-primary">Save Reason</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End of Process Reason Modal --}}
                        {{-- Disapprove Reason Modal --}}
                        <div class="modal fade" id="disapprove{{ $trans->id }}" tabindex="-1" aria-labelledby="disapproveLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="disapproveLabel">Processing</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="documents/process/{{ $trans->id }}/{{ $trans->transId }}/{{ $trans->userId }}" method="POST">
                                            <b>Reason to Disapprove</b><br>
                                            @csrf

                                            <div class="form-group my-1"> 
                                                <input type="radio" id="vId" name="reason" value="Invalid ID" onclick="disapproveOthers{{ $trans->id }}()">
                                                <label>Invalid ID</label>
                                            </div>

                                            <div class="form-group my-1"> 
                                                <input type="radio" id="sp" name="reason" value="Inufficient Purpose" onclick="disapproveOthers{{ $trans->id }}()">
                                                <label>Insufficient Purpose</label>
                                            </div>

                                            <div class="form-group my-1">
                                                <input type="radio" id="otherD{{ $trans->id }}" name="reason" value="Other" onclick="disapproveOthers{{ $trans->id }}()">
                                                <label>Other</label>
                                            </div>  

                                            <div class="form-group my-1" style="display:none;" id="othersD{{ $trans->id }}">
                                                <label for="otherReason" class="my-1">Specify other reason:</label>
                                                <input type="text" class="form-control" id="otherReason" name="otherReason" placeholder="Input reason here...">
                                            </div>
                                            <div class="float-end my-1">
                                                <button type="submit" name="submit" value="disapprove" onclick="return confirm('Are your sure to proceed?')" class="btn btn-primary">Save Reason</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End of Disapprove Reason Modal --}}
                    </td>
                </tr>
                <script>
                    function processOthers{{ $trans->id }}() {
                        if (document.getElementById('otherP{{ $trans->id }}').checked) {
                            document.getElementById('othersP{{ $trans->id }}').style.display = 'block';
                        }
                        else document.getElementById('othersP{{ $trans->id }}').style.display = 'none';
                    }
                    
                    function disapproveOthers{{ $trans->id }}() {
                        if (document.getElementById('otherD{{ $trans->id }}').checked) {
                            document.getElementById('othersD{{ $trans->id }}').style.display = 'block';
                        }
                        else document.getElementById('othersD{{ $trans->id }}').style.display = 'none';
                    }
                </script>
            @endif
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
        // function toggle(value){
        //     if(value=='show') { document.getElementById('mytext').style.display='block'; }
        //     else { document.getElementById('mytext').style.display='none'; }
        // }

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




