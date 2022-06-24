            <div id="solsutun">

       <div id="solicerik">
        <div class="sagust"></div>
		<div class="solust"></div>
            <h2><?php print $page_title; ?></h2>
        <div class="sagalt"></div>
		<div class="solalt"></div>
        <?php
		   if ($messages) {
		   	  print "<ul id='messages'>$messages</ul>";
           }
           print $content;
          	?>

      </div> <!-- /sol icerik -->
        </div> <!-- /sol sutun -->

		