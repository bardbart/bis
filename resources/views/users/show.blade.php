{{-- @extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
    </div> --}}


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $user->firstName . ' ' . $user->lastName}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Contact Number:</strong>
                {{ '+63' . $user->contactNo}}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $user->email }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Role:</strong>
                @if(!empty($user->getRoleNames()))
                    @forelse($user->getRoleNames() as $v)

                        <label class="badge bg-success">{{ $v }}</label>
                    @empty
                        <label class="badge bg-secondary">No Role</label>
                    @endforelse
              
                    
                @endif
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permissions:</strong>
                @if(!empty($user->getPermissionNames()))
                    @forelse($user->getPermissionNames() as $p)

                        <label class="badge bg-success">{{ $p }}</label>
                    @empty
                        <label class="badge bg-secondary">No permissions</label>
                    @endforelse
              
                    
                @endif
            </div>
        </div>
    </div>


{{-- @endsection --}}