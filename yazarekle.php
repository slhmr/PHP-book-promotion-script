
<?php
if(isset($sayfa_args[1]) && $sayfa_args[1] == "ekle") {
$hata ='';
$page_title = "Yazar Ekle Formu";
   if (!$user->admin) {
       access_denied();
   }


   else {     
     $posted = count($_POST) > 0;

 if ($posted) {
       $girilen_yazar = trim($_POST['y_isim']);
       $girilen_ozgecmis = trim($_POST['ozgecmis']);
       if ($girilen_yazar == '') {
	    $hata = "Yazar ismi boş bırakılamaz.";
	   }
	   $sorgu = "SELECT y_isim FROM yazarlar";
	   $result = mysql_query($sorgu);
       $yazar = array();
	   while ($yaz = mysql_fetch_object($result)) {
	     $yazar[] = $yaz->y_isim; 
	   }
	   $girilen_yazar = mb_convert_case($girilen_yazar, MB_CASE_TITLE, "UTF-8");
	   if (in_array($girilen_yazar,$yazar)) {
	     $hata = "Girilen Yazar Kayılarımızda Bulunmaktadır";
	   }
      
 }
$content .= "
<br><table><center>
  <tr><td>Yazar İsmi</td></tr>
  <form method='post' name='degis' enctype='multipart/form-data'>
  <tr><td></td><td><input name='y_isim' type='text' size=40></td></tr>
  <tr><td>Özgeçmiş</td></tr>
  <tr><td></td><td><textarea rows='5' name='ozgecmis' cols='40'></textarea></td></tr>
  <tr><td>Resim</td></tr>
  <tr><td></td><td><input type='file' name='resim' size='35'></td></tr>
  <td><input type='submit' value='Gönder'></td>
  </form></center></table>
  ";
$path = "?sayfa=yazarlar";
if ($hata == '' && $posted) { 
   	    $sorgu = "INSERT INTO yazarlar (y_isim,ozgecmis) VALUES ('$girilen_yazar','$girilen_ozgecmis')";
	   
	    @mysql_query($sorgu);
       $f_id = mysql_insert_id();   
if (isset($_FILES['resim'])) {
                        $r_kontrol=Resimformat_kontrol(basename($_FILES['resim']['name']));
                        }
    if (isset($_FILES['resim'])) { 
   	if ($r_kontrol!="evet") {
   	  	$hata= "Resmin dosya formatı tanınmadı.";
   	}
   	else {
   	  	$path = sprintf("images/Yazarlar/Yazar-%03d", $f_id);
	  	$filename = basename($_FILES['resim']['name']);
	  	$extension = substr($filename, strrpos($filename,"."));
	  	$path .= strtolower($extension);
	  	if (move_uploaded_file($_FILES['resim']['tmp_name'], $path)) {
			 $filename = substr($path, 16);
			 $sql = "UPDATE yazarlar SET resim = '$filename' WHERE yazar_no = $f_id";
        	 $result = mysql_query($sql);
	    	 if (mysql_affected_rows() != 1) {
                $hata= "MYSQL UPDATE hatası: " . mysql_error();
             }
	     	}
      	}
       
    }
   
        else {
        if ($hata != '') add_message($hata);
            }

   		}
         
	}

}

?>