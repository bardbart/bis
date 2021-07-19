<x-layout>
    @section('title', 'Request Documents')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
        <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: gray; color: white">{{ __('Document Request Form') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="Image" class="col-sm-4 col-form-label text-md-right">{{ __('Barangay ID') }}</label>
                                
                                <div class="col-md-6">
                                    <input type="file"  class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('lastName') }}" required autocomplete="lastName" autofocus>
                                    
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

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
                                <label for="civilStatus" class="col-md-4 col-form-label text-md-right">{{ __('Civil Status') }}</label>
                                <div class="col-md-6">
                                  <input @if (Auth::user()->civilStatus == 'Single') return checked @endif id="civilStatus" type="radio" value="Single" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" required autocomplete="civilStatus">
                                  <label for="Single">Single</label>
                                
                                  <input @if (Auth::user()->civilStatus == 'Married') return checked @endif id="civilStatus" type="radio" value="Married" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" required autocomplete="civilStatus">
                                  <label for="Married">Married</label>
                                
                                  <input @if (Auth::user()->civilStatus == 'Widowed') return checked @endif id="civilStatus" type="radio" value="Widowed" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" required autocomplete="civilStatus">
                                  <label for="Widowed">Widowed</label>

                                  <input @if (Auth::user()->civilStatus == 'Divorced') return checked @endif id="civilStatus" type="radio" value="Divorced" class=" @error('civilStatus') is-invalid @enderror" name="civilStatus" required autocomplete="civilStatus">
                                  <label for="Divorce">Divorced</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="citizenship" class="col-md-4 col-form-label text-md-right">{{ __('Citizenship') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="citizenship" type="text" class="form-control" name="city" value="{{ Auth::user()->citizenship }}" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="docType" class="col-md-4 col-form-label text-md-right">{{ __('Document Type') }}</label>
                                
                                <div class="col-md-6">
                                    <select class="form-select" name="docType" id="docType" autofocus>
                                    @foreach ($data as $type) 
                                            <option value="{{ $type->id }}">{{ $type->docType }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="purpose" class="col-md-4 col-form-label text-md-right">{{ __('Purpose') }}</label>
                                
                                <div class="col-md-6">
                                    <select class="form-select" name="purpose" id="purpose" autofocus>
                                        <option>Personal Identification and Residence Status</option>
                                        <option>Good Standing in the Community</option>
                                        <option>No pending case filed in the barangay</option>
                                        <option>Employment (Local)</option>
                                        <option>Employment (Abroad)</option>
                                        <option>Enrollment</option>
                                        <option>Scholarship</option>
                                        <option>Indigency</option>
                                        <option>Senior Citizens & Solo Parent</option>
                                        <option>Marriage (Local)</option>
                                        <option>Marriage (Abroad)</option>
                                        <option>Construction Permit</option>
                                        <option>Construction Excavaion Permit</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="transMode" class="col-md-4 col-form-label text-md-right">{{ __('Transaction Mode') }}</label>
                                
                                <div class="col-md-6">
                                    <select class="form-select" name="transMode" id="transMode" autofocus>
                                        <option>Pick-Up</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="paymentMode" class="col-md-4 col-form-label text-md-right">{{ __('Payment Mode') }}</label>
                                
                                <div class="col-md-6">
                                    <select class="form-select" name="paymentMode" id="paymentMode" autofocus>
                                        <option>Over the Counter</option>
                                        {{-- <option>Gcash</option> --}}
                                    </select>
                                </div>
                            </div>

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
    
