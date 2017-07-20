<?php
require ("lib-obrazok.php"); 

$rozsirenia = $wpdb->get_results("SELECT DISTINCT obrazok, urlid FROM mozsk_rozsirenia");
	if($rozsirenia)
	{
		foreach ($rozsirenia as $rozsirenie) 
		{
			echo "<strong>{$rozsirenie->urlid}</strong> - {$rozsirenie->obrazok} - ";
			if($rozsirenie->obrazok)
			{
				$p = strpos($rozsirenie->obrazok, ".png");
				$x = substr($rozsirenie->obrazok, 0, $p);
				if(bp_img_vyrobZmenseninu("/home/epicnet/mozilla.sk/wp-content/images/rozsirenia/", $rozsirenie->obrazok, $x))
				{
					echo " OK";
				}
				else
				{
					echo " ERROR!";
				}
			}
			echo "<br />";
		}
	}
?>
<div class="updated">
	<p><strong>Prekopané !</strong></p>
</div>
<?php
require_once("form-zoznam.php");
?>