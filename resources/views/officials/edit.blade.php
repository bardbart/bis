<x-layout>
@section('title', 'Edit Official')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header" style="background-color: gray; color:white;">{{ __('Edit Officials') }}</div>
    
                <div class="card-body">

                    <form method="POST" action="{{ route('officials.update', $officials->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 
                        <div class="form-group row">
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

                        <div class="form-group row">
                            <label for="lastName" class="col-sm-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                            
                            <div class="col-md-6">
                                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ $officials->lastName }}" required autocomplete="lastName" autofocus>
                                
                                @error('lastName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                            
                            <div class="col-md-6">
                                <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ $officials->firstName }}" required autocomplete="firstName" autofocus>
                                
                                @error('firstName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
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
                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>
                            
                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ $officials->position }}" autocomplete="position" autofocus>
                                
                                @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 ">
                                <button  type="submit" class="btn btn-primary" >
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</x-layout>