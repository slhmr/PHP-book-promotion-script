<?php


$ysorgu="SELECT * FROM kitaplar as k,yayinevleri as yay,yazarlar as y
        WHERE k.yazar_no=y.yazar_no AND k.yayinevi_no=yay.yayinevi_no AND y.yazar_no=". $sayfa_args[1];
$result = mysql_query($ysorgu);

$s="SELECT y_isim FROM yazarlar WHERE yazar_no=$sayfa_args[1]";
$result1 = mysql_query($s);
$kl = mysql_fetch_object($result1);
$page_title =$kl->y_isim."-Tum Kitapları";
$kac=mysql_num_rows($result);
if($kac !=0){
    $x=1;

	   while ($k = mysql_fetch_object($result)) {
$content .="<font size='1'><table ><tr>";
$content .="<td>
           <table>
            <tr><td><img src='images/Kitap_Kapak/$k->kapak_resim' class='kapakresim' align='center'></td></tr>
            <tr><td><a href='?sayfa=kitap/$k->kitap_no'>$k->k_isim</a></td><tr>
            <tr><td><a href='?sayfa=yazar/$k->yazar_no'>$k->y_isim</a></td></tr>
            <tr><td><a href='?sayfa=yayinevi/$k->yayinevi_no'>$k->yay_isim</a></td></tr>";
 $content .=" </table>

       </td>";
           if ($x==3){
 $content .="</tr>
               <tr>";
           $x=0;
           }
           $x++;
	     }
$content .="</table></font>";
}
    else{
$page_title =$kl->y_isim."-Tum Kitapları";
$content .="
        <table cellspacing='30px' cellpadding='20px'>
        <tr><td class='hata'>Yazarın kayıtlı kitabı bulunmamaktadır </td></tr>
        <tr><td><a href='?sayfa=yazar/$sayfa_args[1]'><< Geri Dön</a></td></tr></table>";
        
       }
?>