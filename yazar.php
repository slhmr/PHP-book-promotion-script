<?php
  $sql= "SELECT y_isim,ozgecmis,resim FROM yazarlar where yazar_no = " . $sayfa_args[1];
  $result = mysql_query($sql);
  $yazar = mysql_fetch_object($result);

  $page_title = $yazar->y_isim;
  $title .= " - " . $yazar->y_isim;

 $ysorgu="SELECT k.kitap_no,yay.yayinevi_no,y.yazar_no,k_isim,y_isim,yay.yay_isim,kapak_resim FROM kitaplar as k,yayinevleri as yay,yazarlar as y
        WHERE k.yazar_no=y.yazar_no AND k.yayinevi_no=yay.yayinevi_no AND y.yazar_no=". $sayfa_args[1];
$resy = mysql_query($ysorgu);


$content .= "<br><table ><tr><td><img src='images/Yazarlar/$yazar->resim' class='kapakresim'><br>";
$content .="<a href='?sayfa=tumkitaplar/{$sayfa_args[1]}'>Tüm Kitapları</a></td>
             <td></td><td valign='top'>
<b>Yazarın Özgeçmişi:</b><br>$yazar->ozgecmis</td></tr></table><br><br><br>";




$content .="Son Cıkan kitapları<hr width='30%' align='left'>";
$a=1;
$content .="<table ><tr>";
	   while ($kyazar = mysql_fetch_object($resy)) {
    
$content .="<td><font size='1'><table><tr><td colspan='2'><img src='images/Kitap_Kapak/$kyazar->kapak_resim' class='kapakresim' align='leftt'></td></tr>
            <tr><td colspan='2'><a href='?sayfa=kitap/$kyazar->kitap_no'>$kyazar->k_isim</a></td></tr>
           <tr><td>Yazarı</td><td>: <a href='?sayfa=yazar/$kyazar->yazar_no'>$kyazar->y_isim</a></td></tr>
           <tr><td>Yayınevi</td><td>:<a href='?sayfa=yayinevi/$kyazar->yayinevi_no'>$kyazar->yay_isim</a></td></tr>";
$content .=" </table></font><td>";
           if ($a==3){
$content .="</tr><tr>";
           $a=0;
           }
           $a++;
}
 $content .="</table>";














?>