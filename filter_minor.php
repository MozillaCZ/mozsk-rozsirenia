<?php

{
    
    switch ($urlid) {
    case 'nvu': 		$skr='AND urcene_nv_od!=""';
							$produkt='NVU';
							break;
	case 'mozilla-suite':		$skr='AND urcene_ms_od!=""';
							$produkt='Mozilla Suite';
							break;
	case 'flock':		$skr='AND urcene_fl_od!=""';
							$produkt='Flock';
							break;
	case 'songbird':		$skr='AND urcene_sng_od!=""';
							$produkt='Songbird';
							break;
	case 'seamonkey':		$skr='AND urcene_sm_od!=""';
							$produkt='SeaMonkey';
							break;
	case 'netscape':		$skr='AND urcene_ns_od!=""';
							$produkt='Netscape';
							break;
	case 'mozilla-sunbird':		$skr='AND urcene_sb_od!=""';
							$produkt='Sunbird';
							break;
	default: $skr='';						
    }

if (isset($HTTP_POST_VARS['popis'])) 
	$popis=1;  
 else $popis=0;

echo '<div class="post-page"><h2>Zoznam rozšírení pre '.$produkt.'</h2><div class="entrytext">';

echo '<div class="center" style="border-bottom: 1px solid rgb(180, 198, 215); margin-bottom: 5px; padding-bottom: 5px">';
echo '<small class="black tucne"><a href="'.$folder.'firefox/">Firefox</a> | <a href="'.$folder.'thunderbird/">Thunderbird</a> | <a href="'.$folder.'mozilla-sunbird/">Sunbird</a> | <a href="'.$folder.'mozilla-suite/">Mozilla Suite</a> | <a href="'.$folder.'seamonkey/">SeaMonkey</a> | <a href="'.$folder.'nvu/">NVU</a> | <a href="'.$folder.'flock/">Flock</a> | <a href="'.$folder.'netscape/">Netscape</a> | <a href="'.$folder.'songbird/">Songbird</a></small>';
echo '</div>'; 

echo 'Rozšírenia sú balíky, ktoré sa <a href="/rozsirenia/instalacia-rozsireni/">inštalujú</a> do aplikácií od <a href="http://www.mozilla.org" hreflang="en">Mozilly</a> a odvodených a pridávajú im nové funkcie. Ponúkame vám ich slovenské lokalizácie roztriedené podľa jednotlivých produktov&hellip;<br/>';


	$rozsirenia = $wpdb->get_results("SELECT MAX(mozsk_rozsirenia.id) AS id, urlid, nazov, mozsk_roz_meta.kategoria, mozsk_roz_meta.kat_url, popis, MAX(datum) AS datum, MAX(verzia) AS verzia FROM mozsk_rozsirenia, mozsk_roz_meta WHERE publikovat=1 $skr AND mozsk_rozsirenia.kategoria=mozsk_roz_meta.id GROUP BY nazov ORDER BY nazov ASC");

	if($rozsirenia)
	{
		echo '<dl>';
		foreach ($rozsirenia as $rozsirenie) 
		{
		echo '<dt>';
		echo '<a href="'.$folder.$rozsirenie->urlid.'/';
		if ($rozsirenie->id!=$wpdb->get_var("SELECT MAX(id) AS id FROM mozsk_rozsirenia WHERE nazov='$rozsirenie->nazov'")) echo urlencode($rozsirenie->verzia).'/';
		echo '">'.$rozsirenie->nazov.' <small>v'.$rozsirenie->verzia.'</small></a><small> |&nbsp;Kategória:&nbsp;<a href="'.$folder.'kat/'.$rozsirenie->kat_url.'/">'.$rozsirenie->kategoria.'</a></small></dt>';

		echo '<dd>';
		echo formattext($rozsirenie->popis,$rozsirenie->urlid);
		echo '</dd>';

		}
		echo '</dl>';
	}
echo '</div></div>';

}
?>
