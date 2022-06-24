<?php
if(isset($sayfa_args[1]) && $sayfa_args[1] == "ekle") {
   if (!$user->admin) {
       access_denied();
   }
   else {
     $page_title = "Yayinevi Ekleme";
     $posted = count($_POST) > 0;
     $hata = '';
     $sorgu1 = "SELECT * FROM yayinevleri ORDER BY yay_isim";
        $result = mysql_query($sorgu1);
        $yayinevleri1 = array();
        while ($yay1 = mysql_fetch_object($result)) {
         $yayinevleri1[]= $yay1;
                        }
     if ($posted) {
	   $girilen_yayinevi = trim($_POST['yay_isim']);
       if ($girilen_yayinevi == '') {
	    $hata = "Boş bırakılamaz.";
	   }
	   $sorgu = "SELECT yay_isim FROM yayinevleri";
	   $result = mysql_query($sorgu);
       while ($yay = mysql_fetch_object($result)) {
	     $yayinevleri[] = $yay->yay_isim;
      }
	   $girilen_yayinevi = mb_convert_case($girilen_yayinevi, MB_CASE_TITLE, "UTF-8");
	   if (in_array($girilen_yayinevi,$yayinevleri)) {
	     $hata = "O zaten girilmiş";
	   }
     }
$content = "<style>td{vertical-align: top;}</style>";
$content .= "<table cellspacing='15px'><tr><td>Kayıtlı yayinevleri<hr><ul class='sayfalink'>";
foreach ($yayinevleri1 as $yay1) {
$content .="<li><a href='?sayfa=yayinevi/{$yay1->yayinevi_no}'>$yay1->yay_isim</a></li>";
                   }
$content .= "</ul></td><td><form method=post>
            <table  cellspacing='15px' cellpadding='10px'><tr><td colspan='2'>Eklenecek Yayınevinin Adını Giriniz</td></tr>
                   <tr><td></td><td><input type='text' name='yay_isim'/></td></tr>
                   <tr><td colspan='2' align='right'><input type='submit' value='Gönder'/></td></tr>
                </table></form></td></tr></table>";
$path = "?sayfa=yayinevleri/ekle";
     if ($hata == '' && $posted) {
	    $sorgu = "INSERT INTO yayinevleri (yay_isim) VALUES ('$girilen_yayinevi')";
	    // add_message($sorgu);
	    mysql_query($sorgu);
     echo "<meta http-equiv=\"refresh\" content=\"0; url='$path'\" />";
     }
     else {
        if ($hata != '') add_message($hata);
     }
    
   }
 
}
  