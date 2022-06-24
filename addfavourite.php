<?php
$page_title=" Begendiğim Kitaplar";
$id=$sayfa_args[1];
$kullanici=$user->uid;
$hatalar = array();
$result = mysql_query("SELECT id,kitabid,userid FROM favourites WHERE userid =$kullanici");
$number = mysql_num_rows($result);
while ($fav = mysql_fetch_object($result)) {
	     $favoriler[] = $fav->kitabid;
    if (in_array($id,$favoriler)) {
         
	     $hatalar['kayitli'] = " Favorilerinize daha önce eklediniz";
	   }

	   }
if(count($hatalar) == 0){
      $sorgu = "INSERT INTO favourites (kitabid,userid) VALUES ('$id','$kullanici')";
	    mysql_query($sorgu);
$content .="<br>
        <table cellspacing='30px' cellpadding='20px' >
<tr><td colspna='2'>Ekleme İşlemi Başarıyla Gerçekleştirildi</td></tr>
 <tr><td><a href='?sayfa=kitaplar/'> << Kitaplar Sayfasına Dön</a></td><td><a href='?sayfa=myfavourites/$user->uid'>  Favori Kitaplarıma Git >></a></td></tr>
 
</table>";
 }
else{
$content .="
        <table cellspacing='30px' cellpadding='20px'>
        <tr><td class='hata'>".$hatalar['kayitli']."</td></tr>
        <tr><td><a href='javascript:history.back()'> << Geri Dön</a></td></tr></table>";

}

?>
