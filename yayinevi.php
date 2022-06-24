<?php
$sorgu="SELECT *FROM kitaplar as k,yayinevleri as yay,yazarlar as y WHERE k.yazar_no=y.yazar_no
                AND k.yayinevi_no=yay.yayinevi_no AND yay.yayinevi_no=".$sayfa_args[1]." ORDER BY k_isim";
$result = mysql_query($sorgu);
$kac=mysql_numrows($result);
if ($kac !=0){
$a=1;
$content .="<table><tr>";
            while ($k = mysql_fetch_object($result)) {
            $kitap['kitap_no']=$k->kitap_no;
            $yazar['yazar_no']=$k->yazar_no;
            $yayinevi['yayinevi_no']=$k->yazar_no;
            $yayinevi['yay_isim']=$k->yay_isim;
            $yayinevi['yayinevi_no']=$k->yayinevi_no;
 


$content .="<td><font size='1'><table>
<tr><td><img src='images/Kitap_Kapak/$k->kapak_resim' class='kapakresim'></td></tr>
<tr> <td>
          <table><tr><td colspan='2'><a href='?sayfa=kitap/{$kitap['kitap_no']}'>$k->k_isim</a></td></tr>
                 <tr><td>Yazarı</td><td>:<a href='?sayfa=yazar/{$yazar['yazar_no']}'>$k->y_isim</a></td></tr>
                 <tr><td>Yayınevi</td><td>:<a href='?sayfa=yayinevi/{$yayinevi['yayinevi_no']}'>$k->yay_isim</a></td></tr></table>";

$content .="</td></tr></table></font></td>";
           if ($a==4){
$content .="</tr><tr>";
           $a=0;
           }
           $a++;
}
$content .="</table>";
$page_title .=$yayinevi['yay_isim']." Kitap Listesi";
}
else{
  $page_title .="Yayinevlerine göre kitaplar"; 

  $content .="
        <table cellspacing='30px' cellpadding='20px'>
        <tr><td class='hata'>Yayınevine Kayıtlı Kitap bulunmamaktadır..</td></tr>
        <tr><td><a href='javascript:history.back()'> << Geri Dön</a></td></tr></table>";
           
}
?>