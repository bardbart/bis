<x-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
    
                    <div class="card-header" style="background-color: gray; color:white;">{{ __('Create Service') }}</div>
        
                        <div class="card-body">
    
                        <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="serviceType" class="col-sm-4 col-form-label text-md-right">{{ __('Service Type') }}</label>
                                
                                <div class="col-md-6">
                                    <select class="form-select" name="serviceType" id="serviceType" autofocus>
                                        <option>--Select Service Type--</option>
                                        @foreach ($serviceTypes as $serviceType) 
                                            <option value="{{ $serviceType->id }}">{{ $serviceType->serviceName }}</option>
                                        @endforeach
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="serviceName" class="col-sm-4 col-form-label text-md-right">{{ __('Service Name') }}</label>
                                <div class="col-md-6">
                                    <input id="serviceName" type="text" class="form-control @error('serviceName') is-invalid @enderror" name="serviceName" required autofocus>
                                    @error('serviceName')
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
    