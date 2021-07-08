<!DOCTYPE html>
<html>
<head>
	<title>Document</title>
</head>

<style>
	.header{
		font-size: 120%;
		margin: 50px;
	}

	#brgy-logo{
		float: left;
		border: 20px black;
	}

	#qr-code{
		float:right;
	}

	.document-type{
		font-size: 150%;
		margin: 25px;
	}

	#type{
		text-transform: uppercase;
	}

	.body{
		font-size: 100%;
		margin: 50px;
	}

	.footer{
		font-size: 130%;
		margin: 50px;
	}
</style>

<body>
	@foreach ($td as $trans_date)
		<div class="header" align="center">
			<p><img id="brgy-logo" src="{{ asset('images/brgy-logo.png') }}" style="height: 100px; width: auto;"></p>
			<p><img id="qr-code" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($trans_date->id)) !!}"></p>	
			<p>Republic of the Philippines <br>
			Province of Metro Manila <br>
			Municipality of Taguig <br>
			<b>Barangay (barangay)</b></p>
		</div>

		<div class="document-type" align="center">
			<p><b>Office of the Punong Barangay</b></p>
			<p id="type"><b><u>CERTIFICATE OF {{ $trans_date->docType }}</u></b></p>
		</div>
		
		<div class="body">
			<p>TO WHOM IT MAY CONCERN: 
			<br><br>
			This is to certify that <b><u>{{ $data['lastName'] }}, {{ $data['firstName'] }}</u></b>, of legal age, {{ $data['civilStatus'] }}, {{ $data['citizenship'] }} citizen, and resident of {{ $data['houseNo'] }}, (barangay), {{ $data['city'] }}, {{ $data['province'] }}.
			<br><br>
			Further certify that the above-named person belongs to the <b>Indigent Family</b> in this Barangay.
			<br><br>
			This Certification is being issued upon the request of the interested party connection with the requirement for whatever legal purposes that may serve them best.
			<br><br>
			Issued on this date {{ $trans_date->date }}, from the Barangay Information System, (barangay), {{ $data['province'] }}, Philippines.
			</p>
		</div>
	@endforeach

    <div class="footer">
    	<p align="right">
			<u>BARANGAY CHAIRMAN</u> <br>
    		<b>Punong Barangay</b>
    	</p>
		{{-- <div class="qr-code" align="left"> --}}
			
		{{-- </div> --}}
    </div>

    
</body>
</html>