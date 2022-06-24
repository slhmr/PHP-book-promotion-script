<?php

// yardımcı fonksiyonlar

function page_not_found() {
   global $content;
   global $page_title;
   $page_title = "Sayfa bulunamadı";
   $content = "Aradığınız sayfa bulunamadı. Lütfen adresi kontrol ediniz.";
}

function access_denied() {
   global $content;
   global $page_title;
   $page_title = "Hata";
   $content = "Bu sayfaya erişim hakkınız yok.";
}

function add_message($new_message) {
   global $messages;
   $messages .= "<li>$new_message</li>";
}

function check_result($result) {
  if (!$result) {
     add_message("DB Error, could not query the database");
     add_message('MySQL Error: ' . mysql_error());
  }
}
// ziyaretçiler için veri tabanı sütunlarıyla tutarlı ufak bir nesne tanımla ve gerekirse kullan
class User {
  // member declarations -- ziyaretçiler için öntanımlı değerler
  public $uid = 0; // kayıtlı kullacılar için 0'dan büyük olacağından if'lerde kullanılabilir
  public $isim = "Ziyaretçi";
  public $admin = 0;
}

function load_user($user_id) {
global $connection;

  if ($user_id == 0) {  // ziyaretçi bilgisi yüklenmek istendi
  	 $user = new User(); // böylece $user->uid = 0, $user->admin = 0 ve $user->isim = "Ziyaretçi" oldu.
  }
  else {
     $sql    = "SELECT * FROM users WHERE uid = $user_id";
     $result = mysql_query($sql, $connection);
     
     if (mysql_num_rows($result) == 1) {  // kullanıcı var
        $user = mysql_fetch_object($result);
     }
	 else {  // kullanıcı bulunamadı
	 	$user = new User();
	 }
  }
  return $user;
}

function tarihcevir($tarih) {
        $tarih = split("-",$tarih);
        $yil = $tarih[0];
        $ay = $tarih[1];
        $gun = $tarih[2];
        $tarih = "$gun.$ay.$yil";
        return $tarih;
        unset($tarih, $yil, $ay, $gun);
}
function Resimformat_kontrol($r_kontrol){
		$uzanti = explode('.',$r_kontrol);
		switch ($uzanti[1]) {
        case 'jpg':$uzanti='evet';break;
		case 'jpeg':$uzanti='evet';	break;
		case 'gif':$uzanti='evet';break;
		case 'png':$uzanti='evet';break;
		case 'bmp':$uzanti='evet';break;
        case 'ico':$uzanti='evet';break;
		default:
		$uzanti='hayir';
		}
return $uzanti;
}
?>
