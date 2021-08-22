<x-layout>
    @section('title', 'Users')
    <x-section name="scripts">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    </x-section>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-start">
            <h2>Users Management</h2>
        </div>

        <div class="float-end">
            {{-- <a class="btn btn-success text-light" data-toggle="modal" id="extralargeButton" data-target="#extralargeModal"
            data-attr="{{ route('users.create') }}" title="create">
            <i class="fas fa-plus-circle" ></i>
           </a> --}}

           <a class="btn btn-success text-light" href="{{ route('users.create') }}"><i class="fas fa-plus-circle"></i></a>
        </div>
        
        <div class="float-end "style="padding-right: 50px;">
            <form style="display: inline" action="{{ route('users.index') }}" method="GET" role="search">
                <div class="input-group">
                    <span class="input-group-btn mr-5 mt-1">
                        <button class="btn btn-primary me-3 px-3" type="submit" title="Search user">
                            <span class="fas fa-search"></span>
                        </button>
                    </span>
                    <div class="form-outline">
                        <input size="30" type="text" class="form-control mr-2" name="term" placeholder="Search user" id="term">
                    </div>
                    <span class="input-group-btn mr-5 mt-1">
                        <a href="{{ route('users.index') }}" class=" mt-1">
                            <button class="btn btn-success ms-3 px-3 " type="button" title="Refresh page">
                                <span class="fas fa-sync-alt"></span>
                            </button>
                        </a>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif



<table class="table table-bordered table-responsive-lg table-hover" >
    <thead class="table-dark">
        <tr>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th width="150px">Action</th>
        </tr>
    </thead> 
    <tbody>
        @foreach ($data as $key => $user)

        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $user->lastName. ', ' .$user->firstName. ' ' .$user->middleName  }}</td>
            <td>{{ $user->email }}</td>
            <td>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    @if ($v == 'Admin')
                        <label class="badge bg-success">{{ $v }}</label>
                    @else
                        <label class="badge bg-secondary">{{ $v }}</label>
                    @endif
                @endforeach
            @endif
            </td>
            <td>
            {{-- <a  href="{{ route('users.show',$user->id) }}" ><i class="fas fa-eye text-success  fa-lg" ></i></a> --}}

            <a class="btn btn-link px-0" data-toggle="modal" id="mediumButton" data-target="#mediumModal"
            data-attr="{{ route('users.show', $user->id) }}" title="show">
            <i class="fas fa-eye fa-lg text-success"></i>
            </a>

            <a class="btn btn-link" data-toggle="modal" id="largeButton" data-target="#largeModal"
            data-attr="{{ route('users.edit', $user->id) }}" title="edit">
            <i class="fas fa-edit fa-lg"></i>
            </a>
            <!-- <a class="btn btn-link" href="{{ route('users.edit', $user->id) }}" ><i class="fas fa-edit fa-lg"></i></a> -->
            
            </a>
            
            {{-- <a href="{{ route('users.edit', $user->id) }}"><i class="fas fa-user-tag fa-lg" style="color: orange"></i></a> --}}
            {{-- <a href="{{ route('users.edit',$user->id) }}"><i class="fas fa-edit fa-lg"></i></a> --}}


            {{-- <button type="button" class="btn btn-success" id="myBtn">Role</button> --}}
            

                {{-- <a class="myBtn" href="#" ><i class="fas fa-user-tag fa-lg" style="color: orange"></i></a> --}}
                
                
            {{-- <a data-toggle="modal" id="largeButton" data-target="#largeModal"
            data-attr="{{ URL('/roles/edit', $user->id) }}" title="edit">
            <i class="fas fa-user-tag fa-lg" style="color: orange"></i>
            </a> --}}
            
            {{-- <a class="myBtn" href="#" ><i class="fas fa-user-cog fa-lg" ></i></a> --}}


            


            <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display:inline">
                    @csrf
                    @method('delete')
                    <button  class="btn btn-link px-0" onclick="return confirm('Are you sure you want to delete this user?')" type="submit"><i class="fas fa-trash-alt text-danger fa-lg" ></i></button>
                </form>

                {{-- {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!} --}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="float-end">{{ $data->links('pagination::bootstrap-4') }}</div>
<p class="text-center text-primary"><small>By Team Bard</small></p>


<!-- extra large modal -->
{{-- <div class="modal fade" id="extralargeModal" tabindex="-1" role="dialog" aria-labelledby="extralargeModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add User</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="extralargeBody">
            <div>
                <!-- the result to be displayed apply here -->       
            </div>
        </div>
    </div>
</div>
</div> --}}
<!-- large modal -->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit User</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="largeBody">
            <div>
                <!-- the result to be displayed apply here -->       
            </div>
        </div>
    </div>
</div>
</div>


<!-- medium modal -->
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Show User</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="mediumBody">
            <div>
                
            </div>
        </div>
    </div>
</div>
</div>


<script>
// display a modal (extra large modal)
// $(document).on('click', '#extralargeButton', function(event) {
//     event.preventDefault();
//     let href = $(this).attr('data-attr');
//     $.ajax({
//         url: href,
//         beforeSend: function() {
//             $('#loader').show();
//         },
//         // return the result
//         success: function(result) {
//             $('#extralargeModal').modal("show");
//             $('#extralargeBody').html(result).show();
//         },
//         complete: function() {
//             $('#loader').hide();
//         },
//         error: function(jqXHR, testStatus, error) {
//             console.log(error);
//             alert("Page " + href + " cannot open. Error:" + error);
//             $('#loader').hide();
//         },
//         timeout: 8000
//     })
// });
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

// Page http://127.0.0.1:8000/roles/19/edit cannot open. Error:Internal Server Error



// display a modal (medium modal)
$(document).on('click', '#mediumButton', function(event) {
    event.preventDefault();
    let href = $(this).attr('data-attr');
    $.ajax({
        url: href,
        beforeSend: function() {
            $('#loader').show();
        },
        // return the result
        success: function(result) {
            $('#mediumModal').modal("show");
            $('#mediumBody').html(result).show();
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


</script>
</x-layout>

