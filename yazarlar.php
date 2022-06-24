<?php
$page_title="Yazarlar";
$title="Yazarlar";
$sorgu = "SELECT yazar_no,y_isim,ozgecmis FROM yazarlar order by y_isim";
       $result = mysql_query($sorgu);
       $yayinevleri = array();
        
  if (!$result) {
             $content .= "DB Error, could not query the database\n";
             $content .=  'MySQL Error: ' . mysql_error();
          }
 while ($yaz = mysql_fetch_object($result)) {
         $yayinevleri[] = $yaz;
       }          
$content .= "   <style>td{vertical-align: top;}</style>
                <table cellspacing='15px'><tr><td>Siteye Kayıtlı Yazarlarımız<hr><ul class='sayfalink'>" ;
               foreach ($yayinevleri as $yay) {
$content .="<li><a href='?sayfa=yazar/{$yay->yazar_no}'>$yay->y_isim</a></li>";
                   }
$content .= "</ul></td><td></td></tr></table>" ;

      

       ?>
