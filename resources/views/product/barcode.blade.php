<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Barcode</title>
	<style type="text/css">
		.text-center{
			text-align: center;
		}
	</style>
</head>
<body>
	<table width="100%">
		<tr>
			@foreach($barcode as $key => $b)
				<td class="text-center" style="border: 0.2px solid;">
					<p>{{ $b->product_name }}- Rp.{{ format_uang($b->purchase_price) }}</p>
					<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($b->code, 'C39') }}" alt="{{ $b->code }}" width="180" height="60">
					<br>
					<p class="text-center">{{ $b->code }}</p>
				</td>	
				@if(count($barcode) == 1)
				<td class="text-center" width="50%"></td>
				@endif
				@if($no++ % 3 == 0)
					</tr><tr>
				@endif
				
			@endforeach
		</tr>
	</table>
</body>
</html>