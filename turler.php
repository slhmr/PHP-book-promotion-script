<?php
if(isset($sayfa_args[1]) && $sayfa_args[1] == "ekle") {
   if (!$user->admin) {
       access_denied();
   }
   else {
     $page_title = "Kitap Türü Ekleme";
     $posted = count($_POST) > 0;
     $hata = '';
     $sorgu1 = "SELECT * FROM turler order by t_isim";
        $result = mysql_query($sorgu1);
        $turler1 = array();
        while ($tur1 = mysql_fetch_object($result)) {
         $turler1[] = $tur1;
                        }
     if ($posted) {
	   $girilen_tur = trim($_POST['tur']);
       if ($girilen_tur == '') {
	    $hata = "Boş bırakılamaz.";
	   }
	   $sorgu = "SELECT t_isim FROM turler";
	   $result = mysql_query($sorgu);
       $turler = array();
	   while ($tur = mysql_fetch_object($result)) {
	     $turler[] = $tur->t_isim; 
	   }
	$girilen_tur = mb_convert_case($girilen_tur, MB_CASE_TITLE, "UTF-8");
	   if (in_array($girilen_tur,$turler)) {
	     $hata = "O zaten girilmiş";
	   }
     }
     $content = "<style>td{vertical-align: top;}</style><table><tr><td width='50%'>Kitap Türleri<hr width='50%' align='left'> <ul  class='sayfalink'>";
        foreach ($turler1 as $tur1) {
$content .= "
            <li id='listeleme'><a  href='?sayfa=turegorekitaplar/$tur1->tur_no'>$tur1->t_isim</a></li>";
                   }
$content .= "</ul></td><td>
                        <form method=post><br>
                       Eklenecek Türün ismi <br> <input type='text' name='tur'>
                        <input type='submit' value='Gönder'/>
                        </form></td></tr></table>";
$path = "?sayfa=turler/ekle";
    if ($hata == '' && $posted) {  // hata yok veri tabanına ekle
	    $sorgu = "INSERT INTO turler (t_isim) VALUES ('$girilen_tur')";
	    // add_message($sorgu);
	    mysql_query($sorgu);
        echo "<meta http-equiv=\"refresh\" content=\"0; url='$path'\" />";
     }
     else {
        if ($hata != '') add_message($hata);
     }
   }
}


?>
