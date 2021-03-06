<?php
include_once "../../library/inc.sesadmin.php";   // Validasi, mengakses halaman harus Login
include_once "../../library/inc.connection.php"; // Membuka koneksi
include_once "../../library/inc.library.php";    // Membuka librari peringah fungsi

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris = 30;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysqli_query($mysqli, $pageSql) or die ("error paging: ".mysqli_error($mysqli));
$jumlah	 = mysqli_num_rows($pageQry);
$maksData= ceil($jumlah/$baris);
?>
<table width="800" border="0" cellpadding="2" cellspacing="1" class="table-common">
  <tr>
    <td colspan="2" align="right"><h1><b><font color="#FF0066">DATA KUE </font></b></h1></td>
  </tr>
  
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?open=Barang-Add" target="_self"><img src="../assets/images/btn_add_data.png" height="30" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">
     <table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="26" align="center" bgcolor="#CCCCCC"><font color="#FF0066"><strong>No</strong></font></th>
        <th width="88" align="left" bgcolor="#CCCCCC"><font color="#FF0066"><strong>Kode</strong></font></th>
        <th width="300" bgcolor="#CCCCCC"><font color="#FF0066"><strong>Nama Kue </strong></font></th>
        <th width="54" bgcolor="#CCCCCC"><font color="#FF0066"><strong> Stok</strong></font></th>
        <th width="116" align="right" bgcolor="#CCCCCC"><font color="#FF0066"><strong> Harga (Rp) </strong></font></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><font color="#FF0066"><strong>Tools</strong></font></td>
      </tr>
      <?php	
      $mySql = "SELECT * FROM barang ORDER BY kd_barang ASC LIMIT $hal, $baris";
      $myQry = mysqli_query($mysqli, $mySql)  or die ("Query salah : ".mysqli_error($mysqli));
      $nomor = $hal; 
      while ($myData = mysqli_fetch_array($myQry)) {
        $nomor++;
        $Kode = $myData['kd_barang'];
        ?>
        <tr>
          <td align="center"><?php echo $nomor; ?></td>
          <td><?php echo $myData['kd_barang']; ?></td>
          <td><?php echo $myData['nm_barang']; ?></td>
          <td align="center"><?php echo $myData['stok']; ?></td>
          <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
          <td width="100" align="center">
            <a href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"><img src="../assets/images/b_edit.png" style="width: 30px; height: 30px;"></a>
            <a href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA KUE INI ... ?')"><img src="../assets/images/b_drop.png" style="width: 30px; height: 30px;"></a>
          </td>
        </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td width="407"><font color="#FF0066"><b>Jumlah Data :</b></font> <?php echo $jumlah; ?> </td>
    <td width="384" align="right"><font color="#FF0066"><b>Halaman ke :</b></font>
      <?php
      for ($h = 1; $h <= $maksData; $h++) {
        $list[$h] = $baris * $h - $baris;
        echo " <a href='?open=Barang-Data&hal=$list[$h]'>$h</a> ";
      }
      ?></td>
    </tr>
  </table>
