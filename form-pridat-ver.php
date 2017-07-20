<form method="post" action=""><h2>Nová verzia rozšírenia</h2>
<?php
if (isset($_POST['param1'])) 
{
	$uprav_id = $_POST['param1'];
	$rozsirenie = $wpdb->get_row("SELECT * FROM mozsk_rozsirenia WHERE id='$uprav_id'");
	if($rozsirenie)
	{
		$urlid = htmlspecialchars($rozsirenie->urlid, ENT_QUOTES);
		$nazov = htmlspecialchars($rozsirenie->nazov, ENT_QUOTES);
		$popis = htmlspecialchars($rozsirenie->popis, ENT_QUOTES);
		$obrazok = htmlspecialchars($rozsirenie->obrazok, ENT_QUOTES);
		$lokalizuje = $rozsirenie->autor;
		$datum = date('Y-m-d');
		$cas = date('H:i:s');
		$verzia = htmlspecialchars($rozsirenie->verzia, ENT_QUOTES);
		$neaktualne = 0;
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
		$url = htmlspecialchars($rozsirenie->url, ENT_QUOTES);
		$podporovane = $rozsirenie->podporovane;
		$forum = htmlspecialchars($rozsirenie->forum, ENT_QUOTES);
		$nahlasit = htmlspecialchars($rozsirenie->nahlasit, ENT_QUOTES);
		$homepage = htmlspecialchars($rozsirenie->homepage, ENT_QUOTES);
		$czilla = htmlspecialchars($rozsirenie->czilla, ENT_QUOTES);
		$addon = htmlspecialchars($rozsirenie->addon, ENT_QUOTES);
		$publikovat = $rozsirenie->publikovat;
		if(trim($rozsirenie->starsie) == '')
		{
			$starsie = $uprav_id;
		}
		else
		{
			$ids = explode(',', htmlspecialchars($rozsirenie->starsie, ENT_QUOTES));
			$ids = array_merge($ids, array($uprav_id));
			if (count($ids)>10) {
          $ids = array_reverse($ids);
          $del = array_pop($ids);
          $ids = array_reverse($ids);
          }
			$starsie = implode(',', $ids);
		}
		$poznamka = htmlspecialchars($rozsirenie->poznamka, ENT_QUOTES);
		$interna_pozn = htmlspecialchars($rozsirenie->interna_pozn, ENT_QUOTES);
		$kategoria = $rozsirenie->kategoria;
		require_once("form-upravit-inc.php");
	}
	else die ("Osudová chyba: Také ID tu nemám.");
}
?>
	<div class="submit">
		<input type="submit" name="ok-submit" value="Potvrdiť údaje &raquo;" />
	</div>
	<input id="todo" name="todo" type="hidden" value="pridat-ok"/>
	<input id="param1" name="param1" type="hidden" value="<?php echo $uprav_id ?>"/>
</form>
