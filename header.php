<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="cs" />
    <meta name="robots" content="all,follow" />
        <link rel="stylesheet" type="text/css" href="<?php print $css_template; ?>/style.css" media="screen"/>
		<title><?php print $title;?></title>
        <meta name="description" content="Kitap tanıtım sitesi" />
        <meta name="keywords" content="kitap,kitaplar,son,cıkan,en,çok,okunan" />
        <link rel="index" href="./" title="Home" />
        </head>

<body>
<!-- Main -->
<div id="icerik">
	<div id="icerik2">
   <div id="Header">
   		 <h1><a href="./" title="Ana Sayfaya Dönüş"><?php print $header_title;?></a></h1>
    <!-- Main menu (tabs) -->
    
     <div class="headermenu">
            <ul>
            	<?php
				   foreach ($tabs as $tab_text => $tab_url) {
				   	  $item = ($tab_url == $active_tab)? '<li>' : '<li>';
					  $item .= "<a href='?sayfa=$tab_url'>";
					  $item .= $tab_text;
					  $item .= '</a></li></li>';
                      print $item;
				   }
				?>
               </ul>
        </div>
        
     </div> <!-- /header -->



