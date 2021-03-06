<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Escalate</title>
</head>

<style>
    .header{
		font-size: 120%;
		margin: 50px;
	}

	#brgy-logo{
		float: left;
	}

	#qr-code{
		float:right;
	}

	#name{
		text-transform: uppercase;
	}

    .cr{
		font-size: 100%;
		margin: 25px;
	}

	.body{
		font-size: 100%;
		margin: 25px;
	}

	.footer{
		font-size: 100%;
		margin: 25px;
	}
</style>

<body>

        <div class="header" align="center">
            <p><img id="brgy-logo" src="{{ asset('images/brgy-logo.png') }}" style="height: 100px; width: auto;"></p>
            <p><img id="qr-code" 
                src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
                ->size(100)
                ->generate($td->unique_code)) !!}"></p>
            <p>Republic of the Philippines <br>
            Province of Metro Manila <br>
            City of Taguig <br>
            <b> Barangay Lower Bicutan</b> <br>
            OFFICE OF THE LUPONG TAGAPAMAYAPA</p>
        </div>

        <div class="cr">
            <p align="center"><b>CERTIFICATION TO FILE CASE</b></p>
            <p><u><b>{{ $td->firstName }} {{ $td->lastName }}</b></u></p>
            <p>{{ $td->houseNo . ' ' . $td->street }}</p>
            <p>--against--</p>
            <p><u><b>{{ $td->respondents }}</b></u></p>
            <p>{{ $td->respondentsAdd }}</p>
        </div>

        <div class="body">
            <p>This is to certify that <b>No Settlement/Concilliation was reached.</b><br>
            Settlement has been reputed <br>
            And therefore the corresponding complaint for the dispute may now be filled in Court/Government office.</p>
        </div>

        <div class="footer">
            <br>
            <p>This day <b>{{ Carbon\Carbon::now()->format('j F, Y') }}</b></p><br>
            <p><b>ATTESTED:</b></p> <br>
            @foreach ($officials as $chairman)
                @if($chairman->position == 'Chairman')
                    <p><u style="text-transform: uppercase">{{ $chairman->name }}</u> <br>
                    <b>Punong Barangay</b></p>
                @endif
		    @endforeach
        </div>

</body>
</html>