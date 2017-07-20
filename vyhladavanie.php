<?php

if (isset($HTTP_POST_VARS['hladat'])) 
	$hladat=$HTTP_POST_VARS['hladat'];  
 else $hladat='';

if (isset($HTTP_POST_VARS['hl_popis'])) 
	$hl_popis=1;  
 else $hl_popis=0;

if (isset($HTTP_POST_VARS['first_run'])) 
	$first_run=1;  
 else $first_run=0;
 
if (isset($HTTP_POST_VARS['popis'])) 
	$popis=1;  
 else $popis=0;

if (isset($HTTP_POST_VARS['first_run'])) 
	$first_run=1;  
 else $first_run=0;
 
 
?>

<div class="post-page"><h2>Vyhľadávanie rozšírení podľa názvu</h2>

<div class="entrytext">

Nástroj vyhľadávania vám pomôže pri hľadaní toho rozšírenia, ktoré práve hľadáte. Máte viacero možností, medzi ktorými nechýba ani vyhľadávanie v popisoch. To znamená, že vyhľadávanie je intuitívnejšie a nájdete aj rozšírenie, ktorého názov síce nepoznáte, ale poznáte jeho účel.<br/><br/>

        <div class="post-top">
				<div class="post-bottom">
				<div class="post">

<div id="vyhladavanie2">
      <img src="/wp-content/themes/mozillask/images/vyhladavanie.png" alt="Vyhľadávanie" />
			<form action="/rozsirenia/vyhladavanie/" method="post" id="vyhladavanie_form2">
				<input class="form-text" type="text" size="15" value="<?php echo wp_specialchars($hladat, 1); ?>" name="hladat" id="keys_vyh2" />
				<input style="padding-top: 2px" id="submit_vyh2" type="image" src="/wp-content/themes/mozillask/searcha.png" /><input type="hidden" value="1" name="first_run" />
      <input id="popis" name="popis" type="checkbox" value="1"<?php if(($popis==1) || ($first_run==0)) echo ('checked="checked" '); ?> /> <label for="popis"><small>Zobraziť popis rozšírenia</small></label>
      <input id="hl_popis" name="hl_popis" type="checkbox" value="1"<?php if(($hl_popis==1)  || ($first_run==0)) echo ('checked="checked" '); ?> /> <label for="hl_popis"><small>Hľadať aj v popise rozšírenia</small></label>
			<br/><br/></form> 
</div>

        </div>
        </div>
        </div>  

<?php

$hl_string = "";
if ($hladat != "") {

    if ($hl_popis == 1) $hl_string .= " AND (nazov LIKE '%$hladat%' OR popis LIKE '%$hladat%') ";
    else $hl_string .= " AND nazov LIKE '%$hladat%' ";
}

$rozsirenia = $wpdb->get_results("SELECT MAX(id) AS id, nazov, popis FROM mozsk_rozsirenia
										WHERE publikovat=1 $hl_string GROUP BY nazov ORDER BY nazov ASC");


	if($rozsirenia)
	{
		echo '<dl>';
		foreach ($rozsirenia as $rozsirenie) 
		{
		$roz = $wpdb->get_row("SELECT urlid, nazov, urcene_ff_od, urcene_tb_od, urcene_ms_od, urcene_nv_od, urcene_sb_od, urcene_sm_od, urcene_ns_od, urcene_fl_od, urcene_sng_od, popis, verzia FROM mozsk_rozsirenia, mozsk_roz_meta WHERE mozsk_rozsirenia.id=$rozsirenie->id AND nazov='$rozsirenie->nazov' AND mozsk_rozsirenia.kategoria=mozsk_roz_meta.id");

/*		echo '<dt style="float:left">';
		echo '<a href="'.$folder.$roz->urlid.'/">'.$roz->nazov.' <small>v'.$roz->verzia.'</small></a>&nbsp;';
		echo '</dt>';

		echo '<dt style="float:right">';
		if ($roz->urcene_ff_od!='') echo '&nbsp;<img alt="Firefox" src="/wp-content/images/logo/ff_small.png" />';
		if ($roz->urcene_tb_od!='') echo '&nbsp;<img alt="Thunderbird" src="/wp-content/images/logo/tb_small.png" />';
		if ($roz->urcene_ms_od!='') echo '&nbsp;<img alt="Mozilla Suite" src="/wp-content/images/logo/ms_small.png" />';
		if ($roz->urcene_nv_od!='') echo '&nbsp;<img alt="NVU" src="/wp-content/images/logo/nvu_small.png" />';
		if ($roz->urcene_sb_od!='') echo '&nbsp;<img alt="Sunbird" src="/wp-content/images/logo/sn_small.png" />';
		if ($roz->urcene_sm_od!='') echo '&nbsp;<img alt="SeaMonkey" src="/wp-content/images/logo/sm_small.png" />';
		if ($roz->urcene_ns_od!='') echo '&nbsp;<img alt="Netscape" src="/wp-content/images/logo/ns_small.png" />';
		if ($roz->urcene_fl_od!='') echo '&nbsp;<img alt="Flock" src="/wp-content/images/logo/fl_small.png" />';
		echo'</dt>';

		echo '<dd style="clear: both">';
		if (($popis == 1) || ($first_run==0)) echo formattext($roz->popis,$roz->urlid);
		echo '</dd>';
*/
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
		echo'</dt>';

		echo '<dd>';
		if (($popis == 1) || ($first_run==0)) echo formattext($roz->popis,$roz->urlid);
		echo '</dd>';

		}
		echo '</dl>';
	}
	else
	{
		echo '<div class="error">Nebolo nájdené žiadne rozšírenie.</div>';
	}
?>

</div></div>
