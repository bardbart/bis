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
    let orderRedirect = document.getElementById('orderRedirect');

    if(valid)
    {
        code.value = result;
        codeIndicator.style.color = 'green';
        orderRedirect.href = result;
        orderRedirect.style.display = 'block';
    }
    else
    {
        code.value = 'Invalid Code';
        codeIndicator.style.color = 'red';
        orderRedirect.href = '#';
        orderRedirect.style.display = 'none';
    }
}
function openCamera()
{
    /* Opens Camera and Starts Instascan Scanner */
    let select = document.getElementById('videoSource');
    let cameraName = document.getElementById('cameraName');
    let cameraId = document.getElementById('cameraId');
    let urlformat = /^(http:\/\/127\.0\.0\.1\:8000\/orders\/o\/)[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}$/;
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
            if(urlformat.test(result))
                isCodeValid(true, result);
            else
                isCodeValid(false, result);
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