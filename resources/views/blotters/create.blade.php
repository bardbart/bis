<x-layout>
    @section('title', 'File Blotter')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header" style="background-color: gray; color:white;">{{ __('File Blotter Form') }}</div>
        
                        <div class="card-body">
                            <form method="POST" action="{{ route('blotters.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="lastName" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="lastName" type="text" class="form-control" name="lastName" value="{{ Auth::user()->lastName }}" autofocus>
                                    </div>
                                </div>
            
                                <div class="form-group row">
                                    <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="firstName" type="text" class="form-control" name="firstName" value="{{ Auth::user()->firstName }}" autofocus>
                                    </div>
                                </div>
            
                                @if(!empty(Auth::User()->middleName))
                                    <div class="form-group row">
                                        <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>
                                        
                                        <div class="col-md-6">
                                            <input id="middleName" type="text" class="form-control" name="middleName" value="{{ Auth::user()->middleName }}" autofocus>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group row">
                                        <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('No Middle Name') }}</label>
                                    </div>
                                @endif
            
                                <div class="form-group row">
                                    <label for="houseNo" class="col-md-4 col-form-label text-md-right">{{ __('House Number') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="houseNo" type="text" class="form-control" name="houseNo" value="{{ Auth::user()->houseNo }}" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Street') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="street" type="text" class="form-control" name="street" value="{{ Auth::user()->street }}" autofocus>
                                    </div>
                                </div>
            
                                <div class="form-group row">
                                    <label for="province" class="col-md-4 col-form-label text-md-right">{{ __('Province') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="province" type="text" class="form-control" name="province" value="{{ Auth::user()->province }}" autofocus>
                                    </div>
                                </div>
            
                                <div class="form-group row">
                                    <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="city" type="text" class="form-control" name="city" value="{{ Auth::user()->city }}" autofocus>
                                    </div>
                                </div>
            
                                <div class="form-group row">
                                    <label for="citizenship" class="col-md-4 col-form-label text-md-right">{{ __('Citizenship') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="citizenship" type="text" class="form-control" name="city" value="{{ Auth::user()->citizenship }}" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="blotterDetails" class="col-md-4 col-form-label text-md-right">{{ __('Blotter Details') }}</label>
                                    
                                    <div class="col-md-6">
                                        <textarea class="form-control" name="blotterDetails" id="blotterDetails" cols="30" rows="10" placeholder="Enter details here..." required></textarea>
                                    </div>
                                </div>

                                @foreach ($smId as $id) 
                                    <input type="hidden" name="smId" value="{{ $id->id }}">
                                @endforeach

                                <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4 ">
                                        <button onclick="return confirm('Are your inputs correct?')" type="submit" class="btn btn-primary" >
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

