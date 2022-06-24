<?php
if(isset($sayfa_args[1]) && $sayfa_args[1] == "ekle") {
   if (!$user->admin) {
       access_denied();
   }
   else {
     $page_title = "Yeni Kitap Ekleme";
     $posted = count($_POST) > 0;
     $hatalar = array();

     if ($posted) {
         $girilen_kitap = trim($_POST['k_isim']);
         $secilen_yazar = trim($_POST['y_isim']);
         $secilen_yayinevi = trim($_POST['yay_isim']);
         $basimtarihi =  $_POST['gun']."-". $_POST['ay'] . "-" . $_POST['yil'];
         $ceviri = ($_POST['dili']);
         $girilen_sayfasayisi = trim($_POST['sayfa_sayisi']);
         $girilen_tanitim = trim($_POST['k_ozet']);
         $ekletarih=time();
     if(trim($_POST["k_isim"]) == "")
       $hatalar["kitap"] = "Kitap ismi bos bırakılamaz.";
       $kitapvarsa = "SELECT k_isim FROM kitaplar";
	   $kitapvar = mysql_query($kitapvarsa);
       $kitapvarmı = array();
	   while ($kvar = mysql_fetch_object($kitapvar)) {
	     $kitapvarmı[] = $kvar->k_isim;
	   }
	$girilen_tur = mb_convert_case($girilen_kitap, MB_CASE_TITLE, "UTF-8");
	   if (in_array($girilen_kitap,$kitapvarmı)) {
	      $hatalar['kitapvar'] = "O zaten girilmiş";
	   }
$sorguyazarno = "SELECT yazar_no FROM yazarlar WHERE y_isim= '$secilen_yazar'";
$result4=mysql_query($sorguyazarno);
$yaz = mysql_fetch_object($result4);
$sorguyayinevi = "SELECT yayinevi_no FROM yayinevleri WHERE yay_isim= '$secilen_yayinevi'";
$result5=mysql_query($sorguyayinevi);
$yay = mysql_fetch_object($result5);
 }
if (count($hatalar) == 0 && $posted) {
        $sorgu = "INSERT INTO kitaplar (yazar_no,yayinevi_no,k_isim,tanitim,sayfa_sayisi,ceviri,ekletarih,tarih)
                  VALUES ('$yaz->yazar_no','$yay->yayinevi_no','$girilen_kitap','$girilen_tanitim','$girilen_sayfasayisi','$ceviri','$ekletarih','$basimtarihi')";
        mysql_query($sorgu);        
     $yenikitabinnosu = mysql_insert_id();

     foreach ($_POST['tur'] as $i => $değer) {
           $sorguturler = "INSERT INTO kitapturler (kitap_no,tur_no) VALUES ($yenikitabinnosu,$i)";
           mysql_query($sorguturler);
         }
     if (isset($_FILES['resim'])) {
          $r_kontrol=Resimformat_kontrol(basename($_FILES['resim']['name']));
                        }
if (isset($_FILES['resim'])) {
   	if ($r_kontrol!="evet") {
   	  	$hata= "Resmin dosya formatı tanınmadı.";
   	}
   	else {
   	  	$path = sprintf("images/Kitap_Kapak/kitap-%03d", $yenikitabinnosu);
	  	$filename = basename($_FILES['resim']['name']);
	  	$extension = substr($filename, strrpos($filename,"."));
	  	$path .= strtolower($extension);
	  	if (move_uploaded_file($_FILES['resim']['tmp_name'], $path)) {
			 $filename = substr($path, 19);
			 $sql = "UPDATE kitaplar SET kapak_resim = '$filename' WHERE kitap_no = $yenikitabinnosu";
        	 $result = mysql_query($sql);
	    	 if (mysql_affected_rows() != 1) {
                $hata= "MYSQL UPDATE hatası: " . mysql_error();
             }
	     	}
      	}
    }
 echo "<meta http-equiv=\"refresh\" content=\"0; url='?sayfa=kitaplar'\" />";
   }
else {  
$aylar=array('OCAK','ŞUBAT','MART','NİSAN','MAYIS','HAZİRAN','TEMMUZ','AĞUSTOS','EYLÜL','EKİM','KASIM','ARALIK');
$content .= "<style>td{vertical-align: top;}
                    #listeleme{list-style:none;}
                    </style><br>
                    <form method='post' enctype='multipart/form-data'>
					<table><tr><td rowspan='3' width='80%'>
					 <table>
                     <tr><td>Kitabın Adı</td><td>";
            if ($posted) $Gkitap = $_POST['k_isim'];else $Gkitap = "";if(isset($hatalar['kitap']))$Gkitap=$hatalar['kitap'];
$content .="<input type='text' name='k_isim' size='42' value='$Gkitap'></td></tr>
              <tr><td>Kitabın Yazarı</td><td>";
            $kayitliyazarlar = "SELECT y_isim FROM yazarlar order by y_isim";
            $kayitliyazarlarsonucu = mysql_query($kayitliyazarlar);
            $yazarlar = array();
            while ($kayitliyazar = mysql_fetch_object($kayitliyazarlarsonucu)) {
             $yazarlar[] = $kayitliyazar ;
            }
$content .="<select name='y_isim'>";
			foreach($yazarlar as $kayitliyazar){
            if ($posted && $kayitliyazar->y_isim == $secilen_yazar )
$content .="<option selected>$kayitliyazar->y_isim</option> ";
            else
$content .="<option>$kayitliyazar->y_isim</option> ";
            }
$content .="</select> </td> </tr> <tr><td>Yayınevi</td><td>";
            $kayitliyayinevleri = "SELECT yay_isim FROM yayinevleri order by yay_isim";
            $kayitliyayinevlerisonucu = mysql_query($kayitliyayinevleri );
            $yayinevi = array();
            while ($kayitliyayinevi = mysql_fetch_object($kayitliyayinevlerisonucu)) {
             $yayinevi[] = $kayitliyayinevi ;
            }
$content .="<select name='yay_isim'>";
        foreach($yayinevi as $kayitliyayinevi){
        if ($posted && $kayitliyayinevi->yay_isim == $secilen_yayinevi )
$content .="<option selected>$kayitliyayinevi->yay_isim</option> ";
else
$content .="<option>$kayitliyayinevi->yay_isim</option> ";
            }
$content .="</select></td></tr><tr><td>Basım Tarihi</td><td>";
$content .="<select name='gun'>";
            for ($x=01; $x<=31; $x++){
$content .="<option>$x</option> ";
            }
$content .="</select><select name='ay'>";
            foreach($aylar as $i=> $index){
$content .="<option>$index</option>";
				}
$content .="</select> <select name='yil'>";
            for ($y=1990; $y<=2019; $y++){
$content .="<option>$y</option> ";
            }
$content .="</select></td></tr>
                            <tr><td>Basım Türü</td><td>";
if($posted && $_POST['dili'] == 0) {
      $checked2 = "";
      $checked1 = "";
      $checked0 = "checked";
                    }
else if($posted && $_POST['dili'] == 1)  {
       $checked2 = "";
       $checked1 = "checked";
       $checked0 = "";   
          }
else {
        $checked2 = "checked";
        $checked1 = "";
        $checked0 = "";              
          }
$content .="<input type='radio' name='dili' value='2' $checked2/>Türkçe
                <input type='radio' name='dili' value='1' $checked1/>Yabancı
                <input type='radio' name='dili' value='0' $checked0/>Ceviri</td></tr>";
if ($posted) $sayfasayisi = $_POST['sayfa_sayisi'];
else $sayfasayisi = "";
$content .="<tr><td>Kitabın sayfa sayısı</td><td><input type='text' name='sayfa_sayisi' size='4' value='$sayfasayisi'></td></tr>";

$content .="<tr><td>Kitabın Kısa Özeti</td><td><textarea name='k_ozet' rows=10 cols=32>";
if ($posted) $tanitim = $_POST['k_ozet'];
else $tanitim = "";
$content .="$tanitim</textarea></td></tr>";
$content .="<tr><td>Kitabın Kapak Resmi</td><td>
            <input type='file' name='resim' size='30'></td></tr>
			<tr><td align='right' colspan='2'><input type='submit' name='ekle' value='Ekle'/></td>
            </tr>
            </table></td>";
$content .="<tr><td>Kitap Türünü Seçiniz<br><ul id='listeleme'>";
$kitapturleriyazilir = "SELECT tur_no, t_isim FROM turler";
$kitapturleriyazilirresult = mysql_query($kitapturleriyazilir);
while ($tur = mysql_fetch_object($kitapturleriyazilirresult)) {
if ($posted && isset($_POST['tur'][$tur->tur_no]))
$content .="<li><input type='checkbox' name='tur[{$tur->tur_no}]' value=1 checked />{$tur->t_isim}</li>";
else
$content .="<li><input type='checkbox' name='tur[{$tur->tur_no}]' value=1 />{$tur->t_isim}</li>";
	      }

$content .= "</ul></td></tr></td></tr></table>";
}
}
   
}
else{
    $page_title = "HATA..!!!";
    $content .="
        <table cellspacing='30px' cellpadding='20px'>
        <tr><td class='hata'>Kitap ekleme işlemi sadece yetkili tarafından yapılabilir</td></tr>
        <tr><td><a href='javascript:history.back()'> << Geri Dön</a></td></tr></table>";

}
?>