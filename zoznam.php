<?php
$folder = '/rozsirenia/';
$stranka = get_query_var('rozsirenie');
if($stranka == "firefox") msk_filter();
 	    else msk_newupdate();


function msk_filter() 
{
	$rozsirenia = $wpdb->get_results("SELECT * FROM mozsk_rozsirenia WHERE publikovat=1 AND urcene_ff_od!='' GROUP BY noazov ORDER BY nazov ASC");
	if($rozsirenia)
	{
		
		echo '<dl>';
		foreach ($rozsirenia as $rozsirenie) 
		{
		echo '<dt>';
		echo '<a href="'.$folder.$rozsirenie->urlid.'">'.$rozsirenie->nazov.'</a></dt>';
		echo '<dd>';
		if (strlen($rozsirenie->popis) > 200) echo substr(strip_tags(trim($rozsirenie->popis)) , 0, 200) . "...";
		else echo $rozsirenie->popis;
		echo '</dd>';

		}
		echo '</dl>';
	}
}


function msk_newupdate() 
{

	$rozsirenia = $wpdb->get_results("SELECT * FROM mozsk_rozsirenia WHERE publikovat=1 AND starsie='' HAVING datum>CURDATE()-7 ORDER BY nazov ASC");
	if($rozsirenia)
	{
		
		echo '<h3>Nové rozšírenia pridané za posledných 7 dní</h3><dl>';
		foreach ($rozsirenia as $rozsirenie) 
		{
		echo '<dt>';
		echo '<a href="'.$folder.$rozsirenie->urlid.'">'.$rozsirenie->nazov.'</a></dt>';
		echo '<dd>';
		if (strlen($rozsirenie->popis) > 200) echo substr(strip_tags(trim($rozsirenie->popis)) , 0, 200) . "...";
		else echo $rozsirenie->popis;
		echo '</dd>';

		}
		echo '</dl>';
	}

	$rozsirenia = $wpdb->get_results("SELECT * FROM mozsk_rozsirenia WHERE publikovat=1 AND starsie!='' HAVING datum>CURDATE()-7 ORDER BY nazov ASC");
	if($rozsirenia)
	{
		
		echo '<h3>Rozšírenia aktualizované za posledných 7 dní</h3><dl>';
		foreach ($rozsirenia as $rozsirenie) 
		{
		echo '<dt>';
		echo '<a href="'.$folder.$rozsirenie->urlid.'">'.$rozsirenie->nazov.'</a></dt>';
		echo '<dd>';
		if (strlen($rozsirenie->popis) > 200) echo substr(strip_tags(trim($rozsirenie->popis)) , 0, 200) . "...";
		else echo $rozsirenie->popis;
		echo '</dd>';

		}
		echo '</dl>';
	}

}




//			$dat = $wpdb->get_var("SELECT datum FROM mozsk_rozsirenia WHERE publikovat=1 AND urlid='$rozsirenie->urlid' ORDER BY verzia DESC");
//			if ((mktime()-strtotime($dat)) <= 604800) 
//				{
//					$nove = $wpdb->get_var("SELECT starsie FROM mozsk_rozsirenia WHERE publikovat=1 AND urlid='$rozsirenie->urlid' ORDER BY verzia DESC");
//					if ($nove != "") echo '<dt class="update">';
//					else echo '<dt class="new">';
//				}
?>


