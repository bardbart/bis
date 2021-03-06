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
		font-size:100%;
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
	{{-- @foreach ($brgy as $officials)
		<table>
			<th>Name</th>
			<th>Position</th>
			<tr>
				<td>{{ $officials->lastName.', '.$officials->firstName }}</td>
				<!-- @foreach ($brgy->officialsPositions as $position)
					<td>{{ $position->positionName }}</td>
				@endforeach -->
			</tr>
		</table>
		
	@endforeach --}}
	{{-- {{ $qr= "Issued: 2021-07-14 
			 Issued by: Jon Jeremiah Bartolome
			 Jerry Jones, Barangay Chairman" }} --}}
	@foreach ($td as $trans_data)
		<div class="header" align="center">
			<p><img id="brgy-logo" src="{{ asset('images/brgy-logo.png') }}" style="height: 100px; width: auto;"></p>
			<p><img id="qr-code" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($trans_data->id)) !!}"></p>	
			<p>Republic of the Philippines <br>
			Province of Metro Manila <br>
			City of Taguig <br>
			<b>Barangay Central Bicutan</b></p>
		</div>

		<div class="document-type" align="center">
			<p><b>Office of the Punong Barangay</b></p>
			<p id="type"><b><u>CERTIFICATE OF {{ $trans_data->docType }}</u></b></p>
		</div>

		<div class="officers">
			<p><b>Barangay Officials</b></p>
			<p><b>Baranagay Chairman</b><br>Jerry Jones </p>
			<p><b>Baranagy Councils</b><br>
				Jerry Jones <br><br>
				Jerry Jones <br><br>
				Jerry Jones <br><br>
				Jerry Jones <br><br>
				Jerry Jones <br><br>
				Jerry Jones <br><br>
				Jerry Jones
			</p>
		</div>
		
		<div class="body">
			<p>TO WHOM IT MAY CONCERN: 
			<br><br>
			This is to certify that <b><u>{{ $data['lastName'] }}, {{ $data['firstName'] }}</u></b>, of legal age, {{ $data['civilStatus'] }}, {{ $data['citizenship'] }} citizen, and resident of {{ $data['houseNo'] }}, (barangay), {{ $data['city'] }}, {{ $data['province'] }}.
			<br><br>
			Further certify that the above-named person belongs to the <b>Indigent Family</b> in this Barangay.
			<br><br>
			This Certification is being issued upon the request of the interested party connection with the requirement for whatever legal purposes that may serve them best, in this case it is a {{ $trans_data->purpose }} requirement.
			<br><br>
			Issued on this date {{ $trans_data->date }}, from the Barangay Information System, Brgy. Central Bicutan, {{ $data['province'] }}, Philippines.
			</p>
		</div>
	@endforeach


    <div class="footer">
    	<p align="right">
			<u>BARANGAY CHAIRMAN</u> <br>
    		<b>Punong Barangay</b>
    	</p>
    </div>


</body>
</html>