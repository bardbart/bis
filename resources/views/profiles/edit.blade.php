@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Edit Profile</h2>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-primary" href="{{ route('home') }}"> Back</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Edit Profile') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profiles.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        
                        <div class="form-group row">
                            <label for="lastName" class="col-md-4 col-form-label text-md-right">{{ __('Last Name *') }}</label>
                            
                            <div class="col-md-6">
                                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{$user->lastName }}" required autocomplete="lastName" autofocus>
                                
                                @error('lastName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ __('The last name must be letters only') }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name *') }}</label>
                            
                            <div class="col-md-6">
                                <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ $user->firstName }}" required autocomplete="firstName" autofocus>
                                
                                @error('firstName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ __('The first name must be letters only') }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>
                            
                            <div class="col-md-6">
                                <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" value="{{ $user->middleName }}" autocomplete="middleName" autofocus>
                                
                                @error('middleName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ __('The middle name must be letters only') }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address *') }}</label>
                            
                            <div class="col-md-6">
                                <input disabled id="email" placeholder="example@gmail.com" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                                
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- <div class="form-group row">
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
                        
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password *') }}</label>
                            
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div> --}}
                        
                        <div class="form-group row">
                            <label for="contactNo" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number *') }}</label>
                            
                            <div class="col-md-6">
                                <input id="contactNo" type="tel" pattern="[0-9]{10}" placeholder="9123456789" class="form-control @error('contactNo') is-invalid @enderror" name="contactNo" value="{{ $user->contactNo }}" required autocomplete="contactNo">
                                
                                @error('contactNo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="houseNo" class="col-md-4 col-form-label text-md-right">{{ __('House Number *') }}</label>
                            
                            <div class="col-md-6">
                                <input id="houseNo" type="text" class="form-control @error('houseNo') is-invalid @enderror" name="houseNo" value="{{ $user->houseNo }}" required autocomplete="houseNo">
                                
                                @error('houseNo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Street *') }}</label>
                            
                            <div class="col-md-6">
                                <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ $user->street }}" required autocomplete="street">
                                
                                @error('street')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="zipCode" class="col-md-4 col-form-label text-md-right">{{ __('Zip Code *') }}</label>
                            
                            <div class="col-md-6">
                                <input id="zipCode" type="text" pattern="[0-9]{4}" placeholder="1234" class="form-control @error('zipCode') is-invalid @enderror" name="zipCode" value="{{ $user->zipCode }}" required autocomplete="zipCode">
                                
                                @error('zipCode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="province" class="col-md-4 col-form-label text-md-right">{{ __('Province *') }}</label>
                            
                            <div class="col-md-6">
                                <input id="province" type="text" class="form-control @error('province') is-invalid @enderror" name="province" value="{{ $user->province }}" required autocomplete="province">
                                
                                @error('province')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City *') }}</label>
                            
                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $user->city }}" required autocomplete="city">
                                
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ __('The city must be letters only') }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of birth *') }}</label>
                            
                            <div class="col-md-6">
                                <input id="dob" type="date" max='2003-12-31' data-date-format="YYYY MM DD" class="form-control  @error('dob') is-invalid @enderror" name="dob" value="{{ $user->dob }}" required autocomplete="dob">
                                
                                {{-- Not sure if this below is applicable or necessary for date
                                @error('dob')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror --}}
                            </div> 
                        </div>
                        
                        <!-- <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                            
                            <div class="col-md-6">
                                
                                  <input @if ($user->gender == 'Male') return checked @endif id="gender" type="radio" name="gender" value="Male" class=" @error('gender') is-invalid @enderror"   required autocomplete="gender">
                                  <label for="Male">Male</label>
                                
                                  <input @if ($user->gender == 'Female') return checked @endif id="gender" type="radio" name="gender" value="Female" class=" @error('gender') is-invalid @enderror"  required autocomplete="gender">
                                  <label for="Female">Female</label>
                                
                                  <input @if ($user->gender == 'Rather not say') return checked @endif id="gender" type="radio" name="gender" value="Rather not say" class=" @error('gender') is-invalid @enderror"  required autocomplete="gender">
                                  <label for="others">Others</label>
                            </div>
                        </div> -->
                        
                        <div class="form-group row">
                            <label for="civilStatus" class="col-md-4 col-form-label text-md-right">{{ __('Civil Status *') }}</label>
                            
                            <div class="col-md-6">
                                
                                
                                  <input @if ($user->civilStatus == 'Single') return checked @endif id="civilStatus" type="radio" value="Single" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" value="{{ old('civilStatus') }}" required autocomplete="civilStatus">
                                  <label for="Single">Single</label>
                                
                                  <input @if ($user->civilStatus == 'Married') return checked @endif id="civilStatus" type="radio" value="Married" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" value="{{ old('civilStatus') }}" required autocomplete="civilStatus">
                                  <label for="Married">Married</label>
                                
                                  <input @if ($user->civilStatus == 'Widowed') return checked @endif id="civilStatus" type="radio" value="Widowed" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" value="{{ old('civilStatus') }}" required autocomplete="civilStatus">
                                  <label for="Widowed">Widowed</label><br>

                                  <input @if ($user->civilStatus == 'Divorced') return checked @endif id="civilStatus" type="radio" value="Divorced" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" value="{{ old('civilStatus') }}" required autocomplete="civilStatus">
                                  <label for="Divorce">Divorced</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="citizenship" class="col-md-4 col-form-label text-md-right">{{ __('Citizenship') }}</label>
                            
                            <div class="col-md-6">
                                <input disabled id="citizenship" type="text" class="form-control @error('citizenship') is-invalid @enderror" name="citizenship" value="{{ $user->citizenship }}" required autocomplete="citizenship">
                                @error('citizenship')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ __('The citizenship must be letters only') }}</strong>
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

@endsection
