<?php

$error=1;
echo '<div class="post-page"><h2>';
$cat = $wpdb->get_results('SELECT kategoria, kat_url FROM mozsk_roz_meta ORDER BY kategoria');

if ($ver == NULL) {
	$rozsirenia = $wpdb->get_results("SELECT MAX(mozsk_rozsirenia.id) AS id, nazov FROM mozsk_rozsirenia WHERE publikovat=1 GROUP BY nazov ORDER BY nazov ASC");
	echo 'Zoznam všetkých rozšírení';
}
else
{
    $rozsirenia = $wpdb->get_results("SELECT MAX(mozsk_rozsirenia.id) AS id, nazov FROM mozsk_rozsirenia, mozsk_roz_meta WHERE publikovat=1 AND mozsk_rozsirenia.kategoria=mozsk_roz_meta.id AND mozsk_roz_meta.kat_url='$ver' GROUP BY nazov ORDER BY nazov ASC");
	echo 'Rozšírenia v kategórii '; 
    foreach ($cat as $kat)
				{
				if ($kat->kat_url == $ver) 
				{
					echo $kat->kategoria;
					$error=0;
				}
				}
}

echo '</h2><div class="entrytext">';

echo '<div style="border-bottom: 1px solid rgb(180, 198, 215); margin-bottom: 5px; padding-bottom: 5px"><small class="black tucne">Kategórie: <a href="'.$folder.'kat/">Všetky</a>';


               foreach ($cat as $kat)
				{
				
				echo ' | <a href="'.$folder.'kat/'.$kat->kat_url.'/">'.$kat->kategoria.'</a>';
				}

echo '</small></div>'; 



   
	if($rozsirenia)
	{
		echo 'Rozšírenia sú balíky, ktoré sa <a href="/rozsirenia/instalacia-rozsireni/">inštalujú</a> do aplikácií od <a href="http://www.mozilla.org" hreflang="en">Mozilly</a> a odvodených a pridávajú im nové funkcie. Ponúkame vám ich slovenské lokalizácie roztriedené podľa jednotlivých produktov&hellip;<br/>';
		echo '<dl>';
		foreach ($rozsirenia as $rozsirenie) 
		{
		$roz = $wpdb->get_row("SELECT urlid, nazov, urcene_ff_od, urcene_tb_od, urcene_ms_od, urcene_nv_od, urcene_sb_od, urcene_sm_od, urcene_ns_od, urcene_fl_od, urcene_sng_od, popis, verzia FROM mozsk_rozsirenia, mozsk_roz_meta WHERE mozsk_rozsirenia.id=$rozsirenie->id AND nazov='$rozsirenie->nazov' AND mozsk_rozsirenia.kategoria=mozsk_roz_meta.id");

		echo '<dt>';
		echo '<a href="'.$folder.$roz->urlid.'/">'.$roz->nazov.' <small>v'.$roz->verzia.'</small></a>&nbsp;';
		if ($roz->urcene_ff_od!='') echo '&nbsp;<img alt="Firefox" src="/wp-content/images/logo/ff_small.png" />';
		if ($roz->urcene_tb_od!='') echo '&nbsp;<img alt="Thunderbird" src="/wp-content/images/logo/tb_small.png" />';
		if ($roz->urcene_ms_od!='') echo '&nbsp;<img alt="Mozilla Suite" src="/wp-content/images/logo/ms_small.png" />';
		if ($roz->urcene_nv_od!='') echo '&nbsp;<img alt="NVU" src="/wp-content/images/logo/nvu_small.png" />';
		if ($roz->urcene_sb_od!='') echo '&nbsp;<img alt="Sunbird" src="/wp-content/images/logo/sn_small.png" />';
		if ($roz->urcene_sm_od!='') echo '&nbsp;<img alt="SeaMonkey" src="/wp-content/images/logo/sm_small.png" />';
		if ($roz->urcene_ns_od!='') echo '&nbsp;<img alt="Netscape" src="/wp-content/images/logo/ns_small.png" />';
		if ($roz->urcene_fl_od!='') echo '&nbsp;<img alt="Flock" src="/wp-content/images/logo/fl_small.png" />';
		if ($roz->urcene_sng_od!='') echo '&nbsp;<img alt="Flock" src="/wp-content/images/logo/sng_small.png" />';
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
		echo '<div class="error">V kategórii <a href="'.$folder.'kat/';
		    foreach ($cat as $kat)
				{
				if ($kat->kat_url == $ver) echo $kat->kat_url.'/">'.$kat->kategoria;
				}
		echo '</a> sa nenachádza <strong>žiadne</strong> rozšírenie. Skúste vybrať inú.</div>';
		}
	}
?>
</div></div>
