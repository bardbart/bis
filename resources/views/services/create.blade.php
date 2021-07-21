<x-layout>
    {{-- @section('title', 'Add Service') --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="float-start">
                            <h2>Add Service</h2>
                        </div>
                        <div class="float-end">
                            <a class="btn btn-primary" href="{{ route('services.index') }}"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card">
    
                    <div class="card-header" style="background-color: rgb(253, 135, 155);">{{ __('Add Service') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row my-1">
                                <label for="docType" class="col-md-4 col-form-label text-md-right">{{ __('Service Type') }}</label>
                                
                                <div class="col-md-6">
                                    <select class="form-select" name="serviceType" id="serviceType">
                                        @foreach ($serviceTypes as $serviceType) 
                                            <option value="{{ $serviceType->id }}">{{ $serviceType->serviceName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row my-1">
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

                            <div class="form-group row my-1">
                                <div class="col-md-6 offset-md-4 ">
                                    <button onclick="return confirm('Are your inputs correct?')" type="submit" class="btn btn-success" >
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
    