<?php
function get_ver_do($id, $produkt)
{
if ($produkt=='Sunbird') {
	switch ($id) {
	case '1': 	$verzia='"1.0"';
					break;
	case '2': 	$verzia='"0.2"';
					break;
	case '3':	$verzia='"0.3"';
					break;
	case '4':	$verzia='"0.3.1"';
					break;
	default: $verzia='1.0';			
	}			
	return $verzia;
}

else if ($produkt=='Firefox') {
	switch ($id) {
	case '1': 	$verzia='"0.1"';
					break;
	case '2': 	$verzia='"1.0"';
					break;
	case '3':	$verzia='"1.0+"';
					break;
	case '4':	$verzia='"1.4"';
					break;
	case '5':	$verzia='"1.5.0.12" OR urcene_ff_do="1.5.0.*"';
					break;
	case '6':	$verzia='"2.0b3" OR urcene_ff_do="2.0.0.*" OR urcene_ff_do ="2.0" OR urcene_ff_do ="2.0+"';
					break;
	case '7':	$verzia='"2.0.0.*"';
					break;
	case '8':	$verzia='"3.0prev" OR urcene_ff_do="3.0.*"';
					break;
	default: $verzia='0';			
	}			
	return $verzia;
}

else if ($produkt=='Thunderbird') {
	switch ($id) {
	case '1': 	$verzia='"0.1"';
					break;
	case '2': 	$verzia='"1.0"';
					break;
	case '3':	$verzia='"1.0+"';
					break;
	case '4':	$verzia='"1.4"';
					break;
	case '5':	$verzia='"1.5.0.12" OR urcene_tb_do="1.5.0.*"';
					break;
	case '6':	$verzia='"2.0b3" OR urcene_tb_do="2.0.0.*" OR urcene_tb_do ="2.0" OR urcene_tb_do ="2.0+"';
					break;
	case '7':	$verzia='"2.0.0.*"';
					break;
	default: $verzia='0';			
	}			
	return $verzia;
}

}

function get_ver_od($id, $produkt)
{
if ($produkt=='Sunbird') {
	switch ($id) {
	case '1': 	$verzia='"0.1"';
					break;
	case '2': 	$verzia='"0.2"';
					break;
	case '3':	$verzia='"0.3"';
					break;
	case '4':	$verzia='"0.3.1"';
					break;
	case '5':	$verzia='"1.4.x"';
					break;
	case '6':	$verzia='"1.5.x"';
					break;
	case '7':	$verzia='"1.6.x"';
					break;
	case '8':	$verzia='"1.7.x"';
					break;
	case '9':	$verzia='"1.8.x"';
					break;
	default: $verzia='"2.0.0.*"';			
	}			
	return $verzia;
}

else if ($produkt=='Firefox') {
	switch ($id) {
	case '1': 	$verzia='"0.9"';
					break;
	case '2': 	$verzia='"1.0"';
					break;
	case '3':	$verzia='"1.0.8"';
					break;
	case '4':	$verzia='"1.5+"';
					break;
	case '5':	$verzia='"1.5.0.1"';
					break;
	case '6':   $verzia='"2.0b2"';
					break;
	case '7':   $verzia='"2.0.0"';
					break;
	case '7':   $verzia='"3.0"';
					break;
	case '8':	$verzia='"4.0"';
					break;
	default: $verzia='"4.0"';			
	}			
	return $verzia;
}
else if ($produkt=='Thunderbird') {
	switch ($id) {
	case '1': 	$verzia='"0.9"';
					break;
	case '2': 	$verzia='"1.0"';
					break;
	case '3':	$verzia='"1.0.8"';
					break;
	case '4':	$verzia='"1.5+"';
					break;
	case '5':	$verzia='"1.5.0.11"';
					break;
	case '6':	$verzia='"2.0b2"';
					break;
	case '7':	$verzia='"2.0.0"';
					break;
	case '8':	$verzia='"4.0"';
					break;
	default: $verzia='"4.0"';			
	}			
	return $verzia;
}

}


{
    
    switch ($urlid) {
    case 'firefox': 		$skr='AND urcene_ff_od!=""';
							$produkt='Firefox';
							$ver  = array('Všetky','< 1.0','1.0','1.0.x','1.5','1.5.0.*','2.0','2.0.0.*','3.0.*');
							$skratka = 'ff';
							break;
	case 'thunderbird':		$skr='AND urcene_tb_od!=""';
							$produkt='Thunderbird';
							$ver  = array('Všetky','< 1.0','1.0','1.0.x','1.5', '1.5.0.*', '2.0', '2.0.0.*');
							$skratka = 'tb';
							break;
	case 'mozilla-sunbird':	$skr='AND urcene_sn_od!=""';
							$produkt='Sunbird';
							$ver  = array('Všetky','0.2','0.3','0.3.1');
							$skratka = 'sn';
							break;
	default: $skr='';						
    }

if (isset($HTTP_POST_VARS['popis'])) 
	$popis=1;  
 else $popis=0;

if (isset($HTTP_POST_VARS['first_run'])) 
	$first_run=1;  
 else $first_run=0;

if (isset($HTTP_POST_VARS['ver_id'])) 
	$ver_id=$HTTP_POST_VARS['ver_id'];  
 else $ver_id=0;

if (isset($HTTP_POST_VARS['kat_id'])) 
	$kat_id=$HTTP_POST_VARS['kat_id'];  
 else $kat_id=0;

$cat = $wpdb->get_results('SELECT kategoria, id FROM mozsk_roz_meta ORDER BY kategoria');

echo '<div class="post-page"><h2>Zoznam rozšírení pre '.$produkt.'</h2><div class="entrytext">';

echo '<div class="center" style="border-bottom: 1px solid rgb(180, 198, 215); margin-bottom: 5px; padding-bottom: 5px">';
echo '<small class="black tucne"><a href="'.$folder.'firefox/">Firefox</a> | <a href="'.$folder.'thunderbird/">Thunderbird</a> | <a href="'.$folder.'mozilla-suite/">Mozilla Suite</a> | <a href="'.$folder.'mozilla-sunbird/">Sunbird</a> | <a href="'.$folder.'seamonkey/">SeaMonkey</a> | <a href="'.$folder.'nvu/">NVU</a> | <a href="'.$folder.'flock/">Flock</a> | <a href="'.$folder.'netscape/">Netscape</a> | <a href="'.$folder.'songbird/">Songbird</a></small>';
echo '</div>'; 

if (($produkt=='Firefox') || ($produkt=='Thunderbird') || ($produkt=='Sunbird'))
{
echo 'Vyberte verziu programu, s ktorou má byť rozšírenie kompatibilné, prípadne kategóriu činnosti, na ktorú má byť dané rozšírenie zamerané. Po zadaní požadovaných parametrov stlačte "Použiť filter".';
          echo '<div class="post-top">
				<div class="post-bottom">
				<div class="post">
				<form method="post" action="" name="zvol_filter">';
            echo '<p class="centered"><label for="ver_id">Verzia:</label> <select class="filter" size="1" name="ver_id" id="ver_id">';

              for ($i=0;$i<count($ver);$i++)
              {
				echo '<option ';
				if ($i==$ver_id) echo 'selected="selected" ';
				echo 'value='.$i.'>'.$ver[$i].'</option>';
			  }
            echo '</select>&nbsp;&nbsp;';

            echo '<label for="kat_id">Kategória:</label> <select class="filter" size="1" name="kat_id" id="kat_id">';

				echo '<option ';
				if ($kat_id==0) echo 'selected="selected" ';
				echo 'value="0">Všetko</option>';

               foreach ($cat as $kat)
				{
				echo '<option ';
				if ($kat->id==$kat_id) echo 'selected="selected" ';
				echo 'value='.$kat->id.'>'.$kat->kategoria.'</option>';
				}

			echo '</select></p>';
          echo '
          <input type="hidden" value="1" name="first_run" />
          <input type="submit" value="Použiť filter" name="submit" class="alignright button"/>
          <input id="popis" name="popis" type="checkbox" value="1"'; if(($popis==1) || ($first_run==0)) echo ('checked="checked" '); echo'/> <label for="popis"><small>Zobrazovať popis rozšírenia</small></label>
          </form>
				</div></div></div>';
}
	$od=get_ver_od($ver_id,$produkt);
	$do=get_ver_do($ver_id,$produkt);
	$pocet=0;
	if ($kat_id!=0) $category='AND kategoria='.$kat_id;
	else $category='';
	$rozsirenia = $wpdb->get_results("SELECT nazov FROM mozsk_rozsirenia WHERE publikovat=1 $skr $category GROUP BY nazov ORDER BY nazov ASC");
	if($rozsirenia)
	{
		
		echo '<dl>';
		foreach ($rozsirenia as $rozsirenie)
		{
		$verzia_roz = $wpdb->get_var("SELECT MAX(id) FROM mozsk_rozsirenia WHERE publikovat=1 AND nazov='$rozsirenie->nazov' AND urcene_{$skratka}_od<=$od AND (urcene_{$skratka}_do>=$do)");
		if ($verzia_roz) 
			{
				$pocet = $pocet + 1;
				$naj_version = $wpdb->get_var("SELECT MAX(id) FROM mozsk_rozsirenia WHERE publikovat=1 AND nazov='$rozsirenie->nazov'");
				if (($popis==1) || ($first_run==0) ) $roz = $wpdb->get_row("SELECT urlid, verzia, nazov, popis FROM mozsk_rozsirenia WHERE id='$verzia_roz' AND nazov='$rozsirenie->nazov'");
					else $roz = $wpdb->get_row("SELECT urlid, verzia, nazov FROM mozsk_rozsirenia WHERE id='$verzia_roz' AND nazov='$rozsirenie->nazov'");
				echo '<dt><a href="'.$folder.$roz->urlid.'/';if ($verzia_roz!=$naj_version) echo urlencode($roz->verzia).'/'; 
					echo '">'.$roz->nazov.' <small>'.$roz->verzia.'</small></a></dt>';
					if (($popis==1) || ($first_run==0) )
						{
						echo '<dd>';
						if ($verzia_roz!=$naj_version) $roz->urlid .= '/'.urlencode($roz->verzia);
						echo formattext($roz->popis,$roz->urlid);
						echo '</dd>';
						}
			}
		}				


		
		echo '</dl>';
	}
	
	if ($pocet==0)
	{
		$cat = $wpdb->get_row("SELECT kat_url, kategoria FROM mozsk_roz_meta WHERE id=$kat_id");
		echo '<div class="error">';
		if ($kat_id != 0) echo 'V kategórii <a href="'.$folder.'kat/'.$cat->kat_url.'/">'.$cat->kategoria.'</a> sa nenachádza ';
		else echo 'Nenašlo sa ';
		echo '<strong>žiadne</strong> rozšírenie kompatibilné s aplikáciou <a href="/'.$urlid.'/">'.$produkt.'</a>';
		if ($ver_id != 0) echo ' verzia <strong>'.$ver[$ver_id].'</strong>';
		echo '.</div>';
	}

echo '</div></div>';

}
?>
