<?php
 /*bu kısım ile veri tabanındaki tüm yayin evleri listelendi ve yayın evine bağlantı verildi*/
$page_title = "Yayınevleri";
$title .= " | Yayınevleri";
$sorgu1 = "SELECT * FROM yayinevleri ORDER BY yay_isim";
$result = mysql_query($sorgu1);
        $yayinevleri1 = array();
        while ($yay1 = mysql_fetch_object($result)) {
                 $yayinevleri1[]= $yay1;
               }

$content .= "   <style>td{vertical-align: top;}</style>
                <table cellspacing='15px'><tr><td>Kayıtlı yayinevleri<hr><ul class='sayfalink'>" ;
               foreach ($yayinevleri1 as $yay1) {
$content .="<li><a href='?sayfa=yayinevi/{$yay1->yayinevi_no}'>$yay1->yay_isim</a></li>";
                   }
$content .= "</ul></td><td></td></tr></table>" ;

?>

