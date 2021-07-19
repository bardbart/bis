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
	}

	#qr-code{
		float:right;
	}

	.document-type{
		margin: auto;
  		width: 50%;
  		/* border: 3px solid green; */
  		padding: 10px;
		font-size: 120%;
		/* margin: 25px; */
	}
	
	.officers{
		font-size:95%;
		float: left;
		/* border: 1px solid; */
		margin: 0px 20px 0px 5px;
		padding: 0px 20px 0px 0px;
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
	
	@foreach ($td as $trans_data)
		<div class="header" align="center">
			<p><img id="brgy-logo" src="{{ asset('images/brgy-logo.png') }}" style="height: 100px; width: auto;"></p>
			<p><img id="qr-code" 
				src="data:image/png;base64,{!! base64_encode(QrCode::format('png')
				->size(100)
				->generate($qr = "Issued on: " . Carbon\Carbon::now() . " | Issued by: " . Auth::user()->firstName . " " . Auth::user()->lastName)) !!}"></p>	
			<p>Republic of the Philippines <br>
			Province of Metro Manila <br>
			City of Taguig <br>
			<b>Barangay (barangay)</b></p>
		</div>

		<div class="document-type" align="center">
			<p><b>Office of the Punong Barangay</b></p>
			<p id="type"><b><u>CERTIFICATE OF {{ $trans_data->docType }}</u></b></p>
		</div>

		<div class="officers">
			<p style="text-transform: uppercase; font-size: 110%"><b>Barangay Officials</b></p>
			<p style="text-transform: uppercase"><b><u>Baranagay Chairman</u></b></p>
			@foreach ($officials as $chairman)	
				@if($chairman->position == 'Chairman')
					<p>{{ $chairman->name }}</p>
				@endif
			@endforeach
			<p style="text-transform: uppercase"><b><u>Barangay Councils</u></b><br>
			@foreach ($officials as $councils)
				@if($councils->position == 'Councilor')
					<p>{{ $councils->name }}<br></p>	
				@endif
			@endforeach
			<p style="text-transform: uppercase"><b><u>Barangay SK Chairman</u></b></p>
			@foreach ($officials as $sk)
				@if($sk->position == 'SK Chairman')
					<p>{{ $sk->name }}<br></p>	
				@endif
			@endforeach
			<p style="text-transform: uppercase"><b><u>Barangay Secretary</u></b></p>
			@foreach ($officials as $secretary)
				@if($secretary->position == 'Secretary')
					<p>{{ $secretary->name }}<br></p>	
				@endif
			@endforeach
			<p style="text-transform: uppercase"><b><u>Barangay Treasurer</u></b></p>
			@foreach ($officials as $treasurer)
				@if($treasurer->position == 'Treasurer')
					<p>{{ $treasurer->name }}<br></p>	
				@endif
			@endforeach
		</div>	

		@if ($trans_data->docType = "Indigency")
			<div class="body">
				<p>TO WHOM IT MAY CONCERN: 
				<br><br>
				This is to certify that <b><u>{{ $data['lastName'] }}, {{ $data['firstName'] }}</u></b>, of legal age, {{ $data['civilStatus'] }}, {{ $data['citizenship'] }} citizen, and resident of {{ $data['houseNo'] }}, (barangay), {{ $data['city'] }}, {{ $data['province'] }}.
				<br><br>
				Further certify that the above-named person belongs to the <b>Indigent Family</b> in this Barangay.
				<br><br>
				This Certification is being issued upon the request of the interested party connection with the requirement for whatever legal purposes that may serve them best, in this case it is a {{ $trans_data->purpose }} requirement.
				<br><br>
				Issued on this date {{ Carbon\Carbon::now()->format('Y-m-d') }}, from the Barangay Information System, Brgy. Central Bicutan, {{ $data['province'] }}, Philippines.
				</p>
			</div>
		@elseif ($trans_data->docType = "Clearance")
			<div class="body">
				<p>TO WHOM IT MAY CONCERN: 
				<br><br>
				This is to certify that <b><u>{{ $data['lastName'] }}, {{ $data['firstName'] }}</u></b>, of legal age, {{ $data['civilStatus'] }}, and resident of {{ $data['houseNo'] }}, (barangay), {{ $data['city'] }}, {{ $data['province'] }}.
				He/She is a law-abiding citizen and has NO DEROGATORY record/s in this offcie up to this date
				<br><br>
				This Certification is being issued upon the request of the interested party connection with the requirement for whatever legal purposes that may serve them best, in this case it is a <b><u>{{ $trans_data->purpose }}</u></b> requirement.
				<br><br>
				Issued on this date {{ Carbon\Carbon::now()->format('Y-m-d') }}, from the Barangay Information System, Brgy. Central Bicutan, {{ $data['province'] }}, Philippines.
				</p>
			</div>
		@endif
	@endforeach


    <div class="footer">
		@foreach ($officials as $chairman)
			@if($chairman->position == 'Chairman')
				<p align="right">
					<u style="text-transform: uppercase">{{ $chairman->name }}</u> <br>
					<b>Punong Barangay</b>
				</p>
			@endif
		@endforeach
    </div>


</body>
</html>