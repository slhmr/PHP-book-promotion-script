<?php
  $page_title = "Kayıtlı Kitaplar";
  $title .= " | Kitaplar";



 $sql    = " SELECT * FROM kitaplar AS k, yazarlar AS y, yayinevleri AS m
             WHERE k.yazar_no = y.yazar_no and k.yayinevi_no = m.yayinevi_no ORDER BY k_isim";
  $result = mysql_query($sql, $connection);

 
 $x=1;
$content .="<table cellspacing='20px'><tr>";
	  while ($kitap = mysql_fetch_object($result)) {


$content .="<td>
           <table cellspacing='5px'>
            <tr><td colspan='2' class='sayfalink'><li><a href='?sayfa=kitap/$kitap->kitap_no'>$kitap->k_isim</a></li></td><tr>
            <tr><td>Yazar</td><td>:<a href='?sayfa=yazar/$kitap->yazar_no'>$kitap->y_isim</a></td></tr>
            <tr><td>Yayınevi</td><td>:<a href='?sayfa=yayinevi/$kitap->yayinevi_no'>$kitap->yay_isim</a></td></tr>
            </table></td>";
if ($x==3){
 $content .="</tr>
               <tr>";
           $x=0;
           }
           $x++;
	     }
$content .="</tr></table>";
  
?>
