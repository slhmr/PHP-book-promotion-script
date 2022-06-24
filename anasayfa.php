<?php
$page_title = "Sayfamıza Hoşgeldiniz";
$sorgu = "SELECT k.kitap_no,yay.yayinevi_no,y.yazar_no,k_isim,y_isim,yay.yay_isim,kapak_resim FROM kitaplar as k,yayinevleri as yay,yazarlar as y
        WHERE k.yazar_no=y.yazar_no AND k.yayinevi_no=yay.yayinevi_no AND ekletarih >=1243148828 ORDER BY k_isim DESC LIMIT 3";
$result = mysql_query($sorgu); 

$x=1;
$content .="<br><table cellspacing='20px'><tr>
<td colspan='3'><h4>Son Eklenen Kitaplar</h4><hr width='30%' align='left'></td></tr><tr>

";
	while ($kitap = mysql_fetch_object($result)) {
           
$content .="<td>
           <table cellspacing='5px'>
            <tr><td colspan='2'><img class='kapakresim' src='images/Kitap_Kapak/$kitap->kapak_resim'></td></tr>
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


$sorgu = "SELECT k.kitap_no,yay.yayinevi_no,y.yazar_no,k_isim,y_isim,yay.yay_isim,kapak_resim FROM kitaplar as k,yayinevleri as yay,yazarlar as y
        WHERE k.yazar_no=y.yazar_no AND k.yayinevi_no=yay.yayinevi_no AND (views>10) ORDER BY k_isim DESC LIMIT 3";
$result = mysql_query($sorgu);


$x=1;
$content .="<br><table cellspacing='20px'><tr>
<td colspan='3'><h4>En Çok Okunan Kitaplar</h4><hr width='50%' align='left'></td></tr><tr>";
	while ($kitap = mysql_fetch_object($result)) {

$content .="<td>
           <table cellspacing='5px'>
            <tr><td colspan='2'><img src='images/Kitap_Kapak/$kitap->kapak_resim' class='kapakresim'></td><tr>
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
