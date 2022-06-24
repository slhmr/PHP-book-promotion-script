<?php
// setlocale(LC_ALL, 'tr_TR.UTF-8'); // do�rusu bu
setlocale(LC_ALL, 'turkish'); // sunucu windows'da ise bunu kullanmak laz�m
session_start();
// hangi tip hatalar� ekranda g�stersin:

iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");

// veri taban� ba�lant�s�
$connection = mysql_connect('localhost', 'salihemrekul', '0403030024');
if (!$connection) {
    die("MYSQL'e bulunamadı: " . mysql_error());
}
else {
	$db_selected = mysql_select_db('salihemrekul', $connection);
    if (!$db_selected) {
      die ('Tabloya erişilemiyor: ' . mysql_error());
    }
}

include "settings.php";  // ayarlar, global de�i�kenler
include "utilities.php"; // yard�mc� fonksiyonlar

$sayfa = isset($_GET["sayfa"]) ? $_GET["sayfa"] : "anasayfa";
$sayfa_args = split("/",$sayfa);
include_once("kullanici.php");
switch($sayfa_args[0]) {
	case "hesap"    : include "hesap.php"; break;
	case "anasayfa" : include "anasayfa.php"; break;
    case "tumkitaplar" : include "tumkitaplar.php"; break;
	case "kitaplar" : include "kitaplar.php"; break;
    case "guncelle" : include "guncelle.php"; break;
	case "kitap"    : include "kitap.php"; break;
    case "turler"   : include "turler.php"; break;
    case "yazarlar"   : include "yazarlar.php"; break;
    case "iletisim"   : include "iletisim.php"; break;
    case "turegorekitaplar"   : include "turegorekitaplar.php"; break;
    case "kitapekleform"    : include "kitapekleform.php"; break;
    case "myfavourites"    : include "myfavourites.php"; break;
    case "addfavourite"   : include "addfavourite.php"; break;
    case "yazarekle"    : include "yazarekle.php"; break;
    case "yazar"    : include "yazar.php"; break;
    case "yayinevleri"    : include "yayinevleri.php"; break;
    case "tumyayinevleri"   : include "tumyayinevleri.php"; break;
    case "yayinevi"   : include "yayinevi.php"; break;
    default : page_not_found();
}

include "header.php";
include "sidebar.php";
include "main_content.php";
include "footer.php";
mysql_close($connection);
?>