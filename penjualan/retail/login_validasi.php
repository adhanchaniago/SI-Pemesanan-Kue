<?php 
include_once "../../library/inc.connection.php";

# BACA TOMBOL LOGIN DIKLIK
if(isset($_POST['btnLogin'])){
	// Baca variabel form	
	$txtUsername   = $_POST['inpusername'];
	$txtPassword   = $_POST['inppassword'];
	
	// Validasi data pada form
	$pesanError = array();
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> kosong, silahkan isi dengan benar";
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b>Password</b> kosong, silahkan isi dengan benar";
	}

	// Skrip validasi User dan Password dengan data di Database
	$loginSql = "SELECT * FROM tb_retail WHERE username = '$txtUsername' AND password = MD5('$txtPassword')";
	$loginQry = mysqli_query($mysqli, $loginSql) or die ("Gagal query password".mysqli_error());
	$loginQty = mysqli_num_rows($loginQry);
	if($loginQty < 1) {
		$pesanError[] = "Data <b>Username dan Password</b> yang Anda masukan belum benar";
	}	
	
	// Tampilkan pesan Error jika ditemukan
	if (count($pesanError)>=1 ) {
		echo "<br>";
		echo "<div align='left'>";
		echo "&nbsp; <b> LOGIN ANDA SALAH .............</b><br><br>";
		echo "&nbsp; <b> Kesalahan Input : </b><br>";
		$urut_pesan = 0;
		foreach ($pesanError as $indeks=>$pesanTampil) {
			$urut_pesan++;
			echo "<div class='pesanError' align='left'>";
			echo "&nbsp; &nbsp;";
			echo "$urut_pesan . $pesanTampil <br>";
		}
		echo "<br>";
	}
	else {	
		# JIKA TIDAK ADA ERROR FORM DAN LOGIN BERHASIL
		if ($loginQty >= 1) {
			// baca data dari Query Login
			$loginData = mysqli_fetch_array($loginQry);
			
			// Membuat session
			$_SESSION['SES_PELANGGAN'] 	= $loginData['id_retail'];
			$_SESSION['SES_USERNAME'] 	= $loginData['username'];
			
			// Baca data Kode Pelanggan yang login
			$KodePelanggan	= $loginData['id_retail'];
			
			// // Kosongkan tabel TMP yang datanya milik Pelanggan
			// $hapusSql = "DELETE FROM tmp_keranjang WHERE id_retail='$KodePelanggan'";
			// mysqli_query($mysqli, $hapusSql) or die ("Gagal query hapus".mysql_error());
	
			echo "<meta http-equiv='refresh' content='0; url=index.php'>";
			exit;
		}
	}
}
?>