<?php
$page_title=" Begendiğim Kitaplar";
//$sayfa_args[1] kullanıcı no ile eşit
if (isset($_GET["act"])) {
       $act = $_GET["act"];

      if (isset($_GET["id"]))
          $id = trim($_GET["id"]);
      else
          die();


      //DELETE AN IMAGE FROM FAVOURITES
      if ($act == "delete") {

          mysql_query("DELETE FROM favourites WHERE kitap_no = '$id' AND userid = '$sayfa_args[1]'");
         echo "Seçilen Kitap Favorilerinizden Kaldırıldı..!!!";
 echo  "<br><br><a href='?sayfa=myfavourites/$sayfa_args[1]'>buraya tıklayarak</a> Favori listenize geri dönebilirsiniz";
          

      }
   }
else{
           $max_show = 6;
           $total = 0;

           if (isset($_GET["page"]))
               $page = $_GET["page"];
           else
               $page = 1;
$content .= "<center>";
$q = "SELECT id, kitabid FROM favourites WHERE userid = '$sayfa_args[1]' ORDER BY id DESC";
$result= mysql_query($q) ;
$number = mysql_num_rows($result);
if ($number) {
            while ($row = mysql_fetch_array($result)) {
                  $id = $row['kitabid'];
                  $idfavourite[] = $row['id'];

                  $r = mysql_query("SELECT k_isim,y_isim,yay_isim,tarih,rumuz,kitap_no FROM users As u,kitaplar As k,yazarlar As y, yayinevleri As yay
                                    WHERE kitap_no = '$id' AND u.uid='$sayfa_args[1]' AND
                                    k.yazar_no=y.yazar_no AND k.yayinevi_no=yay.yayinevi_no");
                  $n = mysql_num_rows($r);
                  if ($n) {
                      $row1 = mysql_fetch_array($r);
                      $no[]=$row1['kitap_no'];
                      $ids[] = $row1['k_isim'];
                      $details[] = $row1['y_isim'];
                      $views[] = $row1['yay_isim'];
                      $date[] = $row1['tarih'];
                      $type[] = $row1['rumuz'];
                      $total++;
                  }
              }


              $from2 = $page * $max_show;
              if ($from2 > $total)
              {
                 $diff = $total % $max_show;
                 $from2 = $total;
                 $from1 = $from2 - $diff;
              }
              else
                 $from1 = $from2 - $max_show;




              if ($total) {
$content .= "<br><table font-size='16px' width='100%'>";
$content .= "<tr height='40px' bgcolor=\"#eee\"><td><center><b>Kitabın Adı</b></center></td>";
$content .= "<td><center><b>Yazarı</b></center></td>";
$content .= "<td><center><b>Yayınevi</b></center></td>";
$content .= "<td><center><b>Basım Tarihi</b></center></td>";
$content .= "<td><center><b>İşlemler</b></center></td>";
$content .= "</tr>";

//YAZDIRALIM
               for ($i=$from1; $i < $from2; $i++){
$content .= "<tr align=center>";$id = $ids[$i];
$content .= "<td> <a href='?sayfa=kitap/{$no[$i]}'>{$ids[$i]}</a> </td>";
$content .= "<td width='180px'> {$details[$i]}</td>";
$content .= "<td> {$views[$i]} </td>";
$content .= "<td> {$date[$i]}  </td>";

$content .= "<td>";
$content .= "<a href='myfavourites.php?id={$idfavourite[$i]}&act=delete'>Delete</a>";
$content .= "</td></tr>";
               }

$content .= "</table></center></form>
                <table width='100%'><tr>
                <td align='right' width='50%'>&nbsp;";

               if ($from1 > 0){
                  $previous = $page - 1;
$content .= "<a href='myfavourites.php?page=$previous'><<Bir önceki Sayfa </a>";
               }
$content .= "</td>";


$content .= "<td align=left width=50%>&nbsp;&nbsp;&nbsp;";
               if ($from2 < $total)
               {
                  $next = $page + 1;
$content .= "<a href='myfavourites.php?page=$next'>Bir Sonraki Sayfa >></a>";
               }
$content .= "</td></tr></table>";

             }
             else
$content .= "<br><center>Henüz bir kitap eklemediniz!</center>";

          }
          else
$content .= "<br><center>Kayıtlı kitap bulunmamaktadır!</center>";

}

$content .= "<br><br><center><a href='?sayfa=hesap/$sayfa_args[1]'>Hesabıma Git</a></center>";



?>
