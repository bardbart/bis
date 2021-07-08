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
                <strong>Email:</strong>
                {{ $user->email }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Roles:</strong>
                @if(!empty($user->getRoleNames()))
                    @forelse($user->getRoleNames() as $v)

                        <label class="badge badge-success">{{ $v }}</label>
                    @empty
                        <label class="badge badge-secondary">No Role</label>
                    @endforelse
              
                    
                @endif
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permissions:</strong>
                @if(!empty($user->getPermissionNames()))
                    @forelse($user->getPermissionNames() as $p)

                        <label class="badge badge-success">{{ $p }}</label>
                    @empty
                        <label class="badge badge-secondary">No permissions</label>
                    @endforelse
              
                    
                @endif
            </div>
        </div>
    </div>


{{-- @endsection --}}