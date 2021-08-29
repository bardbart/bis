<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Complaint</title>
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
            City of (barangay) <br>
            <b> Barangay (barangay)</b> <br>
            OFFICE OF THE LUPONG TAGAPAMAYAPA</p>
        </div>

        <div class="cr">
            <p><u><b>{{ $td->firstName }} {{ $td->lastName }}</b></u></p>
            <p>{{ $td->houseNo . ' ' . $td->street }}</p>
            <p>--against--</p>
            <p><u><b>{{ $td->respondents }}</b></u></p>
            <p>{{ $td->respondentsAdd }}</p>
            <p align="center"><b>C O M P L A I N T</b></p>
        </div>

        <div class="body">
            <p>I hereby complain against the above named respondent for violating my rights and interest in the following manner: <br><br>
                {{ $td->compDetails }}
            </p>
        </div>

        <div class="footer">
            <br>
            <p>Made this day <b>{{ Carbon\Carbon::now()->format('j F, Y') }}</b> </p> <br>
            <p id="name"><u>{{ $td->firstName }} {{ $td->lastName }}</u></p>
            <p>Complainant's Signature</p> <br>
            <p>Recieved and filed this <b>{{ Carbon\Carbon::now()->format('j F, Y') }}</b></p> <br>
            @foreach ($officials as $official)
                @if($official->position == 'Chairman')
                    <p><u style="text-transform: uppercase">{{ $official->name }}</u><br>
                    <b>Punong Barangay</b></p>
                @endif
            @endforeach
        </div>

</body>
</html>