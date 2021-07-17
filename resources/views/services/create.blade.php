<x-layout>
    {{-- @section('title', 'Add Service') --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
    
<<<<<<< HEAD
                    <div class="card-header" style="background-color: gray; color:white;">{{ __('Create Service') }}</div>
        
                        <div class="card-body">
    
=======
                    <div class="card-header" style="background-color: gray; color:white;">{{ __('Add Service') }}</div>

                    <div class="card-body">
>>>>>>> e7a1f1b2b9bdd88a2c1ffa464bc3e784d3758e20
                        <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="docType" class="col-md-4 col-form-label text-md-right">{{ __('Service Type') }}</label>
                                
                                <div class="col-md-6">
                                    <select class="form-select" name="serviceType" id="serviceType">
                                        @foreach ($serviceTypes as $serviceType) 
                                            <option value="{{ $serviceType->id }}">{{ $serviceType->serviceName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="serviceName" class="col-md-4 col-form-label text-md-right">{{ __('Service Name') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="serviceName" type="text" class="form-control" @error('serviceName') is-invalid @enderror name="serviceName">
                                    @error('serviceName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4 ">
                                    <button onclick="return confirm('Are your inputs correct?')" type="submit" class="btn btn-primary" >
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        @if ($errors->any()) 
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    </x-layout>
    