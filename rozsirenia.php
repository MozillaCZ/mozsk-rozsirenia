<?php
/*
Template Name: Rozsirenia
*/
get_header();
$folder = '/rozsirenia/';
?>
<div id="content" class="narrowcolumn">
<?php
$wpdb->hide_errors();

/*
formatovacie funkcie - start
*/
function formatdatum($datum)
{
	$datum=strtotime($datum);
	$dnes=mktime(23,59,59,date('m'),date('d'),date('Y'));
		if($dnes - $datum < 86400)
			$vysledok='<strong><span style="color: red">dnes</span></strong>';
		else if (($dnes - $datum > 86400) && ($dnes - $datum < 172800))
			$vysledok='<strong><span style="color: black">včera</span></strong>';
		else
			$vysledok=date("d.m.Y",$datum);
	return '['.$vysledok.']';
}

function formattext($text,$adresa)
{
	if (strlen($text) > 197) {
//		$text=substr(strip_tags(trim($text)) , 0, 197);
		$text=substr(trim($text) , 0, 197);
		$pos = strrpos($text, " ");
//		$text=substr(strip_tags(trim($text)) , 0, $pos);
		$text=substr(trim($text) , 0, $pos);
		$vysledok=$text.'&hellip;&nbsp;<small>[<a href="/rozsirenia/'.$adresa.'/">&raquo;&raquo;</a>]</small>';
	}
	else $vysledok=$text;
return $vysledok;
}

function formatverziu($verzia, $produkt)
{
$fx='2.0.0.1';
$tb='1.5.0.9';
	if ($produkt=='tb') {
		
		if ($verzia == '1.4' || $verzia == '1.4.0') $vysledok='1.5b1';
		else if ($verzia == '1.4.1') $vysledok='1.5b2';
		else if($verzia > $tb)  $vysledok=$tb.' <small><acronym title="verzia '.$verzia.'">(+ aktuálne nočné zostavenia)</acronym></small>';
		else $vysledok=$verzia;
	}
	else if ($produkt=='ff')
	{
		if (($verzia >= '1.1') && ($verzia < '1.4')) $vysledok='<acronym title="testovacia verzia pred verziou 1.5">Deer Park</acronym>';
		else if ($verzia == '1.4' || $verzia == '1.4.0') $vysledok='1.5b1';
		else if ($verzia == '1.4.1') $vysledok='1.5b2';
		else if (($verzia >= '1.6') && ($verzia < '2.0')) $vysledok='<acronym title="testovacia verzia pred verziou 2.0">Bon Echo</acronym>';
//		else if(($verzia > $fx)&&($verzia!='2.0.0.*')) $vysledok=$fx.' <small><acronym title="verzia '.$verzia.'">(+ aktuálne nočné zostavenia)</acronym></small>';
		else if($verzia > '2.0c') $vysledok=$fx.' <small><acronym title="verzia '.$verzia.'">(+ aktuálne nočné zostavenia)</acronym></small>';
		else $vysledok=$verzia;
	}
	else
	$vysledok=$verzia;
return $vysledok;
}

/*
formatovacie funkcie - end
*/


$urlid = get_query_var('rozsirenie');
$ver = get_query_var('verzia');
$folder = '/rozsirenia/';

/*
hlavna stranka rozsireni - start
*/
if($urlid == "rss")
{
require("/home/epicnet/mozilla.sk/wp-content/plugins/mozsk-rozsirenia/rss.php");
}
else
if($urlid == "")
{
	?>
	<div class="post-page">
	<h2>Zoznam rozšírení lokalizovaných do slovenčiny</h2>

	<div class="entrytext">
	Rozšírenia sú balíky, ktoré sa <a href="/rozsirenia/instalacia-rozsireni/">inštalujú</a> do aplikácií od <a href="http://www.mozilla.org" hreflang="en">Mozilly</a> a odvodených a pridávajú im nové funkcie. Ponúkame vám ich slovenské lokalizácie roztriedené podľa jednotlivých produktov. Všetky rozšírenia lokalizované do slovenčiny musia byť nainštalované do <strong>slovenskej</strong> verzie programu, inak nebudú fungovať v slovenskom jazyku. 
	<div class="post-top">
		<div class="post-bottom">
			<div class="post">
				<table border="0">
					<tr>
						<td>
							<ul class="rozsirenia">
								<li><img src="/wp-content/images/logo/firefox48.png" alt="Firefox" /> <a href="<?php echo $folder ?>firefox/">Rozšírenia pre Mozilla Firefox</a></li>
								<li><img src="/wp-content/images/logo/thunderbird48.png" alt="Thunderbird" /> <a href="<?php echo $folder ?>thunderbird/">Rozšírenia pre Mozilla Thunderbird</a></li>
								<li><img src="/wp-content/images/logo/ms48.png" alt="Mozilla Suite" /> <a href="<?php echo $folder ?>mozilla-suite/">Rozšírenia pre Mozilla Suite</a></li>
							</ul>
						</td>
						<td style="border-left: 1px solid rgb(180, 198, 215);">
							<ul class="rozsirenia">
								<li class="small"><img src="/wp-content/images/logo/nvu_small.png" alt="NVU" /> <a href="<?php echo $folder ?>nvu/">NVU</a></li>
								<li class="small"><img src="/wp-content/images/logo/sn_small.png" alt="Sunbird" /> <a href="<?php echo $folder ?>sunbird/">Sunbird</a></li>
								<li class="small"><img src="/wp-content/images/logo/ns_small.png" alt="Netscape" /> <a href="<?php echo $folder ?>netscape/">Netscape</a></li>
								<li class="small"><img src="/wp-content/images/logo/sm_small.png" alt="SeaMonkey" /> <a href="<?php echo $folder ?>seamonkey/">SeaMonkey</a></li>
								<li class="small"><img src="/wp-content/images/logo/fl_small.png" alt="Flock" /> <a href="<?php echo $folder ?>flock/">Flock</a></li>
								<li class="small"><img src="/wp-content/images/logo/sng_small.png" alt="Songbird" /> <a href="<?php echo $folder ?>doplnky/songbird/">Songbird</a></li>
							</ul>	
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>	
	
	<?php

/* nove rozsirenia - vypis */
	$rozsirenia = $wpdb->get_results("SELECT urlid,nazov,verzia,datum,popis,
											mozsk_rozsirenia.kategoria, mozsk_roz_meta.kat_url, mozsk_roz_meta.kategoria, mozsk_roz_meta.id,
											autor, mozsk_roz_localizator.lok_url, mozsk_roz_localizator.id, mozsk_roz_localizator.localizator
										FROM mozsk_rozsirenia, mozsk_roz_meta, mozsk_roz_localizator
										WHERE publikovat=1 AND starsie='' HAVING TO_DAYS(datum)>TO_DAYS(CURDATE())-7 AND mozsk_rozsirenia.kategoria=mozsk_roz_meta.id AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id ORDER BY nazov ASC");
	if($rozsirenia)
		{
			echo '<h3 class="new2">Nové rozšírenia lokalizované do slovenčiny<br/><small>pridané za posledných 7 dní</small></h3>';
			echo '<dl>';
			foreach ($rozsirenia as $rozsirenie) 
				{
					echo '<dt>';
					echo '<a href="'.$folder.$rozsirenie->urlid.'/">'.$rozsirenie->nazov.' <small>v'.$rozsirenie->verzia.'</small></a><small> '.formatdatum($rozsirenie->datum).'</small></dt>';
					echo '<dd style="padding-bottom: 5px">';
					echo formattext($rozsirenie->popis,$rozsirenie->urlid).'<br/><small>Kategória:&nbsp;<a href="'.$folder.'kat/'.$rozsirenie->kat_url.'/">'.$rozsirenie->kategoria.'</a> | Lokalizuje: <a href="'.$folder.'lok/'.$rozsirenie->lok_url.'/">'.$rozsirenie->localizator.'</a></small>';
					echo '</dd>';

				}
			echo '</dl>';
		}

/* aktualizovane rozsirenia - vypis */

    $ids = $wpdb->get_col("SELECT MAX(id) AS id FROM mozsk_rozsirenia WHERE publikovat=1 AND starsie!='' AND TO_DAYS(datum)>TO_DAYS(CURDATE())-7 GROUP BY nazov ORDER BY nazov ASC");
	if($ids)
		{
			echo '<h3 class="update2">Aktualizované rozšírenia<br/><small>za posledných 7 dní</small></h3>';
			echo '<dl>';
			foreach($ids AS $id)
				{
					$rozsirenie = $wpdb->get_row("SELECT urlid, nazov, mozsk_roz_meta.kategoria, popis, datum, verzia FROM mozsk_rozsirenia, mozsk_roz_meta WHERE mozsk_rozsirenia.id=$id AND mozsk_rozsirenia.kategoria=mozsk_roz_meta.id");
//	if($rozsirenia)
//		{
//			foreach ($rozsirenia as $rozsirenie) 
//				{
					echo '<dt>';
					echo '<a href="'.$folder.$rozsirenie->urlid.'/">'.$rozsirenie->nazov.' <small>v'.$rozsirenie->verzia.'</small></a><small> '.formatdatum($rozsirenie->datum).'</small></dt>';
					echo '<dd style="padding-bottom: 5px">';
					echo formattext($rozsirenie->popis,$rozsirenie->urlid);
					echo '</dd>';
				}
			echo '</dl>';
		}

	echo '<div class="info">Ak sa chcete aj vy pustiť do lokalizácií rozšírení, prečítajte si predtým naše návody <a href="/rozsirenia/lokalizacia-rozsireni-mozilla-aplikacii/">Lokalizácia rozšírení</a> resp. <a href="/rozsirenia/ako-spravne-lokalizovat/">Ako správne lokalizovať</a> a pozrite si <a href="/rozsirenia/pripravuje-sa/">zoznam pripravovaných rozšírení</a>.</div>';
	echo '</div>';
	echo '</div>';
}

/*
hlavna stranka rozsireni - end
*/

/*
podstranky - filtre
*/

else if (($urlid == "firefox") || ($urlid == "thunderbird") || ($urlid == "mozilla-suite")) 
{
	include("/home/epicnet/mozilla.sk/wp-content/plugins/mozsk-rozsirenia/filter_main.php");
}

else if ($urlid == "nvu" || $urlid == "sunbird" || $urlid == "seamonkey" || $urlid == "flock" || $urlid == "netscape") 
{
	include("/home/epicnet/mozilla.sk/wp-content/plugins/mozsk-rozsirenia/filter_minor.php");
}

else if ($urlid == "kat") 
{
	include("/home/epicnet/mozilla.sk/wp-content/plugins/mozsk-rozsirenia/filter_kat.php");
}

else if ($urlid == "lok") 
{
	include("/home/epicnet/mozilla.sk/wp-content/plugins/mozsk-rozsirenia/filter_lok.php");
}

else if ($urlid == "pripravuje-sa") 
{
	include("/home/epicnet/mozilla.sk/wp-content/plugins/mozsk-rozsirenia/pripravuje-sa.php");
}

else if ($urlid == "vyhladavanie") 
{
	include("/home/epicnet/mozilla.sk/wp-content/plugins/mozsk-rozsirenia/vyhladavanie.php");
}

else
{
	
/*
vypis stranky rozsirenia
*/


	if ($ver=='test' && ($user_ID))
	$rozsirenie = $wpdb->get_row("SELECT * FROM mozsk_rozsirenia, mozsk_roz_meta, mozsk_roz_localizator WHERE publikovat=0 AND urlid='$urlid' AND mozsk_rozsirenia.kategoria=mozsk_roz_meta.id AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id ORDER BY mozsk_rozsirenia.id DESC");
	else if ($ver=='')
	$rozsirenie = $wpdb->get_row("SELECT * FROM mozsk_rozsirenia, mozsk_roz_meta, mozsk_roz_localizator WHERE publikovat=1 AND urlid='$urlid' AND mozsk_rozsirenia.kategoria=mozsk_roz_meta.id AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id ORDER BY mozsk_rozsirenia.id DESC");
	else if ($ver!='test')
	$rozsirenie = $wpdb->get_row("SELECT * FROM mozsk_rozsirenia, mozsk_roz_meta, mozsk_roz_localizator WHERE publikovat=1 AND urlid='$urlid' AND verzia='$ver' AND mozsk_rozsirenia.kategoria=mozsk_roz_meta.id AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id ORDER BY mozsk_rozsirenia.id DESC");
	else $rozsirenie="";
	
	if($rozsirenie)
	{
		$id = $rozsirenie->id;
		$urlid = htmlspecialchars($rozsirenie->urlid, ENT_QUOTES);
		$nazov = $rozsirenie->nazov;
		$popis = $rozsirenie->popis;
		$obrazok = htmlspecialchars($rozsirenie->obrazok, ENT_QUOTES);
		$lokalizuje = htmlspecialchars($rozsirenie->localizator, ENT_QUOTES);
		$lok_url = htmlspecialchars($rozsirenie->lok_url, ENT_QUOTES);
		$lok_profil = $rozsirenie->profil;
		$lok_hmp = htmlspecialchars($rozsirenie->lok_hmp, ENT_QUOTES);
		
		$df = get_settings('date_format');
		$datum = mysql2date($df, $rozsirenie->datum);
		
		$verzia = htmlspecialchars($rozsirenie->verzia, ENT_QUOTES);
		$kategoria = htmlspecialchars($rozsirenie->kategoria, ENT_QUOTES);
		
		$urcene_ff_od = htmlspecialchars($rozsirenie->urcene_ff_od, ENT_QUOTES);
		$urcene_ff_do = htmlspecialchars($rozsirenie->urcene_ff_do, ENT_QUOTES);
		$urcene_tb_od = htmlspecialchars($rozsirenie->urcene_tb_od, ENT_QUOTES);
		$urcene_tb_do = htmlspecialchars($rozsirenie->urcene_tb_do, ENT_QUOTES);
		$urcene_ms_od = htmlspecialchars($rozsirenie->urcene_ms_od, ENT_QUOTES);
		$urcene_ms_do = htmlspecialchars($rozsirenie->urcene_ms_do, ENT_QUOTES);
		$urcene_sm_od = htmlspecialchars($rozsirenie->urcene_sm_od, ENT_QUOTES);
		$urcene_sm_do = htmlspecialchars($rozsirenie->urcene_sm_do, ENT_QUOTES);
		$urcene_ns_od = htmlspecialchars($rozsirenie->urcene_ns_od, ENT_QUOTES);
		$urcene_ns_do = htmlspecialchars($rozsirenie->urcene_ns_do, ENT_QUOTES);
		$urcene_sb_od = htmlspecialchars($rozsirenie->urcene_sb_od, ENT_QUOTES);
		$urcene_sb_do = htmlspecialchars($rozsirenie->urcene_sb_do, ENT_QUOTES);
		$urcene_nv_od = htmlspecialchars($rozsirenie->urcene_nv_od, ENT_QUOTES);
		$urcene_nv_do = htmlspecialchars($rozsirenie->urcene_nv_do, ENT_QUOTES);
		$urcene_fl_od = htmlspecialchars($rozsirenie->urcene_fl_od, ENT_QUOTES);
		$urcene_fl_do = htmlspecialchars($rozsirenie->urcene_fl_do, ENT_QUOTES);
		$urcene_sng_od = htmlspecialchars($rozsirenie->urcene_sng_od, ENT_QUOTES);
		$urcene_sng_do = htmlspecialchars($rozsirenie->urcene_sng_do, ENT_QUOTES);

		$ff = ($urcene_ff_od != '') || ($urcene_ff_do != '');
		$tb = ($urcene_tb_od != '') || ($urcene_tb_do != '');
		$ms = ($urcene_ms_od != '') || ($urcene_ms_do != '');
		$sm = ($urcene_sm_od != '') || ($urcene_sm_do != '');
		$ns = ($urcene_ns_od != '') || ($urcene_ns_do != '');
		$sb = ($urcene_sb_od != '') || ($urcene_sb_do != '');
		$nv = ($urcene_nv_od != '') || ($urcene_nv_do != '');
		$fl = ($urcene_fl_od != '') || ($urcene_fl_do != '');
		$sng = ($urcene_sng_od != '') || ($urcene_sng_do != '');

		$url = explode(',',$rozsirenie->url);
		for ($i=0;$i<count($url);$i++)
              {
				if (($i % 2)==0)  $url[$i] = '/wp-content/download/rozsirenia/'.$url[$i];
			  }
		$podporovane = $rozsirenie->podporovane;

		$forum = htmlspecialchars($rozsirenie->forum, ENT_QUOTES);
		$nahlasit = htmlspecialchars($rozsirenie->nahlasit, ENT_QUOTES);
		$homepage = htmlspecialchars($rozsirenie->homepage, ENT_QUOTES);
		$czilla = htmlspecialchars($rozsirenie->czilla, ENT_QUOTES);
		$addon = htmlspecialchars($rozsirenie->addon, ENT_QUOTES);
		$publikovat = $rozsirenie->publikovat;
		$starsie = htmlspecialchars($rozsirenie->starsie, ENT_QUOTES);
		$poznamka = $rozsirenie->poznamka;
		?>
		
		
		<div class="post-page">
		<h2>Rozšírenie <?php echo $nazov ?></h2>
			<div class="entrytext">
				<p><?php echo $popis ?> Rozšírenie je zaradené do kategórie <a href="<?php echo $folder.'kat/'.$rozsirenie->kat_url.'/">'.$kategoria ?></a>.</p>
				<?php
				
				if(($obrazok!="") && (file_exists('/home/epicnet/mozilla.sk/wp-content/images/rozsirenia/'.$obrazok)))
					{
						if (file_exists('/home/epicnet/mozilla.sk/wp-content/images/rozsirenia/t/'.$obrazok)) 
							echo '<p><a href="?page_id=55&amp;mski=rozsirenia%2F'.$obrazok.'&amp;mskt='.urlencode('Rozšírenie '.$nazov).'"><img class="centered" src="/wp-content/images/rozsirenia/t/'.$obrazok.'" alt="'.$nazov.'" border="1"/></a></p>';
						else
							echo '<p><img src="/wp-content/images/rozsirenia/'.$obrazok.'" alt="Ukážka rozšírenia '.$nazov.'" title="Ukážka rozšírenia '.$nazov.'" class="centered" /></p>';
					}
				?>
				
				<h3>Informácie o lokalizácii</h3>
				<dl>
					<dt><strong><?php if ($lokalizuje=='Codik') echo 'Autor'; else echo 'Lokalizuje'; ?></strong></dt>
					<dd><?php echo $lokalizuje;
//						if ($lok_profil) echo ' [<a href="/o-nas#'.$lok_url.'">profil</a>]';
//						if ($lok_hmp) echo ', [<a href="'.$lok_hmp.'">domovská stránka</a>]'; 
//						echo ', [<a href="'.$folder.'lok/'.$lok_url.'/">ďalšie rozšírenia autora</a>]</small>'; 
					if ($lok_profil) echo ' <a href="/o-nas#'.$lok_url.'" title="Profil"><img src="/wp-content/images/logo/rozsirenia_lok/profil.png" alt="Profil" /></a>';
					if ($lok_hmp) echo ' <a href="'.$lok_hmp.'" title="Domovská stránka"><img src="/wp-content/images/logo/rozsirenia_lok/domov.png" alt="Domovská stránka" /></a>'; 
					echo ' <a href="'.$folder.'lok/'.$lok_url.'/" title="Ďalšie lokalizácie rozšírení od tohto autora"><img src="/wp-content/images/logo/rozsirenia_lok/rozsirenia.png" alt="Ďalšie lokalizácie rozšírení od tohto autora" /></a>'; 
	
					 echo '</dd>';
					
					$najnovsia = $wpdb->get_var("SELECT MAX(datum) FROM mozsk_rozsirenia WHERE publikovat=1 AND nazov='$nazov'");
					if ($najnovsia==$rozsirenie->datum) 
						echo '<dt><strong>Posledná preložená verzia</strong></dt>';
					else 
						echo '<dt><strong>Preložená verzia</strong></dt>';
					
					echo '<dd>'.$verzia.'</dd>';
					if (($najnovsia!=$rozsirenie->datum) && ($ver!='test')) {
					$temp = $wpdb->get_row("SELECT podporovane,homepage,czilla,addon,verzia FROM mozsk_rozsirenia WHERE publikovat=1 AND nazov='$nazov' AND datum='$najnovsia'"); 
							echo '</dl><div class="info"><small class="black">Existuje novšia verzia (<strong>v'.$temp->verzia.'</strong>) rozšírenia <strong>'.$nazov.'</strong>. Ak je to možné, odporúčame používať vždy <a href="'.$folder.$urlid.'/">najnovšiu verziu</a>.</small></div><dl>';					
							
							$podporovane = $temp->podporovane;
							$homepage = htmlspecialchars($temp->homepage, ENT_QUOTES);
							$czilla = htmlspecialchars($temp->czilla, ENT_QUOTES);
							$addon = htmlspecialchars($temp->addon, ENT_QUOTES);
					
					}
					?>
					<dt><strong>Dátum vydania lokalizácie</strong></dt>
					<dd><?php echo $datum ?></dd>
				</dl>
				
				<h3>Určené pre</h3>
				<ul>
					<?php if ($ff): ?><li class="ico-ff">Firefox <?php echo formatverziu($urcene_ff_od,'ff'); if (($urcene_ff_do) && ($urcene_ff_do!=$urcene_ff_od)) echo ' až '.formatverziu($urcene_ff_do,'ff') ?></li><?php endif; ?>
					<?php if ($tb): ?><li class="ico-tb">Thunderbird <?php echo formatverziu($urcene_tb_od,'tb'); if (($urcene_tb_do) && ($urcene_tb_do!=$urcene_tb_od)) echo ' až '.formatverziu($urcene_tb_do,'tb') ?></li><?php endif; ?>
					<?php if ($ms): ?><li class="ico-ms">Mozilla Suite <?php echo $urcene_ms_od; if (($urcene_ms_do) && ($urcene_ms_do!=$urcene_ms_od)) echo ' až '.$urcene_ms_do ?></li><?php endif; ?>
					<?php if ($sm): ?><li class="ico-sm">SeaMonkey <?php echo $urcene_sm_od; if (($urcene_sm_do) && ($urcene_sm_do!=$urcene_sm_od)) echo ' až '.$urcene_sm_do ?></li><?php endif; ?>
					<?php if ($ns): ?><li class="ico-ns">Netscape <?php echo $urcene_ns_od; if (($urcene_ns_do) && ($urcene_ns_do!=$urcene_ns_od)) echo ' až '.$urcene_ns_do ?></li><?php endif; ?>
					<?php if ($sb): ?><li class="ico-sn">Sunbird <?php echo $urcene_sb_od; if (($urcene_sb_do) && ($urcene_sb_do!=$urcene_sb_od)) echo ' až '.$urcene_sb_do ?></li><?php endif; ?>
					<?php if ($nv): ?><li class="ico-nvu">Nvu <?php echo $urcene_nv_od; if (($urcene_nv_do) && ($urcene_nv_do!=$urcene_nv_od)) echo ' až '.$urcene_nv_do ?></li><?php endif; ?>
					<?php if ($fl): ?><li class="ico-fl">Flock <?php echo $urcene_fl_od; if (($urcene_fl_do) && ($urcene_fl_do!=$urcene_fl_od)) echo ' až '.$urcene_fl_do ?></li><?php endif; ?>
					<?php if ($sng): ?><li class="ico-sng">Songbird <?php echo $urcene_sng_od; if (($urcene_sng_do) && ($urcene_sng_do!=$urcene_sng_od)) echo ' až '.$urcene_sng_do ?></li><?php endif; ?>
				</ul>
				
								
				<?php if (count($url)>1)
				{ ?>
						
				<div class="downloadarea">
					<div class="downloadbox1"><div class="download2-top"><div class="download2-bottom"><div class="download2">
						<small>verzia pre <strong><?php echo $url[1] ?></strong></small><br />
						<a href="#" onclick="javascript:xpi = {'<?php echo $nazov.' '.$verzia ?>': '<?php echo $url[0] ?>'}; InstallTrigger.install(xpi);">Nainštalovať</a> | 
						<a href="<?php echo $url[0] ?>">Stiahnuť</a><br />
						<small class="velkost">veľkosť: <strong><?php if(is_file('/home/epicnet/mozilla.sk'.$url[0])) echo round(filesize('/home/epicnet/mozilla.sk'.$url[0])/1024).' kB'; else echo ' neznáma' ?></strong></small>
					</div></div></div></div>
					<div class="downloadbox2"><div class="download2-top"><div class="download2-bottom"><div class="download2">
						<small>verzia pre <strong><?php echo $url[3] ?></strong></small><br />
						<a href="#" onclick="javascript:xpi = {'<?php echo $nazov.' '.$verzia ?>': '<?php echo $url[2] ?>'}; InstallTrigger.install(xpi);">Nainštalovať</a> | 
						<a href="<?php echo $url[2] ?>">Stiahnuť</a><br />
						<small class="velkost">veľkosť: <strong><?php if(is_file('/home/epicnet/mozilla.sk'.$url[2])) echo round(filesize('/home/epicnet/mozilla.sk'.$url[2])/1024).' kB'; else echo ' neznáma' ?></strong></small>
					</div></div></div></div>
				</div>
			
				<?php
				}
				else
				{ ?>

				<div class="download-top"><div class="download-bottom"><div class="download">
					<?php if($ff | $ms | $sm | $ns | $sb | $nv | $fl) { ?> 
					<a href="#" onclick="javascript:xpi = {'<?php echo $nazov.' '.$verzia ?>': '<?php echo $url[0] ?>'}; InstallTrigger.install(xpi);">Nainštalovať</a> | 
					<?php } ?>
					<a href="<?php echo $url[0] ?>">Stiahnuť</a><br />
					<small class="velkost">veľkosť: <strong><?php if(is_file('/home/epicnet/mozilla.sk'.$url[0])) echo round(filesize('/home/epicnet/mozilla.sk'.$url[0])/1024).' kB'; else echo ' neznáma' ?></strong></small>
				</div></div></div>

				<?php } ?>
				
				<?php if ($poznamka): ?><div class="error"><?php echo $poznamka ?></div><?php endif; ?>
				
				<h3>Súvisiace odkazy</h3>
				<ul>
					<li>Máte problém s inštaláciou rozšírenia? Prečítajte si náš <a href="/rozsirenia/instalacia-rozsireni/">návod</a>.</li>
					<li>Máte otázku týkajúcu sa tohto rozšírenia? Napíšte nám do <a href="http://forum.mozilla.sk/viewforum.php?f=<?php echo $forum ?>">fóra</a>.</li>
					<li>Našli ste nejakú chybu v&nbsp;preklade tohto rozšírenia? <a href="http://forum.mozilla.sk/viewtopic.php?t=<?php echo $nahlasit ?>">Nahláste nám ju!</a></li>
					<?php if ($homepage): ?><li style="list-style-image: url('/wp-content/images/logo/rozsirenia_lok/domov.png')"><a href="<?php echo $homepage.'"'; if ($lokalizuje!='Codik') echo ' hreflang="en"' ?> >Oficiálna stránka rozšírenia <?php echo $nazov ?></a></li><?php endif; ?>
					<?php if ($czilla): ?><li style="list-style-image: url('/wp-content/plugins/mozsk-rozsirenia/czilla.gif')"><a href="http://www.czilla.cz/doplnky/rozsireni/<?php echo $czilla ?>" hreflang="cs">Česká lokalizácia rozšírenia <?php echo $nazov ?></a></li><?php endif; ?>
					<?php if ($addon): ?><li style="list-style-image: url('/mozilla-16.png')"><a href="https://addons.mozilla.org/extensions/moreinfo.php?id=<?php echo $addon ?>" hreflang="en">Stránka rozšírenia na serveri Mozilla Add-ons</a></li><?php endif; ?>
				</ul>


			<?php
			
	/* vypis novsich verzii ak rozsirenie nie je najaktualnejsie */

			if (($najnovsia!=$rozsirenie->datum) && ($publikovat==1)) 
			{
				$max_starsie = $wpdb->get_var("SELECT starsie FROM mozsk_rozsirenia WHERE publikovat=1 AND datum='$najnovsia' AND nazov='$nazov'");
				if ($max_starsie)
				{
				$novrozsirenia = $wpdb->get_results("SELECT url,verzia FROM mozsk_rozsirenia WHERE publikovat=1 AND (id IN($max_starsie) OR (datum='$najnovsia' AND nazov='$nazov')) AND datum>'$rozsirenie->datum' ORDER BY id DESC limit 3");
				
				if($novrozsirenia)
				{
					echo '<h3>Novšie verzie</h3><blockquote><dl>';
					foreach ($novrozsirenia as $rozsirenie) 
						{
							$url = explode(',',$rozsirenie->url);
							for ($i=0;$i<count($url);$i++)
								{
									if (($i % 2)==0)  $url[$i] = '/wp-content/download/rozsirenia/'.$url[$i];
								}

							echo '<dt>Verzia <a href="'.$folder.$urlid.'/'.urlencode($rozsirenie->verzia).'/">'.$rozsirenie->verzia.'</a></dt>';
							echo "<dd><small>";
			
							if (count($url)>1) 
								{
			
								?>
				
									<strong><?php echo $url[1] ?></strong>: <a href="#" onclick="javascript:xpi = {'<?php echo $nazov.' '.$verzia ?>': '<?php echo $url[0] ?>'}; InstallTrigger.install(xpi);">Nainštalovať</a> | 
									<a href="<?php echo $url[0] ?>">Stiahnuť</a>
									(veľkosť: <strong><?php echo round(filesize('/home/epicnet/mozilla.sk'.$url[0])/1024) ?> kB</strong>)
									<br/>
									<strong><?php echo $url[3] ?></strong>: <a href="#" onclick="javascript:xpi = {'<?php echo $nazov.' '.$verzia ?>': '<?php echo $url[0] ?>'}; InstallTrigger.install(xpi);">Nainštalovať</a> | 
									<a href="<?php echo $url[2] ?>">Stiahnuť</a>
									(veľkosť: <strong><?php echo round(filesize('/home/epicnet/mozilla.sk'.$url[2])/1024) ?> kB</strong>)
				
									<?php
								}

							else

								{
									if($ff | $ms | $sm | $ns | $sb | $nv | $fl) 
										{  ?>
											<a href="#" onclick="javascript:xpi = {'<?php echo $nazov.' '.$verzia ?>': '<?php echo $url[0] ?>'}; InstallTrigger.install(xpi);">Nainštalovať</a> | 
										<?php } ?>
									<a href="<?php echo $url[0] ?>">Stiahnuť</a>
									(veľkosť: <strong><?php echo round(filesize('/home/epicnet/mozilla.sk'.$url[0])/1024) ?> kB</strong>)
									<?php
								}
							echo '<br/><br/></small></dd>';

						}
					echo '</dl></blockquote>';
				}
				}
			}

	/* vypis starsich verzii ak rozsirenie nie je najaktualnejsie */

			if ($starsie)
			{			
				$strozsirenia = $wpdb->get_results("SELECT url,verzia FROM mozsk_rozsirenia WHERE publikovat=1 AND id IN($starsie) ORDER BY id DESC limit 3");
				if ($strozsirenia)
				{
					echo '<h3>Staršie verzie</h3><blockquote><dl>';
					foreach ($strozsirenia as $rozsirenie) 
						{
							$url = explode(',',$rozsirenie->url);
							for ($i=0;$i<count($url);$i++)
								{
									if (($i % 2)==0)  $url[$i] = '/wp-content/download/rozsirenia/'.$url[$i];
								}

							echo '<dt>Verzia <a href="'.$folder.$urlid.'/'.urlencode($rozsirenie->verzia).'/">'.$rozsirenie->verzia.'</a></dt>';
						
							echo "<dd><small>";
			
							if (count($url)>1) 
								{
			
									?>
									<strong><?php echo $url[1] ?></strong>: <a href="#" onclick="javascript:xpi = {'<?php echo $nazov.' '.$verziav ?>': '<?php echo $url[0] ?>'}; InstallTrigger.install(xpi);">Nainštalovať</a> | 
									<a href="<?php echo $url[0] ?>">Stiahnuť</a>
									(veľkosť: <strong><?php echo round(filesize('/home/epicnet/mozilla.sk'.$url[0])/1024) ?> kB</strong>)
									<br/>
									<strong><?php echo $url[3] ?></strong>: <a href="#" onclick="javascript:xpi = {'<?php echo $nazov.' '.$verzia ?>': '<?php echo $url[0] ?>'}; InstallTrigger.install(xpi);">Nainštalovať</a> | 
									<a href="<?php echo $url[2] ?>">Stiahnuť</a>
									(veľkosť: <strong><?php echo round(filesize('/home/epicnet/mozilla.sk'.$url[2])/1024) ?> kB</strong>)
				
									<?php
								}

							else

								{
				
									if($ff | $ms | $sm | $ns | $sb | $nv | $fl) 
										{  ?>
											<a href="#" onclick="javascript:xpi = {'<?php echo $nazov.' '.$verzia ?>': '<?php echo $url[0] ?>'}; InstallTrigger.install(xpi);">Nainštalovať</a> | 
										<?php } ?>
									<a href="<?php echo $url[0] ?>">Stiahnuť</a>
									(veľkosť: <strong><?php echo round(filesize('/home/epicnet/mozilla.sk'.$url[0])/1024) ?> kB</strong>)
									<?php
								}
							echo '<br/><br/></small></dd>';

						}
					echo '</dl></blockquote>';
				}
			}
			
			?>
			<?php if (!$podporovane): ?>
				<h3>Upozornenie</h3>
				Slovenská jazyková verzia zatiaľ nie je podporovaná vydavateľom rozšírenia. To znamená, že v&nbsp;prípade, že sa objaví nová verzia a&nbsp;prehliadač si ju automaticky nainštaluje, budete si musieť opäť stiahnuť slovenskú verziu tohoto rozšírenia manuálne.
			<?php endif; ?>

			</div>
		</div>
<?php

/*
koniec vypis rozsirenia
*/

/*
vypis 404
*/

	}
	else
	{
//		echo '<div class="post"><h2>Rozšírenie nenájdené!</h2></div>';
//		echo "<a href=\"http://{$_SERVER['HTTP_HOST']}/index.php?pagename=rozsirenia/$urlid\">sem</a>";
//	wp_redirect(get_404_template());
	$stranky = $wpdb->get_var("SELECT id FROM $wpdb->posts WHERE post_parent=13 AND post_name='$urlid'");
	echo 'stranky: '.$stranky;	
	if ($stranky) {

					echo '<script>document.location.href="/index.php?pagename=rozsirenia/'.$urlid.'"</script>';

					}
	else echo '<script>document.location.href="/404/"</script>';
	}

}

?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
