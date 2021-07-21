<x-layout>
@section('title', 'Edit Officials')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-start">
                        <h2>Edit Official</h2>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-primary" href="{{ route('officials.index') }}">Back</a>
                    </div>
                </div>
            </div>
            <div class="card">

                <div class="card-header" style="background-color: rgb(253, 135, 155);">{{ __('Edit Official') }}</div>
    
                <div class="card-body">

                    <form method="POST" action="{{ route('officials.update', $officials->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 
                        <div class="form-group row my-1">
                            <label for="Image" class="col-sm-4 col-form-label text-md-right">{{ __('Image') }}</label>
                            
                            <div class="col-md-6">
                                <input type="file"  class="form-control @error('image') is-invalid @enderror" name="image">
                                
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-1">
                            <label for="lastName" class="col-sm-4 col-form-label text-md-right">{{ __('Last Name*') }}</label>
                            
                            <div class="col-md-6">
                                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ $officials->lastName }}" required autocomplete="lastName" autofocus>
                                
                                @error('lastName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row my-1">
                            <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name*') }}</label>
                            
                            <div class="col-md-6">
                                <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ $officials->firstName }}" required autocomplete="firstName" autofocus>
                                
                                @error('firstName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row my-1">
                            <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>
                            
                            <div class="col-md-6">
                                <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" value="{{ $officials->middleName }}" autocomplete="middleName" autofocus>
                                
                                @error('middleName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-1">
                            <div class="col-md-6 offset-md-4 ">
                                <button onclick="return confirm('Are your inputs correct?')" type="submit" class="btn btn-success" >
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    {{-- @if ($errors->any()) 
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    @endif --}}

                </div>
            </div>
        </div>
    </div>
</div>

</x-layout>