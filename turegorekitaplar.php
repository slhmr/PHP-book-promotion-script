<?php

$sorgu="SELECT k.kitap_no,t.t_isim,yay.yayinevi_no,y.yazar_no,k.k_isim,y.y_isim,yay.yay_isim,k.kapak_resim FROM
                kitaplar As k,turler As t,kitapturler As kt,yayinevleri As yay,yazarlar As y
                WHERE kt.kitap_no=k.kitap_no AND k.yazar_no=y.yazar_no AND k.yayinevi_no=yay.yayinevi_no
                AND kt.tur_no=t.tur_no AND t.tur_no=$sayfa_args[1] AND kt.tur_no=$sayfa_args[1]";
$result = mysql_query($sorgu);
$kac=mysql_num_rows($result);
if($kac !=0){
    $a=1;
$content .="<table cellspacing='30px' cellpadding='20px' ><tr>";
	   while ($k = mysql_fetch_object($result)) {
           $kitap['kitap_no']=$k->kitap_no;
           $kitap['tur']=$k->t_isim;
           $yazar['yazar_no']=$k->yazar_no;
           $yayinevi['yayinevi_no']=$k->yazar_no;
           $yayinevi['yayinevi_no']=$k->yayinevi_no;
           $page_title =$kitap['tur']." Türüne Ait Kitaplar";
$content .="<td><font size='1'>
           <table>
            <tr><td align='center'><img src='images/Kitap_Kapak/$k->kapak_resim' class='kapakresim' align='left'></td></tr>
            <tr><td> <a href='?sayfa=kitap/{$kitap['kitap_no']}'>$k->k_isim</a></td></tr>
            <tr><td> <a href='?sayfa=yazar/{$yazar['yazar_no']}'>$k->y_isim</a></td></tr>
            <tr><td><a href='?sayfa=yayinevi/{$yayinevi['yayinevi_no']}'>$k->yay_isim</a></td></tr>";
$content .="</table></td>";
           if ($a==4){
$content .="</tr><tr>";
           $a=0;
           }
           $a++;
}
$content .="</table></font>";
           }
    else{
$page_title="Türe Göre Kitaplar";
$content .="
        <table cellspacing='30px' cellpadding='20px'>
        <tr><td class='hata'>Türe kayıtlı kitap bulunmamaktadır</td></tr>
        <tr><td><a href='javascript:history.back()'> << Geri Dön</a></td></tr></table>";
}
?>