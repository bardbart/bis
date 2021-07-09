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
		margin: 50px;
	}
</style>

<body>
    @foreach ($td as $trans_data )
        <div class="header" align="center">
            <p><img id="brgy-logo" src="{{ asset('images/brgy-logo.png') }}" style="height: 80px; width: auto;"></p>
            <p><img id="qr-code" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(80)->generate($trans_data->id)) !!}"></p>
            <p>Republic of the Philippines <br>
            Province of Metro Manila <br>
            Municipality of Taguig <br>
            Barangay (barangay) <br>
            OFFICE OF THE LUPONG TAGAPAMAYAPA</p>
        </div>

        <div class="cr">
            <p><u><b>{{ $data['firstName'] }} {{ $data['lastName'] }}</b></u></p>
            <p>Complainant</p>
            <p>--against--</p>
            <p><u><b>{{ $trans_data->respondents }}</b></u></p>
            <p>Respondent</p>
            <p align="center"><b>C O M P L A I N T</b></p>
        </div>

        <div class="body">
            <p>I hereby complain against the above named respondent for violating my rights and interest in the following manner: <br><br>
                {{ $trans_data->complainDetails }}
            </p>
        </div>

        <div class="footer">
            <p>Made this day <b>{{ $trans_data->date }}</b> </p> <br>
            <p id="name"><u>{{ $data['firstName'] }} {{ $data['lastName'] }}</u></p>
            <p>Complainant's Signature</p> <br>
            <p>Recieved and filed this <b>{{ $trans_data->date }}</b></p> <br>
            <p><u>PUNONG BARANGAY</u></p>
            <p>Punong Barangay</p>
        </div>
    @endforeach
</body>
</html>