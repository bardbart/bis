<x-layout>
    <x-section name='scripts'>
        @if($instascanJS ?? false)

            <script src="{{ asset('js/instascan/adapter.min.js') }}"></script>
            <script src="{{ asset('js/instascan/vue.min.js') }}"></script>
            <script src="{{ asset('js/instascan/instascan.min.js') }}"></script>
            
        @endif

        
    </x-section>
    <div class="container" style="margin-top: 100px;" id="main-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="display-1 text-center">Scan QR</h2>
                <a href="/orders">
                    <button class="btn btn-secondary col-md-12 btn-lg mb-2">Go back</button>
                </a>
                    <div class="card">
                        <div class="card-header text-center">{{ __('Scan Here') }}</div>
                        <div class="card-body text-center">
                            <video id="preview" width="600" height="400"></video>
                            <hr>
                                <button class="btn btn-primary mx-auto" id="cameraFinder" onclick="getCameras();" style="display: block;">Get Cameras</button>
                                <button class="btn btn-success mx-auto" id="cameraToggle" onclick="openCamera();" style="display: none; disabled: true;">Turn ON Camera</button>
                            <hr>
                            <h5>Camera Details</h5>
                            <label for="videoSource" class="mr-1">Video Source</label>
                            <select class="custom-select" id='videoSource'></select>
                            <small id="videoSourceHelper" class="form-text text-muted">
                                If there is a newly-connected camera, please refresh the page.
                            </small>
                            <br>
                            <h6 id="cameraName">Camera Name:</h6>
                            <h6 id="cameraId">Camera ID:</h6>
                            <hr>
                            <h5 id="codeIndicator">Code</h5>
                            <textarea class="text-center" id="code" name="code" value="" rows="2" cols="33" placeholder="Code Appears Here..." readonly style="border:0; background-color: transparent;">
                            </textarea>
                            <a id="orderRedirect" href="#" style="display: none;">
                                <button class="btn btn-success">Go to Order</button>
                            </a>
                            <br>
                            <small id="qrCodeHelper" class="form-text text-muted">Valid QR Code format:<br> '/orders/o/0X0X0X0X-0X0X-0X0X-0X0X-0X0X0X0X0X0X'</small>
                        </div>
                    </div>
                <hr>
                
            </div>
        </div>
    </div>

 
        @if($instascanJS ?? false)
            <script type="text/javascript" src="{{ asset('js/instascan/custom-instascan.js') }}"></script>
        @endif


</x-layout>
