<?php
	$GonderilecekMail = 'salihemrekul@hotmail.com';

/*	$SiteAdres = $siteurl; */
?>
<?php
	
    $title="iletisim";
    $page_title="Site Yönetimi İle İletişim Bölümü";
	if(isset( $_POST["Gonder"]) ) // Formun gonderilip gonderilmedigi kontrol ediliyor
	{
		## Bilgiler aliniyor ##
		$Ad = trim( $_POST["ad"] );
		$Konu = trim( $_POST["konu"] );
		$Email = trim( $_POST["email"] );
		$Mesaj = trim( $_POST["mesaj"] );
		$IP = $_SERVER['REMOTE_ADDR'];
		$Tarih = date("d.m.Y");
		

		## Bilgiler kontrol ediliyor ##
		if( !$Ad || !$Konu || !$Email || !$Mesaj )
		{
		$content .= "<p>Lütfen bütün alanları doldurunuz!<br><br><a href='javascript:history.back()'>« Geri</a></p>";
			exit();		}
		if( !ereg( "^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$",$Email ) )
		{
			$content .= "<p>Geçersiz E-Mail adresi girdiniz. Lütfen doğru bir E-Mail adresi giriniz!<br><br><a href='javascript:history.back()'>« Geri</a></p>";
			exit();
		}
  $content .= "<p>
<img src='Style/images/ileti.jpg'></p><br>
Sitenizden $Tarih tarihinde <b>$IP</b> ip'si kullanılarak size mesaj gönderildi. Mesajın içeriği aşağıdaki gibidir.<br><br>
Gönderen: <b>$Ad $Soyad</b><br>
E-Mail: <b>$Email</b><br>
Mesaj: <b>". nl2br( htmlspecialchars( $Mesaj ) ) ."</b><br>

		";

		if ( !@mail( $GonderilecekMail,$Konu,$Mail,"MIME-Version:1.0\nContent-Type:text/html;charset=utf-8\nFrom: $Ad $Konu<$Email>\n" ) )
			$content .= "<p><br>
			<b>Mesaj gönderilirken hata oluştu.</b></p><p>Lütfen tekrar deneyiniz.<br><br><a href='javascript:history.back()'>« Geri</a></p>";
		else 
			$content .= "<p><b>Mesaj başarıyla gönderildi.</b></p><p>Size en kısa zamanda bu konu hakkında bilgi verilecektir.<br><br><a href='javascript:history.back()'>« Geri</a></p>";
	}
	else 
	{

    
$content .="

<br>
<table>
<tr><td colspan='2'><img src='Style/images/ileti.jpg'></td></tr>
<form id='form1' name='form1' method='post' action='{$_SERVER['REQUEST_URI']}'>
  <tr><td width='170' align='left'><font face='Tahoma' style='font-size: 9pt; font-weight: 700'>Adınız Soyadınız :</font></td><td width='367'><input type='text' name='ad' size='30'/></td></tr>
  <tr><td align='left'><font face='Tahoma' style='font-size: 9pt; font-weight: 700'>E-posta adresiniz:</font></td><td><input type='text' name='email' size='30' /></td></tr>
  <tr><td align='left'><font face='Tahoma' style='font-size: 9pt; font-weight: 700'>Konu:</font></td><td><input type='text' name='konu' size='30' /></td></tr>
  <tr><td align='left'><font face='Tahoma' style='font-size: 9pt; font-weight: 700'>Mesaj:</font></td><td><textarea name='mesaj' cols='31' rows='7'></textarea></td></tr>
  <tr><td colspan='2'><div align='right'><p align='center'><input type='submit' name='Gonder' value='Gönder ' style='font-family: Tahoma; font-size: 10pt' />
	</td></tr></form></table>";
    
}
?>