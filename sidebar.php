<div id="sagsutun">
<div class="sagust"></div>
<div class="solust"></div>
<div class="sagicerik">
<?php if($user->uid == 0) : ?>
<form action="index.php?sayfa=<?php print $_GET['sayfa']; ?>" method="post">
    <h4>Kullanıcı Adı</h4>
    <input type="text" size=15 name="rumuz"/>
    <h4>Şifre</h4>
    <input type="password" size=15 name="sifre"/><br>
    <input type="hidden" name="form-id" value="giris"/>
    <input type="submit" value="Giriş" />
    </form>

<?php else : ?>
    <h3 ><span><?php print $user->isim; ?></span></h3>
    <ul id="category"  class='sidebarlinkleri'>
        <li><a href="?sayfa=hesap/<?php print $user->uid; ?>">Hesabım</a></li>
        <li><a href="?sayfa=myfavourites/<?php print $user->uid; ?>">Beğendiğim Kitaplar</a></li>
        <?php if ($user->admin) : ?>
        <li><a href="?sayfa=hesap/ekle">Kullanıcı Ekle</a></li>
        <li><a href="?sayfa=kitapekleform/ekle">Yeni Kitap Ekle</a></li>
        <li><a href="?sayfa=turler/ekle">Kitap Türü Ekle</a></li>
         <li><a href="?sayfa=yayinevleri/ekle">Yayınevi Ekle</a></li>
        <li><a href="?sayfa=yazarekle/ekle">Yazar kayıt formu</a></li>
        <?php endif; ?>
        <li><a href="?sayfa=logout">Çıkış</a></li>
    </ul>
<?php endif ?>
</div>
<div class="sagalt"></div>
<div class="solalt"></div><br/>

<div class="sagust"></div>
<div class="solust"></div>
<div class="sagicerik">
    <h3><?php print $category_title; ?></h3>
    <?php
               $sorgu = "SELECT * FROM turler";
               $result = mysql_query($sorgu);
               $turler = array();
               while ($tur = mysql_fetch_object($result)) {
                 $turler[] = $tur;
               }
               $category = "<ul  class='sidebarlinkleri'>";
               foreach ($turler as $tur) {
                   $category .= "<li><a href='?sayfa=turegorekitaplar/{$tur->tur_no}'>" . $tur->t_isim . "</a></li>";
               }
               $category .= "</ul>";
               print $category;
               ?>

</div>
<div class="sagalt"></div>
<div class="solalt"></div><br/>

<div class="sagust"></div>
<div class="solust"></div>
<div class="sagicerik">
    <h3><?php print $son_kitaplar; ?></h3>
    <?php
               $sorgu = "SELECT * FROM kitaplar WHERE ekletarih >=1243148828 ORDER BY k_isim DESC LIMIT 4";
               $result = mysql_query($sorgu);
               $kitaplar = array();
               while ($kit = mysql_fetch_object($result)) {
                 $kitaplar[] = $kit;
               }
               $category = "<ul class='sidebarlinkleri'>";
               foreach ($kitaplar as $kit) {
                   $category .= "<li><a href='?sayfa=kitap/$kit->kitap_no'>$kit->k_isim</a></li>";
               }
               $category .= "</ul>";
               print $category;
               ?>
</div>

<div class="sagalt"></div>
<div class="solalt"></div><br/>

<div class="sagust"></div>
<div class="solust"></div>
<div class="sagicerik">
    <h3><?php print $Linkler; ?></h3> 
    <marquee onmouseout="this.start()" onmouseover="this.stop()" direction="up" scrollamount="2" height="75" loop="infinite">
    <ul class='sidebarlinkleri'>
  
                    <li><a href="<?php print $Kitapyurdu; ?>">Kitapyurdu</a></li>
					<li><a href="<?php print $İdefixe; ?>">İdefixe</a></li>
					<li><a href="<?php print $Pandora; ?>">Pandora</a></li>
					
                </ul></marquee>
</div>
<div class="sagalt"></div>
<div class="solalt"></div>
</div>


