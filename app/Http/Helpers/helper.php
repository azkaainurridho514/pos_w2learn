<?php 

function format_uang($angka){
	return number_format($angka, 0, ',', '.');
}

function terbilang($angka){
	$angka = abs($angka);
	$baca = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
	$terbilang = '';

	if($angka < 12) $terbilang = ' ' . $baca[$angka]; // 1 - 11
	elseif($angka < 20) $terbilang = terbilang($angka - 10) . ' belas'; // 12 -19
	elseif($angka < 100) $terbilang = terbilang($angka / 10) . ' puluh' . terbilang($angka % 10); // 20 - 99
	elseif($angka < 200) $terbilang = ' seratus' . terbilang($angka - 100); // 100 - 199
	elseif($angka < 1000) $terbilang = terbilang($angka / 100) . ' ratus' . terbilang($angka % 100); // 200 - 999
	elseif($angka < 2000) $terbilang = ' seribu' . terbilang($angka - 1000); // 1000 - 1999
	elseif($angka < 1000000) $terbilang = terbilang($angka / 1000) . ' ribu' . terbilang($angka % 1000); // 2000 - 999999
	elseif($angka < 1000000000) $terbilang = terbilang($angka / 1000000) . ' juta ' . terbilang($angka % 1000000); // 1000000 - 999000000

	return $terbilang;
}

function tanggal_indonesia($tgl, $tampil_hari = true){
	$nama_hari = array( 'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu' );
	$nama_bulan = array(1 =>
 		'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
	);

	// pecah 2022-01-01 (tahun, bulan, hari)
	$tahun = substr($tgl, 0, 4);
	$bulan = $nama_bulan[(int)substr($tgl, 5, 2)];
	$tanggal = substr($tgl, 8, 2);
	if($tampil_hari){
		$urutan_hari = date('w', mktime(0,0,0, substr($tgl, 5, 2), $tanggal, $tahun));
		$hari = $nama_hari[$urutan_hari];
		$text = "$hari, $tanggal $bulan $tahun";	
	}else{
		$text = "$tanggal $bulan $tahun";
	}
	
	return $text;

}


function add_zero($val, $threshold = null)
{
	return sprintf("%0".$threshold."s", $val);
}