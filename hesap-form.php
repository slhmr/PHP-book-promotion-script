<?php
$hatalar = array();

if (isset($_FILES['yeni-resim'])) {
   $formats = array("image/jpeg","image/png","image/gif");
   if (!in_array($_FILES['yeni-resim']['type'], $formats)) {
   	  $hatalar["resim"] = "Resmin dosya formatı tanınmadı.";
   }
   else {
   	  $path = sprintf("images/Avatar/avatar-%03d", $hesap->uid);
	  $filename = basename($_FILES['yeni-resim']['name']);
	  $extension = substr($filename, strrpos($filename,"."));
	  $path .= strtolower($extension);
	  if (move_uploaded_file($_FILES['yeni-resim']['tmp_name'], $path)) {
         add_message("Resim başarıyla yüklendi...");
		 $filename = substr($path, 14);  // baÅŸtaki './resimler/' kÄ±smÄ±nÄ± attÄ±k
		 $sql = "UPDATE users SET resim = '$filename' WHERE uid = {$hesap->uid}";
         $result = mysql_query($sql, $connection);
	     if (mysql_affected_rows() != 1) {  // sorgu UPDATE olduÄŸu iÃ§in mysql_num_rows yerine bunu kullanÄ±yoruz
		   add_message("MYSQL UPDATE hatası: " . mysql_error());
	     }
      } else {
         $hatalar["resim"] = "Resim kaydedilirken bir sorun oluştu";
      }
   }
}

elseif (count($_POST) > 0) {  // form gÃ¶nderilmiÅŸ gerekenleri yap
  // Ã–nce formdaki olabilecek hatalarÄ± kontrol ediyoruz (form validation)
  if ($_POST['isim'] == '')	$hatalar['isim'] = "İsim boş bırakılaaz";
  if ($_POST['rumuz'] == '') $hatalar['rumuz'] = "Rumuz boş bırakılamaz";
  else {
  	 $rumuz = mysql_real_escape_string($_POST['rumuz']);  // hacker'lara karÅŸÄ± Ã¶nlem
  	 $sql = "SELECT * FROM users WHERE rumuz = '$rumuz'";
	 if ($sayfa_args[1] != "ekle") $sql .= " AND uid != {$hesap->uid}";
     $result = mysql_query($sql, $connection);
	 if (mysql_num_rows($result) != 0) $hatalar['rumuz'] = "Bu rumuz kullanÄ±lÄ±yor.";
  }
  $pass1 = $_POST['pass1']; $pass2 = $_POST['pass2'];
  if ($pass1 != $pass2) $hatalar['sifre'] = "Şifrefreler birbirini tutmuyor.";
  elseif ($sayfa_args[1] == "ekle" && $pass1 == "") $hatalar['sifre'] = "Şifre boş bırakılamaz.";
  if (substr_count($_POST['mail'], "@") != 1) $hatalar['mail'] = "E-posta adresi yanlnış girilmiş.";

  if (count($hatalar) == 0) {  // hiÃ§ hata bulunmamÄ±ÅŸ
  	 $rumuz = htmlspecialchars($_POST['rumuz']);  // html etiketlerine ve hacker'lara karÅŸÄ± Ã¶nlem
  	 $isim = htmlspecialchars($_POST['isim']);  // html etiketlerine ve hacker'lara karÅŸÄ± Ã¶nlem
	 $pass = ($pass1=="") ? $hesap->pass : md5($pass1); // ÅŸifreler boÅŸ bÄ±rakÄ±lÄ±p gÃ¼ncelleme yapÄ±labilir
	 $mail = htmlspecialchars($_POST['mail']); // html etiketlerine ve hacker'lara karÅŸÄ± Ã¶nlem
	 $role = $_POST['rol'];
 	 $admin = (isset($_POST["admin"])) ? "1" : "0";
     // sorgumuzu hazÄ±rlÄ±yoruz
	 $sql_set = "SET rumuz = '$rumuz', isim = '$isim', pass = '$pass', mail = '$mail'";
	 if (isset($_POST['rol'])) $sql_set .= ", role = '$role'";
	 $sql_set .= ", admin = $admin";
	 if ($sayfa_args[1] == "ekle") $sql = "INSERT INTO users $sql_set";
	 else $sql = "UPDATE users $sql_set WHERE uid = {$hesap->uid}";
     $result = mysql_query($sql, $connection);
	 if (mysql_affected_rows() != 1) {  // sorgu UPDATE olduÄŸu iÃ§in mysql_num_rows yerine bunu kullanÄ±yoruz
		add_message("MYSQL hatası: " . mysql_error());
		add_message("Sorgu: " . $sql);
		add_message(print_r($_POST,true));
	 }
	 else {  // gÃ¼ncelleme baÅŸarÄ±lÄ± hesap sayfasÄ±nÄ± gÃ¶ster
	    if ($sayfa_args[1] == "ekle") {
	    	$sql = "SELECT * FROM users WHERE rumuz = '$rumuz'";
			$result = mysql_query($sql, $connection);
			$hesap = mysql_fetch_object($result);
	    	$url = "?sayfa=hesap/$hesap->uid";  // uid otomatik atandÄ±ÄŸÄ±ndan mecburen sorguladÄ±k
		}
	    else $url = substr($_SERVER['HTTP_REFERER'], 0, -5); // sonraki '/edit'i (5 karakter) attÄ±k.
	    header("Location: $url");
	    exit;
	 }
  }
}

if ($sayfa_args[1] == "ekle") { // yeni kullanÄ±cÄ± ekliyoruz
  $form_values["rumuz"] = "";
  $form_values["isim"] = "";
  $form_values["mail"] = "";
  $form_values["rol"] = "User";
  $form_values["admin"] = 0;
}
else {
  $form_values["rumuz"] = $hesap->rumuz;
  $form_values["isim"] = $hesap->isim;
  $form_values["mail"] = $hesap->mail;
  $form_values["rol"] = $hesap->role;
  $form_values["admin"] = $hesap->admin;
}
if (count($hatalar)>0) {
   foreach($hatalar as $key => $val) {
   	  add_message($val);
   }
   if (!isset($_FILES['yeni-resim'])) {  // form'da daha Ã¶nce girilen deÄŸerleri gÃ¶stermek iÃ§in
     $form_values["rumuz"] = $_POST["rumuz"];
     $form_values["isim"] = $_POST["isim"];
     $form_values["mail"] = $_POST["mail"];
     $form_values["rol"] = $_POST["rol"];
     $form_values["admin"] = (isset($_POST["admin"])) ? 1 : 0;
   }
}

$content .= "<form action='?sayfa={$_GET['sayfa']}' method=post>\n";
$content .= "<table id='hesap-form'>\n";
$content .= isset($hatalar['isim']) ? "<tr class='hata'>" : "<tr>";
$content .= "<td>İsim</td><td>:</td>";
$content .= "<td><input type='text' name='isim' value='{$form_values['isim']}'></td></tr>\n";
$content .= isset($hatalar['rumuz']) ? "<tr class='hata'>" : "<tr>";
$content .= "<td>Rumuz</td><td>:</td>";
$content .= "<td><input type='text' name='rumuz' value='{$form_values['rumuz']}'></td></tr>\n";
$content .= isset($hatalar['sifre']) ? "<tr class='hata'>" : "<tr>";
$content .= "<td>Şifre</td><td>:</td><td><input type='password' name='pass1'></td></tr>\n";
$content .= isset($hatalar['sifre']) ? "<tr class='hata'>" : "<tr>";
$content .= "<td>Şifre Teyid</td><td>:</td><td><input type='password' name='pass2'></td></tr>\n";
$content .= isset($hatalar['mail']) ? "<tr class='hata'>" : "<tr>";
$content .= "<td>E-posta</td><td>:</td>";
$content .= "<td><input type='text' name='mail' value='{$form_values['mail']}'></td></tr>\n";
if ($sayfa_args[1] == "ekle" || ($user->admin && $hesap->uid!=1)) {   // 1 numaralÄ± kullanÄ±cÄ±nÄ±n bu bilgileri deÄŸiÅŸtirilemez
   $content .= "<tr><td>Kullanıcı tipi</td><td>:</td>";
   $content .= "<td><select name='rol'>";
   $selected['User'] = $form_values["rol"]=="User" ? " selected":"";
   $selected['Power User'] = $form_values["rol"]=="Power User" ? " selected":"";
   $content .= "<option value='User'{$selected['User']}>User</option>";
   $content .= "<option value='Power User'{$selected['Power User']}>Power User</option>";
   $content .= "</select></td></tr>";
   $content .= "<tr><td>Yönetici</td><td>:</td>";
   $checked = $form_values["admin"] ? "checked" : "";
   $content .= "<td><input type='checkbox' name='admin' value='1' $checked>Evet</td></tr>";

}
$submit_text = ($sayfa_args[1] == "ekle") ? "Ekle" : "Değiştir";
$content .= "<tr><td colspan=3><input type='submit' value='$submit_text'></td></tr>\n";
$content .= "</table></form>";

// resim yÃ¼klemek iÃ§in ayrÄ± bir form lazÄ±m

$content .= <<<EOT
<form method="post" enctype="multipart/form-data">
 	<b>Yeni resim yükle</b> :
	<br><input type="file" name="yeni-resim" size='35'>
 	<br><input type="submit" value="yükle">
</form>
EOT;

?>
