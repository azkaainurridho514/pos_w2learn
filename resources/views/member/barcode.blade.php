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

	<section style="border: 1px solid #fff;">
		<table width="100%">
			@foreach($barcode as $key => $data)
				<tr>
					@foreach($data as $item)
						<td class="text-center">
							<div class="card">
								<img src="{{ asset($setting->member_path_logo) }}">
								<div class="logo">
									<p>{{ $setting->company_name }}</p>
									<img src="{{ asset($setting->path_logo) }}">
								</div>
								<div class="name">{{ $item['name'] }}</div>
								<div class="phone">{{ $item['phone'] }}</div>
								<div class="barcode text-left">
									<img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($item['member_code'], 'QRCODE') }}" alt="{{ $item['member_code'] }}" width="45" height="45">
								</div>
							</div>	
						</td>

						@if(count($barcode) == 1)
						<td class="text-center" width="50%"></td>
						@endif
					@endforeach
				</tr>
			@endforeach
		</table>
	</section>


{{-- 	<table width="100%">
		<tr>
			@foreach($barcode as $key => $b)
				<td class="text-center" style="border: 0.2px solid;">
					<p>- {{ $b->name }} -</p>
					<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($b->member_code, 'C39') }}" alt="{{ $b->member_code }}" width="180" height="60">
					<br>
					<p class="text-center">{{ $b->member_code }}</p>
				</td>	
				@if($no++ % 3 == 0)
					</tr><tr>
				@endif
				
			@endforeach
		</tr>
	</table> --}}
</body>
</html>