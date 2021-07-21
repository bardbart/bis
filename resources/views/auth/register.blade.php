<x-layout>
    @section('title', 'Register')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: rgb(253, 135, 155);">{{ __('Register') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row my-1">
                                <label for="lastName" class="col-md-4 col-form-label text-md-right">{{ __('Last Name *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required autocomplete="lastName" autofocus>
                                    
                                    @error('lastName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__('The last name must be letters only')  }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" required autocomplete="firstName" autofocus>
                                    
                                    @error('firstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('The first name must be letters only') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" value="{{ old('middleName') }}" autocomplete="middleName" autofocus>
                                    
                                    @error('middleName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('The middle name must be letters only') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="email" placeholder="example@gmail.com" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="contactNo" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="contactNo" type="tel" pattern="[0-9]{10}" placeholder="9123456789" class="form-control @error('contactNo') is-invalid @enderror" name="contactNo" value="{{ old('contactNo') }}" required autocomplete="contactNo">
                                    
                                    @error('contactNo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="houseNo" class="col-md-4 col-form-label text-md-right">{{ __('House Number *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="houseNo" type="text" class="form-control @error('houseNo') is-invalid @enderror" name="houseNo" value="{{ old('houseNo') }}" required autocomplete="houseNo">
                                    
                                    @error('houseNo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Street *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" required autocomplete="street">
                                    
                                    @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="zipCode" class="col-md-4 col-form-label text-md-right">{{ __('Zip Code *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="zipCode" type="text" class="form-control @error('zipCode') is-invalid @enderror" name="zipCode" value="{{ old('zipCode') }}" required autocomplete="zipCode">
                                    
                                    @error('zipCode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="province" class="col-md-4 col-form-label text-md-right">{{ __('Province *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="province" type="text" class="form-control @error('province') is-invalid @enderror" name="province" value="{{ old('province') }}" required autocomplete="province">
                                    
                                    @error('province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">
                                    
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('The city must be letters only') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of birth *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="dob" type="date" max='2003-12-31' data-date-format="YYYY MM DD" class="form-control  @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" required autocomplete="dob">
                                    
                                    {{-- Not sure if this below is applicable or necessary for date --}}
                                    {{-- @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror --}}
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender *') }}</label>
                                
                                <div class="col-md-6">
                                    {{-- <input id="gender" type="text" class="form-control  @error('gender') is-invalid @enderror" name="gender" value="{{ old('gender') }}" required autocomplete="gender"> --}}
                                    
                                      <input id="gender" type="radio" name="gender" value="Male" class=" @error('gender') is-invalid @enderror"  value="{{ old('gender') }}" required autocomplete="gender">
                                      <label for="male">Male</label>
                                    
                                      <input id="gender" type="radio" name="gender" value="Female" class=" @error('gender') is-invalid @enderror" value="{{ old('gender') }}" required autocomplete="gender">
                                      <label for="female">Female</label>
                                    
                                      <input id="gender" type="radio" name="gender" value="Rather not say" class=" @error('gender') is-invalid @enderror" value="{{ old('gender') }}" required autocomplete="gender">
                                      <label for="others">Others</label>
                                    
                                    {{-- @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror --}}
                                </div>
                            </div>
                            
                            <div class="form-group row my-1">
                                <label for="civilStatus" class="col-md-4 col-form-label text-md-right">{{ __('Civil Status *') }}</label>
                                
                                <div class="col-md-6">
                                    {{-- <input id="civilStatus" type="text" class="form-control  @error('civilStatus') is-invalid @enderror" name="civilStatus" value="{{ old('civilStatus') }}" required autocomplete="civilStatus"> --}}
                                    
                                      <input id="civilStatus" type="radio" value="Single" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" value="{{ old('civilStatus') }}" required autocomplete="civilStatus">
                                      <label for="single">Single</label>
                                    
                                      <input id="civilStatus" type="radio" value="Married" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" value="{{ old('civilStatus') }}" required autocomplete="civilStatus">
                                      <label for="married">Married</label>
                                    
                                      <input id="civilStatus" type="radio" value="Widowed" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" value="{{ old('civilStatus') }}" required autocomplete="civilStatus">
                                      <label for="widowed">Widowed</label><br>
    
                                      <input id="civilStatus" type="radio" value="Divorced" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" value="{{ old('civilStatus') }}" required autocomplete="civilStatus">
                                      <label for="divorce">Divorced</label>
                                    
                                    {{-- @error('civilStatus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror --}}
                                </div>
                            </div>
    
                            <div class="form-group row my-1">
                                <label for="citizenship" class="col-md-4 col-form-label text-md-right">{{ __('Citizenship *') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="citizenship" type="text" class="form-control @error('citizenship') is-invalid @enderror" name="citizenship" value="{{ old('citizenship') }}" required autocomplete="citizenship">
                                    
                                    @error('citizenship')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('The citizenship must be letters only') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
    
                            <div class="form-group row my-1">
                                <div class="col-md-6 offset-md-4">
                                    <button onclick="return confirm('Are your inputs correct?')" type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
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

