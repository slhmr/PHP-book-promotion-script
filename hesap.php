<?php
  if (count($sayfa_args) == 1) {
     page_not_found();
  }
  elseif (is_numeric($sayfa_args[1]))  { // demek ki url: ...?sayfa=hesap/uid
     $hesap = load_user($sayfa_args[1]);
     $page_title = $hesap->isim;
	 if (isset($sayfa_args[2]) && $sayfa_args[2] == "edit") { // demek ki url: ...?sayfa=hesap/uid/edit
	    // sayfayı görüntüleyen bir admin veya hesap sahibi ise formu göster (1 numaralı kullanıcıyı sadece kendi değiştirebilir)
	    if(($user->admin && $hesap->uid != 1) || $hesap->uid == $user->uid) {
	 	   include "hesap-form.php";  // bu dosya çok büyümesin diye ayırdık
	 	}
		else {
           access_denied();
		}
	 }
	 elseif ($hesap->uid == 0) {
	 	page_not_found();
	 }
	 else {
       $content .= "<br><table><tr><td colspan='2'><p align='center'><h3>Avatar</h3></p><img src='images/Avatar/$hesap->resim' class='avatar'></td></tr>";
	   $content .= "<tr><td>En son ne zaman görüldü  </td><td> ";
	   if ($hesap->access == 0) $content .= "Hiç giriş yapmamış.";
       else $content .= strftime("%d-%m-%Y (%X)", $hesap->access);
	   if ($user->uid != 0) {  // bu kısmı ziyaretçiler göremeyecek
	 	   $content .= "</td></tr>
                        <tr><td>Adres</td><td>".$hesap->adres."</td></tr>
                        <tr><td>Tel</td><td>".$hesap->tel."</td></tr>
                        <tr><td> E-mail </td><td> ". $hesap->mail."</td></tr></table>";
	   }
       else{
           access_denied();
       }
	   if (($user->admin && $hesap->uid != 1) || $hesap->uid == $user->uid) { // sayfayı görüntüleyen bir admin veya hesap sahibi ise
	   	  $content .= "<div><a href='?sayfa=hesap/{$hesap->uid}/edit'> Hesap Bilgilerini Değiştir</a></div>";
	   }
	}
  }
  elseif($sayfa_args[1] == "ekle") {
  	 if ($user->admin) {
  	 	$page_title = "Kullanıcı Ekle";
  	 	include "hesap-form.php";
	 }
	 else access_denied();
  }
  else {
      page_not_found();
  }

?>