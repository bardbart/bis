@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users Management</h2>
        </div>
        {{-- <div class="float-end">
            <a class="btn btn-success text-light" data-toggle="modal" id="largeButton" data-target="#largeModal"
            data-attr="{{ route('users.create') }}" title="create">
            <i class="fas fa-plus-circle" ></i>
           </a>
        </div> --}}
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif



<table class="table table-bordered table-responsive-lg table-hover" >
    <thead class="thead-dark">
        <tr>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th width="400px">Action</th>
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
                <label class="badge badge-success">{{ $v }}</label>
                @endforeach
            @endif
            </td>
            <td>
            {{-- <a href="{{ route('users.show',$user->id) }}" ><i class="fas fa-eye text-success  fa-lg" ></i></a> --}}

            <a data-toggle="modal" id="mediumButton" data-target="#mediumModal"
            data-attr="{{ route('users.show', $user->id) }}" title="show">
            <i class="fas fa-eye fa-lg" style="color: #db03fc"></i>
            </a>

            <a data-toggle="modal" id="largeButton" data-target="#largeModal"
            data-attr="{{ route('users.edit', $user->id) }}" title="edit">
            <i class="fas fa-user-tag fa-lg" style="color: orange"></i>
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
                    <button  class="btn btn-link" type="submit"><i class="fas fa-trash-alt text-danger fa-lg" ></i></button>
                </form>

                {{-- {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!} --}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


{!! $data->render() !!}


<p class="text-center text-primary"><small>By Team Bard</small></p>

<!-- large modal -->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
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
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="mediumBody">
            <div>
                
            </div>
        </div>
    </div>
</div>
</div>


<script>
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

@endsection

