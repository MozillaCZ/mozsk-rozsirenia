<form method="post" action=""><h2>Pridať rozšírenie</h2>
<?php
$urlid = '';
$nazov = '';
$popis = '';
$obrazok = '';
$lokalizuje_new = '';
$lok_url = '';
$lok_hmp = '';
$lok_profil = 0;
$datum = date('Y-m-d');
$cas = date('H:i:s');
$verzia = '';
$urcene_ff_od = '';
$urcene_ff_do = '';
$urcene_tb_od = '';
$urcene_tb_do = '';
$urcene_ms_od = '';
$urcene_ms_do = '';
$urcene_sm_od = '';
$urcene_sm_do = '';
$urcene_ns_od = '';
$urcene_ns_do = '';
$urcene_sb_od = '';
$urcene_sb_do = '';
$urcene_nv_od = '';
$urcene_nv_do = '';
$urcene_fl_od = '';
$urcene_fl_do = '';
$urcene_sng_od = '';
$urcene_sng_do = '';
$url = '';
$podporovane = 0;
$forum = '17';
$nahlasit = '';
$homepage = '';
$czilla = '';
$addon = '';
$publikovat = 2;
$starsie = '';
$poznamka = '';
$kategoria = 1;
require_once("form-upravit-inc.php");
?>
	<div class="submit">
		<input type="submit" name="ok-submit" value="Pridať rozšírenie &raquo;" />
	</div>
	<input id="todo" name="todo" type="hidden" value="pridat-ok"/>
	<input id="param1" name="param1" type="hidden" value=""/>
</form>
