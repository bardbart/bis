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
                <a href="/home">
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
                            <form id="foo" action="/documents/checkDoc/" method="GET">
                                @csrf
                                {{-- @method('POST') --}}
                                <input class="text-center" id="code" name="code" rows="2" cols="33" readonly style="border:0; background-color: transparent;"/>
                            </form>
                            {{-- <textarea class="text-center" id="code" name="code" value="" rows="2" cols="33" placeholder="Code Appears Here..." readonly style="border:0; background-color: transparent;">
                            
                            </textarea> --}}
                            
                    
                            
                            <a id="detailsRedirect" href="#" style="display: none;">
                                <button class="btn btn-success">See Details</button>
                            </a>
                            <br>
                            {{-- <small id="qrCodeHelper" class="form-text text-muted">Valid QR Code format:<br> '/orders/o/0X0X0X0X-0X0X-0X0X-0X0X-0X0X0X0X0X0X'</small> --}}
                        </div>
                    </div>
                <hr>
                
            </div>
        </div>
    </div>

 
    @if($instascanJS ?? false)
        {{-- <script type="text/javascript" src="{{ asset('js/instascan/custom-instascan.js') }}"></script> --}}
        <script>
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: true});

            function getCameras()
            {
                const select = document.getElementById('videoSource');

                /* Retrieve all available cameras to populate select */
                Instascan.Camera.getCameras().then(function(cameras) 
                {
                    if(cameras.length > 0) 
                    {
                        for (let i = select.length - 1; i >= 0; i--) 
                            select.remove(i);

                        for (let i = 0; i < cameras.length; i++) 
                        {
                            let opt = document.createElement('option');
                            opt.value = cameras[i].id;
                            opt.innerText = cameras[i].name;
                            select.add(opt);
                        }
                        disableCameraFinder();
                    }
                    else 
                        alert('No cameras found');

                }).catch(function(e){ console.error(e); });     
            }


            function disableCameraFinder()
            {
                const cameraFinder = document.getElementById("cameraFinder");
                const cameraToggle = document.getElementById("cameraToggle");

                cameraFinder.disabled = true;
                cameraFinder.style.display = 'none';

                cameraToggle.disabled = false;
                cameraToggle.style.display = 'block';
            }
            function isCodeValid(valid, result)
            {
                let code = document.getElementById('code');
                let codeIndicator = document.getElementById('codeIndicator');
                let detailsRedirect = document.getElementById('detailsRedirect');
                if(valid)
                {
                    code.value = result;
                    codeIndicator.style.color = 'green';
                    detailsRedirect.href = result;
                    detailsRedirect.style.display = 'block';
                }
                else
                {
                    code.value = 'Invalid Code';
                    codeIndicator.style.color = 'red';
                    detailsRedirect.href = '#';
                    detailsRedirect.style.display = 'none';
                }
            }
            function openCamera()
            {
                /* Opens Camera and Starts Instascan Scanner */
                let select = document.getElementById('videoSource');
                let cameraName = document.getElementById('cameraName');
                let cameraId = document.getElementById('cameraId');
                // let urlformat = /^(http:\/\/127\.0\.0\.1\:8000\/details\/o\/)[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}$/;
                /* Video Constraints */
                let videoConstraints = {};
                videoConstraints.deviceId = {exact: select.value};
                videoConstraints.width = { min: 640, ideal: 1280, max: 1920 };
                videoConstraints.height = { min: 480, ideal: 720, max: 1080 };

                /* Start Scanner with chosen camera */
                Instascan.Camera.getCameras().then(function(cameras) 
                {
                    if(cameras.length > 0) 
                    {
                        for (let i = 0; i < cameras.length; i++) 
                        {
                            if(cameras[i].id == select.value)
                            {
                                cameraName.innerText = 'Camera Name: '+cameras[i].name;
                                cameraId.innerText = 'Camera ID: '+cameras[i].id; 
                                scanner.start(cameras[i]);
                                break;
                            }
                        }
                    }
                    else 
                        alert('No cameras found');

                }).catch(function(e){ console.error(e); });

                /* Video Stream */
                const video = document.getElementById('preview');

                navigator.mediaDevices
                    .getUserMedia({ video: videoConstraints, audio: false })
                    .then(stream => {
                        video.srcObject = stream;
                    }).catch(error => { console.error(error); });

                /* Instascan Scanner Listeners */
                scanner.addListener('scan', function(result)
                {
                    if(result != null)
                    {
                        //submitting the form
                            let frm = document.getElementById("foo");
                            document.getElementById("code").value = result;
                            frm.submit();
                        // if(urlformat.test(result))
                            isCodeValid(true, result);

                        // else
                        //     isCodeValid(false, result);
                    }
                    else
                        document.getElementById('code').value = '';
                });

                let cameraToggle = document.getElementById('cameraToggle');
                cameraToggle.onclick = closeCamera;
                cameraToggle.innerText = 'Turn OFF Camera';
                cameraToggle.classList.remove('btn-success');
                cameraToggle.classList.add('btn-danger');
            }

            function closeCamera()
            {
                let cameraToggle = document.getElementById('cameraToggle');
                let cameraName = document.getElementById('cameraName');
                let cameraId = document.getElementById('cameraId');

                const video = document.getElementById('preview');
                const stream = video.srcObject;
                let tracks = stream.getTracks();

                /* Stop Instascan Scanner */
                scanner.stop()
                
                /* Stop all Camera Tracks */
                for (let i = 0; i < tracks.length; i++) 
                {
                    var track = tracks[i];
                    track.stop();
                }

                /* Reset all View Variables */
                video.srcObject = null;

                cameraToggle.onclick = openCamera;
                cameraToggle.innerText = 'Turn ON Camera';
                cameraToggle.classList.remove('btn-danger');
                cameraToggle.classList.add('btn-success');

                cameraName.innerText = 'Camera Name:';
                cameraId.innerText = 'Camera ID:'; 
            }
        </script>
    @endif
</x-layout>
