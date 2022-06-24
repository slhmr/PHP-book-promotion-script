<?php

$kitabid= $sayfa_args[1];
$hata='';
$id=$user->uid;
if ($id !=0){
$posted = count($_POST) > 0;


$kitapturleri="SELECT t.tur_no,t.t_isim FROM turler As t,kitapturler As kt WHERE
                kt.tur_no=t.tur_no AND kt.kitap_no=".$sayfa_args[1];
$result_turler=mysql_query($kitapturleri);
$numberoftur=mysql_num_rows($result_turler);

 while($gelenturler=mysql_fetch_object($result_turler)){
           $turler[]= $gelenturler;
       }


$sql= " SELECT * FROM kitaplar AS k, yazarlar AS y, yayinevleri AS m
             WHERE k.yazar_no = y.yazar_no and k.yayinevi_no = m.yayinevi_no and k.kitap_no = ". $sayfa_args[1];
$result = mysql_query($sql);
          check_result($result);
$kitap = mysql_fetch_object($result);

 $baglan="SELECT * FROM kitaplar WHERE kitap_no=". $sayfa_args[1];
 $result_set = mysql_query( $baglan);
 $row = mysql_fetch_array($result_set);
$views = $row['views'] + 1;
$r = mysql_query("UPDATE kitaplar SET views = '$views' WHERE kitap_no = '$sayfa_args[1]' ");



  $tarih = $kitap->tarih;

  $page_title = $kitap->k_isim;
  $title .= " - " . $kitap->k_isim;




  $content .= "<style>td{vertical-align: top;}</style><br>
                        <table>
                        <tr><td colspan='3' align='right'>$views kere okundu</td></tr>
                        <tr><td width='220px'> <img src='images/Kitap_Kapak/$kitap->kapak_resim' width='150px' height='180px'> </td>
                        <td rowspan='2' width='450px'><br><b>Kitabın Kısa Özeti</b><br><div><br>$kitap->tanitim</div></td>
                        <td rowspan='2' width='100px'><p align='right'>Eklendiği Tarih<br>";
$content .= strftime("%d-%m-%Y", $kitap->ekletarih);
$content .= "<tr><td rowspan='2'><table>
                                    <tr><td>Yazarı </td><td>:<a href='?sayfa=yazar/$kitap->yazar_no'>$kitap->y_isim</a><td>
                                    <tr><td>Yayınevi</td><td>:<a href='?sayfa=yayinevi/$kitap->yayinevi_no'>$kitap->yay_isim</a></td></tr>
                                    <tr><td>Sayfa Sayısı</td><td>:$kitap->sayfa_sayisi</td></tr>
                                    <tr><td>Basım Tarihi</td><td>:$kitap->tarih</td></tr>
                                    <tr><td>Türü</td><td>:";
if($numberoftur !=0){
foreach ($turler as $tur) {
$content .= "<a href='?sayfa=turegorekitaplar/{$tur->tur_no}'>{$tur->t_isim}</a><br> ";
           }
}
else{
 $content .= "Kitap Türü Belirtilmemiş";
}

$content .= "</table></td></tr></table><br><br>";


$sorgu ="SELECT * FROM yorum WHERE kitabid =$sayfa_args[1] ORDER BY yorum_no DESC LIMIT 4";
$res = mysql_query($sorgu, $connection);
$kac=mysql_num_rows($res);
$sorgu2 ="SELECT * FROM yorum WHERE kitabid =$sayfa_args[1] ";
$result = mysql_query($sorgu2, $connection);
$kac2=mysql_num_rows($result);
$di=$kitap->kitap_no;
$content .="
            <div class='sagust'></div>
			<div class='solust'></div>
			<div class='sagicerik'>
            <table width='80%'><tr>
                <td><a href='?sayfa=guncelle/$kitap->kitap_no'>Bilgileri Guncelle</a></td>
                <td><a href='?sayfa=addfavourite/$kitap->kitap_no'>Favorilerime Ekle</a></td>
                <td>Aldığı Yorumlar :$kac2</td>
                <td>Puan</td>
                </tr></table></div>
            <div class='sagalt'></div>
			<div class='solalt'></div><table width='100%'>";

$content .="<h3>Yapılan Son Yorumlar</h3><hr width='88%' align='left'>";

if ($kac !=0){
while ($yorum = mysql_fetch_object($res)) {
$content .="<style>td{vertical-align:top;</style><table><tr><td width='80%'>Gönderen $user->rumuz</td><td>";
$content .= strftime("%d-%m-%Y (%X)", $yorum->tarih);
$content .="</td>
                  <tr><td colspan='2'>  $yorum->yorum<hr></td></tr>";

                    }
$content .="</table>";
}
else{
$content .="Bu kitaba henüz yorum yapılmamış<br><br><br>";
$content .="</table>";
}
$tarih=time();
$path = "?sayfa=kitap/" . $sayfa_args[1];
 if ($posted) {
	   $girilen_yorum = trim($_POST['yorum']);
       if ($girilen_yorum == '') {
	    $hata = "Boş bırakılamaz.";
	   }
	   if (strlen($girilen_yorum) >500){
           $hata = "500 Karakterden  Fazla Girilemez.";
       }


     }
$content .="<form method='POST''>
          <br>Kitaba yorum yapmak için aşağıdaki formu doldurunuz<br>
          <textarea cols=40 rows=4 name='yorum'></textarea><br>
          <input type='hidden' name='id' value='$id'/>
          <input type='submit' value='Yorumu Gönder' name='gonder' action='?sayfa=kitap/$sayfa_args[1]'/>
          </form> <b>Max-chars: 500</b>";

if ($hata == '' && $posted) {
    $degerler="SET kitabid='$kitabid',yorum='$girilen_yorum',user='$user->uid',tarih='$tarih'";
    $sqlsorgu= "INSERT INTO yorum $degerler";
    mysql_query($sqlsorgu);
    echo "<meta http-equiv=\"refresh\" content=\"0; url='$path'\" />";
     }
     else {
        if ($hata != '') add_message($hata);

}
}
else{
	
	$kitapturleri="SELECT t.tur_no,t.t_isim FROM turler As t,kitapturler As kt WHERE
                kt.tur_no=t.tur_no AND kt.kitap_no=".$sayfa_args[1];
$result_turler=mysql_query($kitapturleri);
$numberoftur=mysql_num_rows($result_turler);

 while($gelenturler=mysql_fetch_object($result_turler)){
           $turler[]= $gelenturler;
       }
	
	
    $sql= " SELECT * FROM kitaplar AS k, yazarlar AS y, yayinevleri AS m
             WHERE k.yazar_no = y.yazar_no and k.yayinevi_no = m.yayinevi_no and k.kitap_no = ". $sayfa_args[1];
  $result = mysql_query($sql);
  check_result($result);
  $kitap = mysql_fetch_object($result);


 $baglan="SELECT * FROM kitaplar WHERE kitap_no=". $sayfa_args[1];
 $result_set = mysql_query( $baglan);
 $row = mysql_fetch_array($result_set);
$views = $row['views'] + 1;
$r = mysql_query("UPDATE kitaplar SET views = '$views' WHERE kitap_no = '$sayfa_args[1]' ");


  $tarih = $kitap->tarih;

  $page_title = $kitap->k_isim;
  $title .= " - " . $kitap->k_isim;

  $content .= "<style>td{vertical-align: top;}</style><br>
                        <table>
                        <tr><td colspan='3' align='right'>$views kere okundu</td></tr>
                        <tr><td width='220px'> <img src='images/Kitap_Kapak/$kitap->kapak_resim' width='150px' height='180px'> </td>
                        <td rowspan='2' width='450px'><br><b>Kitabın Kısa Özeti</b><br><div><br>$kitap->tanitim</div></td>
                        <td rowspan='2' width='100px'><p align='right'>Eklendiği Tarih<br>";
$content .= strftime("%d-%m-%Y", $kitap->ekletarih);
$content .= "<tr><td rowspan='2'><table>
                                    <tr><td>Yazarı </td><td>:<a href='?sayfa=yazar/$kitap->yazar_no'>$kitap->y_isim</a><td></tr>
                                    <tr><td>Yayınevi</td><td>:<a href='?sayfa=yayinevi/$kitap->yayinevi_no'>$kitap->yay_isim</a></td></tr>
                                    <tr><td>Sayfa Sayısı</td><td>:$kitap->sayfa_sayisi</td></tr>
                                    <tr><td>Basım Tarihi</td><td>:$kitap->tarih</td></tr>
                                    <tr><td>Türü</td><td>:";
                                    
                                    
                                    
if($numberoftur !=0){
foreach ($turler as $tur) {
$content .= "<a href='?sayfa=turegorekitaplar/{$tur->tur_no}'>{$tur->t_isim}</a><br> ";
           }
}
else{
 $content .= "Kitap Türü Belirtilmemiş";
}

$content .= "</table></td></tr></table><br><br>";
}


?>
