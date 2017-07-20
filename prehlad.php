<?php if (isset($_GET['zorad'])) 
	$zorad=$_GET['zorad'];  
 else $zorad=0;
 
 	switch ($zorad) {
	case '0': 	$sort='nazov ASC';
					break;
	case '1': 	$sort='nazov DESC';
					break;
	case '2':	$sort='localizator ASC, nazov ASC';
					break;
	case '3':	$sort='localizator DESC, nazov DESC';
					break;
	case '4':	$sort='datum ASC';
					break;
	case '5':	$sort='datum DESC';
					break;
	case '6':	$sort='podporovane ASC';
					break;
	case '7':	$sort='podporovane DESC';
					break;
	case '8':	$sort='neaktualne ASC';
					break;
	case '9':	$sort='neaktualne DESC';
					break;
	default: $sort='nazov ASC';			
	}			

?>

<h2>Vydané rozšírenia: <?php $count = $wpdb->get_var("SELECT COUNT(DISTINCT urlid) 
			FROM mozsk_rozsirenia WHERE publikovat=1");
			echo $count;
			?></h2>
	<div style="border:solid 1px #ccc;margin-bottom:10px">
	<table id="the-list-x" width="100%" cellpadding="3" cellspacing="3">
	<thead>
		<tr>
			<th scope="col"><img src="/wp-content/plugins/mozsk-rozsirenia/vyvojstop.png" alt="Neplatný odkaz na súbor" title="Neplatný odkaz na súbor" /></th>
			<th scope="col"><a href="plugins.php?page=prehlad.php&amp;zorad=0">Názov</a></th>
			<th scope="col" colspan="3">Odkazy</th>
			<th scope="col">Verzia</th>
			<th scope="col"><a href="plugins.php?page=prehlad.php&amp;zorad=2">Lokalizuje</a></th>
			<th scope="col">Aktualizované</th>
			<th scope="col" style="width: 10px" title="Podporované">Podp.</th>
			<th scope="col" style="width: 10px" title="Neaktualizované">Neakt.</th>
			<th scope="col" style="width: 10px" title="Kompatibilné s FX 3.0">FX 3.0</th>
			<th scope="col" style="width: 10px" title="Kompatibilné s TB 2.0">TB 2.0</th>
			<th scope="col" style="width: 250px">Interná poznámka</th>
		</tr>
	</thead>
	<tbody>
<?php

/*			<th scope="col"><img src="/wp-content/images/logo/rozsirenia_lok/domov.png" alt="Domovská stránka" title="Domovská stránka" /></th>
			<th scope="col"><img src="/wp-content/plugins/mozsk-rozsirenia/czilla.gif" alt="Česká lokalizácia" title="Česká lokalizácia" /></th>
			<th scope="col"><img src="/mozilla-16.png" alt="Mozilla Add-ons" title="Mozilla Add-ons" /></th>
*/
$folder = '/rozsirenia/';
	$r = 0;
	$podp = 0;
	$neakt = 0;
	$fx20 = 0;
	$fx = 0;
	$tb20 = 0;
	$tb = 0;
	$rozmax = "";
	$rozsirenie = $wpdb->get_results("SELECT max(mozsk_rozsirenia.id) AS id FROM mozsk_rozsirenia,mozsk_roz_localizator WHERE publikovat=1 AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id GROUP BY urlid ORDER BY $sort");
	if($rozsirenie)
	{
		foreach ($rozsirenie as $roz) 
		{
			if ($rozmax=="") $rozmax = $roz->id; 
			else $rozmax .= ','.$roz->id;
			$rozsirenia = $wpdb->get_row("SELECT urlid,nazov,url,verzia,localizator,datum,podporovane,neaktualne,interna_pozn,homepage,czilla,addon,urcene_ff_od,urcene_ff_do,urcene_tb_od,urcene_tb_do FROM mozsk_rozsirenia, mozsk_roz_localizator WHERE mozsk_rozsirenia.id = $roz->id AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id");
			
			$homepage = htmlspecialchars($rozsirenia->homepage, ENT_QUOTES);
			if($r % 2) echo '<tr>';
			else echo '<tr class="alternate">';

/*korektny odkaz*/
			$ok = 0;
			$url = explode(',',$rozsirenia->url);
			if (count($url)>1) {
			 if ((is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[0])) && (is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[2]))) $ok=1;
			 }
			 else if(is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[0])) $ok = 1;
			if ($ok==0) 
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/vyvojstop.png" alt="Neplatný odkaz na súbor" title="Neplatný odkaz na súbor" /></td>';
				else echo '<td class="centered"> </td>';

/*nazov*/
			echo '<td><a href="'.$folder.$rozsirenia->urlid.'/">'.$rozsirenia->nazov.'</a></td>';

/*homepage*/
			if ($rozsirenia->homepage) {
					echo '<td class="centered" width="20"><a href="'.$homepage.'" style="text-decoration: none"><img src="/wp-content/images/logo/rozsirenia_lok/domov.png" alt="Domovská stránka" title="Domovská stránka" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';

/*Addon*/
			if ($rozsirenia->addon) {
					echo '<td class="centered" width="20"><a href="https://addons.mozilla.org/extensions/moreinfo.php?id='.$rozsirenia->addon.'" style="text-decoration: none"><img src="/mozilla-16.png" alt="Mozilla Add-ons" title="Mozilla Add-ons" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';
/*CZilla*/
			if ($rozsirenia->czilla) {
					echo '<td class="centered" width="20"><a href="http://www.czilla.cz/doplnky/rozsireni/'.$rozsirenia->czilla.'" style="text-decoration: none"><img src="/wp-content/plugins/mozsk-rozsirenia/czilla.gif" alt="Česká lokalizácia" title="Česká lokalizácia" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';

/*verzia*/
			echo '<td class="centered">'.$rozsirenia->verzia.'</td>';

/*lokalizator*/
			echo '<td>' . $rozsirenia->localizator . '</td>';

/*datum*/
			echo '<td class="centered">' . mysql2date("d.m.Y",$rozsirenia->datum) . '</td>';

/*podporovane*/
			if ($rozsirenia->podporovane) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/podpora.png" alt="Podporované" title="Podporované" /></td>';
					$podp++;
					}
				else echo '<td class="centered"> </td>';

/*neaktualne*/
			if ($rozsirenia->neaktualne==1) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/aktualne.png" alt="Neaktuálne" title="Neaktuálne" /></td>';
					$neakt++;
					}
			else if ($rozsirenia->neaktualne==2) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/podporastop.png" alt="Už nepodporované" title="Už nepodporované" /></td>';

					}
			else if ($rozsirenia->neaktualne==3) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/vyvojstop.png" alt="Ďalej sa nevyvíja" title="Ďalej sa nevyvíja" /></td>';

					}
				else echo '<td class="centered"> </td>';
/*FX 3.0*/
			if (($rozsirenia->urcene_ff_od <="3.0pre") && (($rozsirenia->urcene_ff_do =="3.0.*") || ($rozsirenia->urcene_ff_do >"3.0pre"))) {
					echo '<td class="centered" width="40"><img src="/wp-content/images/logo/ff_small.png" alt="Podporuje FX 3.0" title="Podporuje FX 3.0 ('.$rozsirenia->urcene_ff_od.' až '.$rozsirenia->urcene_ff_do.')" /></td>';
					$fx20++;
					$fx++;
					}
				else if ($rozsirenia->urcene_ff_od !="") {
					echo '<td class="centered"><img src="/wp-content/images/logo/ff_cb.png" alt="Nepodporuje FX 3.0" title="Nepodporuje FX 2.0 ('.$rozsirenia->urcene_ff_od.' až '.$rozsirenia->urcene_ff_do.')" /></td>';
					$fx++;
					}
				else
				echo '<td class="centered"> </td>';


/*TB 2.0*/
			if (($rozsirenia->urcene_tb_od <="2.0b2") && (($rozsirenia->urcene_tb_do =="2.0.0.*") || ($rozsirenia->urcene_tb_do =="2.0.*") || ($rozsirenia->urcene_tb_do =="2.0") || ($rozsirenia->urcene_tb_do >"2.0b2") || ($rozsirenia->urcene_tb_do =="2.0+"))) {
					echo '<td class="centered" width="40"><img src="/wp-content/images/logo/tb_small.png" alt="Podporuje TB 2.0" title="Podporuje TB 2.0 ('.$rozsirenia->urcene_tb_od.' až '.$rozsirenia->urcene_tb_do.')" /></td>';
					$tb20++;
					$tb++;
					}
				else if ($rozsirenia->urcene_tb_od !="") {
					echo '<td class="centered"><img src="/wp-content/images/logo/tb_cb.png" alt="Nepodporuje TB 2.0" title="Nepodporuje TB 2.0 ('.$rozsirenia->urcene_tb_od.' až '.$rozsirenia->urcene_tb_do.')" /></td>';
					$tb++;
					}
				else
				echo '<td class="centered"> </td>';

/*interna*/		
			echo '<td>'.$rozsirenia->interna_pozn.'</td>';

			echo '</tr>';
			$r++;
		}
		if($r % 2) echo '<tr>';
			else echo '<tr class="alternate">';
		echo '<td class="spolu" colspan="8">Spolu: '.$count.'</td><td class="spolu centered">'. $podp . '<br/>'.round($podp*100/$count).' %</td><td class="spolu centered">'. $neakt . '<br/>'.round($neakt*100/$count).' %</td><td class="spolu centered" title="Celkový počet určených pre Firefox: '.$fx.'">'. $fx20 . '<br/>'.round($fx20*100/$fx).' %</td><td class="spolu centered" title="Celkový počet určených pre Thunderbird: '.$tb.'">'. $tb20 . '<br/>'.round($tb20*100/$tb).' %</td><td class="spolu">&nbsp;</td></tr>';
		
	
	}
	else
	{
		echo '<tr><td colspan="6">V databáze nie sú žiadne rozšírenia.</td></tr>';
	}
?>
	</tbody>
	</table>
	</div>
<div>&nbsp;</div>
<?php /*-------------sandbox-----------------*/ ?>

<h2>Sandbox: <?php $count = $wpdb->get_var("SELECT COUNT(DISTINCT urlid) 
			FROM mozsk_rozsirenia WHERE publikovat=3");
			echo "$count";
			?></h2>
	<div style="border:solid 1px #ccc;margin-bottom:10px">
	<table id="the-list-y" width="100%" cellpadding="3" cellspacing="3">
	<thead>
		<tr>
			<th scope="col"><img src="/wp-content/plugins/mozsk-rozsirenia/vyvojstop.png" alt="Neplatný odkaz na súbor" title="Neplatný odkaz na súbor" /></th>
			<th scope="col">Názov</th>
			<th scope="col" colspan="3"> Odkazy</th>
			<th scope="col">Verzia</th>
			<th scope="col">Lokalizuje</th>
			<th scope="col">Aktualizované</th>
			<th scope="col" style="width: 10px" title="Podporované">Podp.</th>
			<th scope="col" style="width: 10px" title="Neaktualizované">Neakt.</th>
			<th scope="col" style="width: 10px" title="Kompatibilné s FX 2.0">FX 2.0</th>
			<th scope="col" style="width: 10px" title="Kompatibilné s TB 2.0">TB 2.0</th>
			<th scope="col" style="width: 250px">Interná poznámka</th>
		</tr>
	</thead>
	<tbody>
<?php
	$r = 0;
  $rozmax = "";
	$rozsirenie = $wpdb->get_results("SELECT max(mozsk_rozsirenia.id) AS id FROM mozsk_rozsirenia,mozsk_roz_localizator WHERE publikovat=3 AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id GROUP BY urlid ORDER BY $sort");
	if($rozsirenie)
	{
		foreach ($rozsirenie as $roz) 
		{
			if ($rozmax=="") $rozmax = $roz->id; 
			else $rozmax .= ','.$roz->id;
			$rozsirenia = $wpdb->get_row("SELECT urlid,nazov,url,verzia,localizator,datum,podporovane,neaktualne,interna_pozn,homepage,czilla,addon,urcene_ff_od,urcene_ff_do,urcene_tb_od,urcene_tb_do FROM mozsk_rozsirenia, mozsk_roz_localizator WHERE mozsk_rozsirenia.id = $roz->id AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id");
			
			$homepage = htmlspecialchars($rozsirenia->homepage, ENT_QUOTES);
			if($r % 2) echo '<tr>';
			else echo '<tr class="alternate">';

/*korektny odkaz*/
			$ok = 0;
			$url = explode(',',$rozsirenia->url);
			if (count($url)>1) {
			 if ((is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[0])) && (is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[2]))) $ok=1;
			 }
			 else if(is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[0])) $ok = 1;
			if ($ok==0) 
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/vyvojstop.png" alt="Neplatný odkaz na súbor" title="Neplatný odkaz na súbor" /></td>';
				else echo '<td class="centered"> </td>';

/*nazov*/
			echo '<td><a href="'.$folder.$rozsirenia->urlid.'/">'.$rozsirenia->nazov.'</a></td>';

/*homepage*/
			if ($rozsirenia->homepage) {
					echo '<td class="centered" width="20"><a href="'.$homepage.'" style="text-decoration: none"><img src="/wp-content/images/logo/rozsirenia_lok/domov.png" alt="Domovská stránka" title="Domovská stránka" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';

/*Addon*/
			if ($rozsirenia->addon) {
					echo '<td class="centered" width="20"><a href="https://addons.mozilla.org/extensions/moreinfo.php?id='.$rozsirenia->addon.'" style="text-decoration: none"><img src="/mozilla-16.png" alt="Mozilla Add-ons" title="Mozilla Add-ons" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';
/*CZilla*/
			if ($rozsirenia->czilla) {
					echo '<td class="centered" width="20"><a href="http://www.czilla.cz/doplnky/rozsireni/'.$rozsirenia->czilla.'" style="text-decoration: none"><img src="/wp-content/plugins/mozsk-rozsirenia/czilla.gif" alt="Česká lokalizácia" title="Česká lokalizácia" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';

/*verzia*/
			echo '<td class="centered">'.$rozsirenia->verzia.'</td>';

/*lokalizator*/
			echo '<td>' . $rozsirenia->localizator . '</td>';

/*datum*/
			echo '<td class="centered">' . mysql2date("d.m.Y",$rozsirenia->datum) . '</td>';

/*podporovane*/
			if ($rozsirenia->podporovane) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/podpora.png" alt="Podporované" title="Podporované" /></td>';
					}
				else echo '<td class="centered"> </td>';

/*neaktualne*/
			if ($rozsirenia->neaktualne==1) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/aktualne.png" alt="Neaktuálne" title="Neaktuálne" /></td>';
					}
			else if ($rozsirenia->neaktualne==2) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/podporastop.png" alt="Už nepodporované" title="Už nepodporované" /></td>';

					}
			else if ($rozsirenia->neaktualne==3) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/vyvojstop.png" alt="Ďalej sa nevyvíja" title="Ďalej sa nevyvíja" /></td>';

					}
				else echo '<td class="centered"> </td>';
/*FX 2.0*/
			if (($rozsirenia->urcene_ff_od <="2.0b2") && (($rozsirenia->urcene_ff_do =="2.0.0.*") || ($rozsirenia->urcene_ff_do =="2.0") || ($rozsirenia->urcene_ff_do >"2.0b2") || ($rozsirenia->urcene_ff_do =="2.0+"))) {
					echo '<td class="centered" width="40"><img src="/wp-content/images/logo/ff_small.png" alt="Podporuje FX 2.0" title="Podporuje FX 2.0 ('.$rozsirenia->urcene_ff_od.' až '.$rozsirenia->urcene_ff_do.')" /></td>';
					}
				else if ($rozsirenia->urcene_ff_od !="") {
					echo '<td class="centered"><img src="/wp-content/images/logo/ff_cb.png" alt="Nepodporuje FX 2.0" title="Nepodporuje FX 2.0 ('.$rozsirenia->urcene_ff_od.' až '.$rozsirenia->urcene_ff_do.')" /></td>';
					}
				else
				echo '<td class="centered"> </td>';


/*TB 2.0*/
			if (($rozsirenia->urcene_tb_od <="2.0b2") && (($rozsirenia->urcene_tb_do =="2.0.0.*") || ($rozsirenia->urcene_tb_do =="2.0.*") || ($rozsirenia->urcene_tb_do =="2.0") || ($rozsirenia->urcene_tb_do >"2.0b2") || ($rozsirenia->urcene_tb_do =="2.0+"))) {
					echo '<td class="centered" width="40"><img src="/wp-content/images/logo/tb_small.png" alt="Podporuje TB 2.0" title="Podporuje TB 2.0 ('.$rozsirenia->urcene_tb_od.' až '.$rozsirenia->urcene_tb_do.')" /></td>';
					}
				else if ($rozsirenia->urcene_tb_od !="") {
					echo '<td class="centered"><img src="/wp-content/images/logo/tb_cb.png" alt="Nepodporuje TB 2.0" title="Nepodporuje TB 2.0 ('.$rozsirenia->urcene_tb_od.' až '.$rozsirenia->urcene_tb_do.')" /></td>';
					}
				else
				echo '<td class="centered"> </td>';

/*interna*/		
			echo '<td>'.$rozsirenia->interna_pozn.'</td>';

			echo '</tr>';
			$r++;
		}
	
	
	}
	else
	{
		echo '<tr><td colspan="6">V sandboxe nie sú žiadne nevydané rozšírenia.</td></tr>';
	}
?>
	</tbody>
	</table>
	</div>

<div>&nbsp;</div>

<?php /*-------------nevydane-----------------*/ ?>


<h2>Nevydané rozšírenia: <?php $count = $wpdb->get_var("SELECT COUNT(DISTINCT nazov) 
			FROM mozsk_rozsirenia WHERE publikovat=0");
			echo "$count";
			?></h2>
	<div style="border:solid 1px #ccc;margin-bottom:10px">
	<table id="the-list-y" width="100%" cellpadding="3" cellspacing="3">
	<thead>
		<tr>
			<th scope="col"><img src="/wp-content/plugins/mozsk-rozsirenia/vyvojstop.png" alt="Neplatný odkaz na súbor" title="Neplatný odkaz na súbor" /></th>
			<th scope="col">Názov</th>
			<th scope="col" colspan="3"> Odkazy</th>
			<th scope="col">Verzia</th>
			<th scope="col">Lokalizuje</th>
			<th scope="col" style="width: 10px" title="Podporované">Podp.</th>
			<th scope="col" style="width: 10px" title="Neaktualizované">Neakt.</th>
			<th scope="col" style="width: 250px">Interná poznámka</th>
		</tr>
	</thead>
	<tbody>
<?php
	$r = 0;
	$rozsirenia = $wpdb->get_results("SELECT urlid,nazov,url,verzia,localizator,podporovane,neaktualne,homepage,addon,czilla,interna_pozn FROM mozsk_rozsirenia, mozsk_roz_localizator WHERE publikovat=0 AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id GROUP BY nazov ORDER BY nazov ASC");
	if($rozsirenia)
	{
		foreach ($rozsirenia as $rozsirenie) 
		{
			
			$homepage = htmlspecialchars($rozsirenie->homepage, ENT_QUOTES);
			if($r % 2) echo '<tr>';
			else echo '<tr class="alternate">';

/*korektny odkaz*/
			$ok = 0;
			$url = explode(',',$rozsirenie->url);
			if (count($url)>1) {
			 if ((is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[0])) && (is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[2]))) $ok=1;
			 }
			 else if(is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[0])) $ok = 1;
			if ($ok==0) 
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/vyvojstop.png" alt="Neplatný odkaz na súbor" title="Neplatný odkaz na súbor" /></td>';
				else echo '<td class="centered"> </td>';
/*nazov*/
			echo '<td><a href="'.$folder.$rozsirenie->urlid.'/test/">'.$rozsirenie->nazov.'</a></td>';

/*homepage*/
			if ($homepage) {
					echo '<td class="centered" width="20"><a href="'.$homepage.'" style="text-decoration: none"><img src="/wp-content/images/logo/rozsirenia_lok/domov.png" alt="Domovská stránka" title="Domovská stránka" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';

/*Addon*/
			if ($rozsirenie->addon) {
					echo '<td class="centered" width="20"><a href="https://addons.mozilla.org/extensions/moreinfo.php?id='.$rozsirenie->addon.'" style="text-decoration: none"><img src="/mozilla-16.png" alt="Mozilla Add-ons" title="Mozilla Add-ons" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';

/*CZilla*/
			if ($rozsirenie->czilla) {
					echo '<td class="centered" width="20"><a href="http://www.czilla.cz/doplnky/rozsireni/'.$rozsirenie->czilla.'" style="text-decoration: none"><img src="/wp-content/plugins/mozsk-rozsirenia/czilla.gif" alt="Česká lokalizácia" title="Česká lokalizácia" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';

/*verzia*/
			echo '<td class="centered">'.$rozsirenie->verzia.'</td>';

/*localizator*/
			echo '<td>' . $rozsirenie->localizator . '</td>';
			if ($rozsirenie->podporovane) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/podpora.png" alt="Podporované" title="Podporované" /></td>';
					}
				else echo '<td class="centered"> </td>';

/*neaktualne*/
			if ($rozsirenie->neaktualne==1) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/aktualne.png" alt="Neaktuálne" title="Neaktuálne" /></td>';
					$neakt++;
					}
			else if ($rozsirenie->neaktualne==2) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/podporastop.png" alt="Už nepodporované" title="Už nepodporované" /></td>';
					$neakt++;
					}
			else if ($rozsirenie->neaktualne==3) {
					echo '<td class="centered"><img src="/wp-content/plugins/mozsk-rozsirenia/vyvojstop.png" alt="Ďalej sa nevyvíja" title="Ďalej sa nevyvíja" /></td>';
					$neakt++;
					}
				else echo '<td class="centered"> </td>';

/*interna*/
			echo '<td>'.$rozsirenie->interna_pozn.'</td>';
			echo '</tr>';
			$r++;
		}
	}
	else
	{
		echo '<tr><td colspan="6">V databáze nie sú žiadne nevydané rozšírenia.</td></tr>';
	}
?>
	</tbody>
	</table>
	</div>
<div>&nbsp;</div>

<?php /*-------------zapisane-----------------*/ ?>


<h2>Zapísané rozšírenia: <?php $count = $wpdb->get_var("SELECT COUNT(DISTINCT nazov) 
			FROM mozsk_rozsirenia WHERE publikovat=2");
			echo "$count";
			?></h2>
	<div style="border:solid 1px #ccc;margin-bottom:10px">
	<table id="the-list-z" width="100%" cellpadding="3" cellspacing="3">
	<thead>
		<tr>
			<th scope="col">Názov</th>
			<th scope="col" colspan="3"> Odkazy</th>
			<th scope="col">Lokalizuje</th>
			<th scope="col">Verzia</th>
			<th scope="col" style="width: 250px">Interná poznámka</th>
		</tr>
	</thead>
	<tbody>
<?php
	$r = 0;
	$rozsirenia = $wpdb->get_results("SELECT nazov,verzia,localizator,podporovane,neaktualne,homepage,addon,interna_pozn,czilla FROM mozsk_rozsirenia, mozsk_roz_localizator WHERE publikovat=2 AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id GROUP BY nazov ORDER BY nazov ASC");
	if($rozsirenia)
	{
		foreach ($rozsirenia as $rozsirenie) 
		{
			
			$homepage = htmlspecialchars($rozsirenie->homepage, ENT_QUOTES);
			if($r % 2) echo '<tr>';
			else echo '<tr class="alternate">';

/*nazov*/
			echo '<td>'.$rozsirenie->nazov.'</td>';

/*homepage*/
			if ($homepage) {
					echo '<td class="centered" width="20"><a href="'.$homepage.'" style="text-decoration: none"><img src="/wp-content/images/logo/rozsirenia_lok/domov.png" alt="Domovská stránka" title="Domovská stránka" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';

/*Addon*/
			if ($rozsirenie->addon) {
					echo '<td class="centered" width="20"><a href="https://addons.mozilla.org/extensions/moreinfo.php?id='.$rozsirenie->addon.'" style="text-decoration: none"><img src="/mozilla-16.png" alt="Mozilla Add-ons" title="Mozilla Add-ons" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';

/*CZilla*/
			if ($rozsirenie->czilla) {
					echo '<td class="centered" width="20"><a href="http://www.czilla.cz/doplnky/rozsireni/'.$rozsirenie->czilla.'" style="text-decoration: none"><img src="/wp-content/plugins/mozsk-rozsirenia/czilla.gif" alt="Česká lokalizácia" title="Česká lokalizácia" /></a></td>';
					}
				else echo '<td class="centered" width="20"> </td>';

/*lokalizator*/
			echo '<td>' . $rozsirenie->localizator . '</td>';

/*verzia*/
			echo '<td class="centered">'.$rozsirenie->verzia.'</td>';

/*interna*/
			echo '<td>'.$rozsirenie->interna_pozn.'</td>';
			echo '</tr>';
			$r++;
		}
	}
	else
	{
		echo '<tr><td colspan="6">V databáze nie sú zapísané rozšírenia.</td></tr>';
	}
?>
	</tbody>
	</table>
	</div>
<div>&nbsp;</div>

<?php /*-------------lokalizatori-----------------*/ ?>

<h2>Lokalizátori: <?php $count = $wpdb->get_var("SELECT COUNT(localizator) 
			FROM mozsk_roz_localizator");
			echo "$count";
			?></h2>
	<div style="border:solid 1px #ccc;margin-bottom:10px">
	<table id="the-list-w" width="100%" cellpadding="3" cellspacing="3">
	<thead>
		<tr>
			<th scope="col">Meno</th>
			<th scope="col">Kontakt</th>
			<th scope="col">Počet rozšírení</th>
			<th scope="col">Vydaných</th>
			<th scope="col" style="width: 40px"><img src="/wp-content/plugins/mozsk-rozsirenia/podpora.png" alt="Podporované" title="Podporované" /></th>
			<th scope="col">Nevydaných</th>
			<th scope="col">Zapísaných</th>
		</tr>
	</thead>
	<tbody>
<?php
	$r = 0;
	$rozsirenia = $wpdb->get_results("SELECT id, localizator,lok_url, email FROM mozsk_roz_localizator GROUP BY localizator ORDER BY localizator ASC");
	if($rozsirenia)
	{
		foreach ($rozsirenia as $rozsirenie) 
		{
			$count = $wpdb->get_var("SELECT COUNT(DISTINCT urlid) 
			FROM mozsk_rozsirenia WHERE autor=$rozsirenie->id");
			
			$vyd = $wpdb->get_var("SELECT COUNT(DISTINCT urlid) 
			FROM mozsk_rozsirenia WHERE autor=$rozsirenie->id AND publikovat=1");

			$nevyd = $wpdb->get_var("SELECT COUNT(DISTINCT urlid) 
			FROM mozsk_rozsirenia WHERE autor=$rozsirenie->id AND publikovat=0");

			$zapis = $wpdb->get_var("SELECT COUNT(DISTINCT urlid) 
			FROM mozsk_rozsirenia WHERE autor=$rozsirenie->id AND publikovat=2");
			
			$podpora = $wpdb->get_var("SELECT COUNT(*) 
			FROM mozsk_rozsirenia WHERE autor=$rozsirenie->id AND publikovat=1 AND podporovane=1 AND id IN ($rozmax)");

		
			if($r % 2) echo '<tr>';
			else echo '<tr class="alternate">';
			
			
			echo '<td><a href="/rozsirenia/lok/'.$rozsirenie->lok_url.'/">' . $rozsirenie->localizator . '</a></td>';
			echo '<td><a href="mailto:'.$rozsirenie->email.'">' . $rozsirenie->email . '</a></td>';
			echo '<td style="text-align:center">'. $count . '</td>';
			echo '<td style="text-align:center">'. $vyd . '</td>';
			if ($vyd==0) echo '<td style="text-align:center">'. $podpora . '</td>';
			else echo '<td style="text-align:center">'. $podpora . '<br/><small>('.round($podpora*100/$vyd).' %)</small></td>';
			echo '<td style="text-align:center">'. $nevyd . '</td>';
			echo '<td style="text-align:center">'. $zapis . '</td>';
			echo '</tr>';
			$r++;
		}
    $count = $wpdb->get_var("SELECT COUNT(DISTINCT urlid) 
			FROM mozsk_rozsirenia");
 	$vyd = $wpdb->get_var("SELECT COUNT(DISTINCT urlid) 
			FROM mozsk_rozsirenia WHERE publikovat=1");

	$nevyd = $wpdb->get_var("SELECT COUNT(DISTINCT urlid) 
			FROM mozsk_rozsirenia WHERE publikovat=0");

	$zapis = $wpdb->get_var("SELECT COUNT(DISTINCT urlid) 
			FROM mozsk_rozsirenia WHERE publikovat=2");

	if($r % 2) echo '<tr>';
			else echo '<tr class="alternate">';
     echo '<td class="spolu" colspan="2">Spolu:</td><td class="spolu centered">'. $count . '</td><td class="spolu centered">'. $vyd . '</td><td class="spolu centered">'. $podp . '</td><td class="spolu centered">'. $nevyd . '</td><td class="spolu centered">'. $zapis . '</td></tr>';
	}
	else
	{
		echo '<tr><td colspan="6">V databáze nie sú žiadne rozšírenia.</td></tr>';
	}
?>
	</tbody>
	</table>
	</div>
