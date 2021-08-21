<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settle</title>
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
		margin: 0px 25px;
	}

	.body{
		font-size: 100%;
		margin: 0px 25px;
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
                ->generate($qr = "Issued on: " . Carbon\Carbon::now() . " | Issued by: " . Auth::user()->firstName . " " . Auth::user()->lastName)) !!}"></p>
            <p>Republic of the Philippines <br>
            Province of Metro Manila <br>
            City of (city) <br>
            <b> Barangay (barangay)</b> <br>
            OFFICE OF THE LUPONG TAGAPAMAYAPA</p>
        </div>

        <div class="cr">
            <p><u><b>{{ $td->firstName }} {{ $td->lastName }}</b></u></p>
            <p>{{ $td->houseNo . ' ' . $td->street }}</p>
            <p>--against--</p>
            <p><u><b>{{ $td->respondents }}</b></u></p>
            <p>{{ $td->respondentsAdd }}</p>
            <p align="center"><b>AMICABLE SETTLEMENT</b></p>
        </div>

        <div class="body">
            <p>We, complainant/s and respondent/s in the above-captioned case, do hereby agree to settle our dispute as follows:<br><br>
                {{ $td->compDetails }} <br><br>
                and bind ourselves to comply honest and faithfully with the above terms of settlement.
            </p>
        </div>

        <div class="footer">
            <p>Entered into this day <b>{{ $td->date }}</b></p>
            <p>Complainant/s</p>
            <p id="name"><u>{{ $td->firstName }} {{ $td->lastName }}</u></p>
            <p>Respondent/s</p>
            <p id="name"><u>{{ $td->respondents }}</u></p>
            <p>Recieved and filed this <b>{{ Carbon\Carbon::now()->format('j F, Y') }}</b></p><br>
            <p><b>ATTESTATION</b></p>
            <p>I hereby certify that the following amicable settlement was entered into by the parties freely and voluntarily, after I had explained to them the nature and consequence of such settlement</p>
            @foreach ($officials as $chairman)
                @if($chairman->position == 'Chairman')
                    <p><u style="text-transform: uppercase">{{ $chairman->name }}</u><br>
                    <b>Punong Barangay</b></p>
                @endif
		    @endforeach
        </div>

</body>
</html>