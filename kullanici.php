<?php
   if ($sayfa_args[0] == "logout") {  // kullanıcı çıkış yapmak istiyor
      // oturum değişkenini at
	  unset($_SESSION["uid"]);
	  // bağlantının tıklandığı sayfayı yükle
      header("Location: {$_SERVER['HTTP_REFERER']}");
	  exit;
   }
   elseif (isset($_SESSION["uid"])) { // kullanıcı daha önce giriş yapmışsa onu yükle
      $user = load_user($_SESSION["uid"]);
   }
   elseif(isset($_POST["form-id"]) && $_POST["form-id"] == "giris") { // kullanıcı giriş yapmak istiyor
   	  $rumuz = mysql_real_escape_string($_POST["rumuz"]); // dışarıdan gelip sorguda kullanılacağından
   	  $sifre = mysql_real_escape_string($_POST["sifre"]); // dışarıdan gelip sorguda kullanılacağından
	  $sifre = md5($sifre);  // veri tabanında md5 algoritmasıyla şifrelenmiş olarak tutuluyor şifreler
	  $sql = "SELECT * FROM users WHERE rumuz = '$rumuz' AND pass = '$sifre'";
      $result = mysql_query($sql, $connection);
      if (mysql_num_rows($result) == 0) {
  	     add_message("Kullanıcı bulunamadı.");
         $user = load_user(0);  // ziyaretçi bilgilerini yükle
      }
      else {  // doğru rumuz ve şifre
         // hatırlamak için oturuma kaydet
         $user = mysql_fetch_object($result);
	     $_SESSION["uid"] = $user->uid;
		 // en son giriş yaptığı zamanı değiştir
		 $now = time();
		 $sql = "UPDATE users SET access = $now WHERE uid = {$user->uid}";
         $result = mysql_query($sql, $connection);
		 if (mysql_affected_rows() != 1) {  // sorgu UPDATE olduğu için mysql_num_rows yerine bunu kullanıyoruz
			add_message("UPDATE hatası: " . mysql_error());
		 }
      }
   }
   else { // bu noktaya geldiysem sayfayı görüntüleyen bir ziyaretçidir.
      $user = load_user(0);
   }
?>