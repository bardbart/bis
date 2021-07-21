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
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="float-start">
                            <h2>File Blotter</h2>
                        </div>
                        <div class="float-end">
                            <a class="btn btn-primary" href="{{ route('home') }}"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" style="background-color: rgb(253, 135, 155);">{{ __('File Blotter Form') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('blotters.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row my-1">
                                    <label for="lastName" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input readonly="true" id="lastName" type="text" class="form-control" name="lastName" value="{{ Auth::user()->lastName }}" autofocus>
                                    </div>
                                </div>
            
                                <div class="form-group row my-1">
                                    <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input readonly="true" id="firstName" type="text" class="form-control" name="firstName" value="{{ Auth::user()->firstName }}" autofocus>
                                    </div>
                                </div>
            
                                @if(!empty(Auth::User()->middleName))
                                    <div class="form-group row my-1">
                                        <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>
                                        
                                        <div class="col-md-6">
                                            <input readonly="true" id="middleName" type="text" class="form-control" name="middleName" value="{{ Auth::user()->middleName }}" autofocus>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group row my-1">
                                        <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('No Middle Name') }}</label>
                                    </div>
                                @endif
            
                                <div class="form-group row my-1">
                                    <label for="houseNo" class="col-md-4 col-form-label text-md-right">{{ __('House Number') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input readonly="true" id="houseNo" type="text" class="form-control" name="houseNo" value="{{ Auth::user()->houseNo }}" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row my-1">
                                    <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Street') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input readonly="true" id="street" type="text" class="form-control" name="street" value="{{ Auth::user()->street }}" autofocus>
                                    </div>
                                </div>
            
                                <div class="form-group row my-1">
                                    <label for="province" class="col-md-4 col-form-label text-md-right">{{ __('Province') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input readonly="true" id="province" type="text" class="form-control" name="province" value="{{ Auth::user()->province }}" autofocus>
                                    </div>
                                </div>
            
                                <div class="form-group row my-1">
                                    <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input readonly="true" id="city" type="text" class="form-control" name="city" value="{{ Auth::user()->city }}" autofocus>
                                    </div>
                                </div>
            
                                {{-- <div class="form-group row my-1">
                                    <label for="citizenship" class="col-md-4 col-form-label text-md-right">{{ __('Citizenship') }}</label>
                                    
                                    <div class="col-md-6">
                                        <input id="citizenship" type="text" class="form-control" name="city" value="{{ Auth::user()->citizenship }}" autofocus>
                                    </div>
                                </div> --}}

                                <div class="form-group row my-1">
                                    <label for="blotterDetails" class="col-md-4 col-form-label text-md-right">{{ __('Blotter Details') }}</label>
                                    
                                    <div class="col-md-6">
                                        <textarea class="form-control" name="blotterDetails" id="blotterDetails" cols="30" rows="10" placeholder="Enter details here..." required></textarea>
                                    </div>
                                </div>

                                @foreach ($smId as $id) 
                                    <input type="hidden" name="smId" value="{{ $id->id }}">
                                @endforeach

                                <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                
                                <div class="form-group row my-1">
                                    <div class="col-md-6 offset-md-4 ">
                                        <button onclick="return confirm('Are your inputs correct?')" type="submit" class="btn btn-success" >
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

