<?php

$error=1;
echo '<div class="post-page"><h2>';
$lok = $wpdb->get_results("SELECT lok_url,localizator, count(nazov) as pocet FROM mozsk_roz_localizator, mozsk_rozsirenia WHERE mozsk_rozsirenia.autor=mozsk_roz_localizator.id AND publikovat=1 GROUP BY lok_url,localizator ORDER BY localizator");

if ($ver == NULL) {
	$rozsirenia = $wpdb->get_results("SELECT MAX(mozsk_rozsirenia.id) AS id, nazov FROM mozsk_rozsirenia WHERE publikovat=1 GROUP BY nazov ORDER BY nazov ASC");
	echo 'Zoznam všetkých rozšírení';
}
else
{
    $rozsirenia = $wpdb->get_results("SELECT MAX(mozsk_rozsirenia.id) AS id, nazov FROM mozsk_rozsirenia, mozsk_roz_localizator WHERE publikovat=1 AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id AND mozsk_roz_localizator.lok_url='$ver' GROUP BY nazov ORDER BY nazov ASC");
	if ($rozsirenia) {
	echo 'Rozšírenia od lokalizátora: '; 
    foreach ($lok as $loc)
				{
				if ($loc->lok_url == $ver) 
				{
				echo $loc->localizator;
				$error=0;
				}
				}
	}
}

echo '</h2><div class="entrytext">';

echo '<div style="border-bottom: 1px solid rgb(180, 198, 215); margin-bottom: 5px; padding-bottom: 5px"><small class="black tucne">Lokalizátori: <a href="'.$folder.'lok/">Všetci</a>';


               foreach ($lok as $loc)
				{
				if ($loc->pocet>0) echo ' | <a href="'.$folder.'lok/'.$loc->lok_url.'/">'.$loc->localizator.'</a>';
				}	

echo '</small></div>'; 



   
	if($rozsirenia)
	{
		echo 'Rozšírenia sú balíky, ktoré sa <a href="/rozsirenia/instalacia-rozsireni/">inštalujú</a> do aplikácií od <a href="http://www.mozilla.org" hreflang="en">Mozilly</a> a odvodených a pridávajú im nové funkcie. Ponúkame vám ich slovenské lokalizácie roztriedené podľa jednotlivých produktov&hellip;<br/>';
		echo '<dl>';
		foreach ($rozsirenia as $rozsirenie) 
		{
		$roz = $wpdb->get_row("SELECT urlid, nazov, verzia, popis, urcene_ff_od, urcene_tb_od, urcene_ms_od, urcene_nv_od, urcene_sb_od, urcene_sm_od, urcene_ns_od, urcene_fl_od, urcene_sng_od FROM mozsk_rozsirenia, mozsk_roz_localizator WHERE mozsk_rozsirenia.id=$rozsirenie->id AND nazov='$rozsirenie->nazov' AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id");

		echo '<dt>';
		echo '<a href="'.$folder.$roz->urlid.'/';
		if ($rozsirenie->id!=$wpdb->get_var("SELECT MAX(id) AS id FROM mozsk_rozsirenia WHERE nazov='$roz->nazov'")) echo urlencode($roz->verzia).'/';
		echo '">'.$roz->nazov.' <small>v'.$roz->verzia.'</small></a>&nbsp;';
		if ($roz->urcene_ff_od!='') echo '&nbsp;<img alt="Firefox" src="/wp-content/images/logo/ff_small.png" />';
		if ($roz->urcene_tb_od!='') echo '&nbsp;<img alt="Thunderbird" src="/wp-content/images/logo/tb_small.png" />';
		if ($roz->urcene_ms_od!='') echo '&nbsp;<img alt="Mozilla Suite" src="/wp-content/images/logo/ms_small.png" />';
		if ($roz->urcene_nv_od!='') echo '&nbsp;<img alt="NVU" src="/wp-content/images/logo/nvu_small.png" />';
		if ($roz->urcene_sb_od!='') echo '&nbsp;<img alt="Sunbird" src="/wp-content/images/logo/sn_small.png" />';
		if ($roz->urcene_sm_od!='') echo '&nbsp;<img alt="SeaMonkey" src="/wp-content/images/logo/sm_small.png" />';
		if ($roz->urcene_ns_od!='') echo '&nbsp;<img alt="Netscape" src="/wp-content/images/logo/ns_small.png" />';
		if ($roz->urcene_fl_od!='') echo '&nbsp;<img alt="Flock" src="/wp-content/images/logo/fl_small.png" />';
		if ($roz->urcene_sng_od!='') echo '&nbsp;<img alt="Songbird" src="/wp-content/images/logo/sng_small.png" />';
		echo'</dt>';

		echo '<dd>';
		echo formattext($roz->popis,$roz->urlid);
		echo '</dd>';

		}
		echo '</dl>';
	}
	else
	{
		if ($error) echo '<script>document.location.href="/404/"</script>';
		else
		{
		echo '<div class="error">Nebolo nájdené <strong>žiadne</strong> rozšírenie od lokalizátora <a href="'.$folder.'lok/';
		    foreach ($lok as $loc)
				{
				if ($loc->lok_url == $ver) echo $loc->lok_url.'/">'.$loc->localizator;
				}
		echo '</a>. Skúste vybrať iného lokalizátora.</div>';
		}
	}
?>
</div></div>
