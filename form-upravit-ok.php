<?php
$uprav_id = $_POST['param1'];
$urlid = $wpdb->escape($_POST['urlid']);
$nazov = $wpdb->escape($_POST['nazov']);
$popis = $_POST['popis'];
$obrazok = $wpdb->escape($_POST['obrazok']);
$lokalizuje = $wpdb->escape($_POST['lokalizuje']);
$datum = $wpdb->escape($_POST['datum']);
$cas = $wpdb->escape($_POST['cas']);
$verzia = $wpdb->escape($_POST['verzia']);
$neaktualne =  $_POST['neaktualne'];
$urcene_ff_od = $wpdb->escape($_POST['urcene_ff_od']);
$urcene_ff_do = $wpdb->escape($_POST['urcene_ff_do']);
$urcene_tb_od = $wpdb->escape($_POST['urcene_tb_od']);
$urcene_tb_do = $wpdb->escape($_POST['urcene_tb_do']);
$urcene_ms_od = $wpdb->escape($_POST['urcene_ms_od']);
$urcene_ms_do = $wpdb->escape($_POST['urcene_ms_do']);
$urcene_sm_od = $wpdb->escape($_POST['urcene_sm_od']);
$urcene_sm_do = $wpdb->escape($_POST['urcene_sm_do']);
$urcene_ns_od = $wpdb->escape($_POST['urcene_ns_od']);
$urcene_ns_do = $wpdb->escape($_POST['urcene_ns_do']);
$urcene_sb_od = $wpdb->escape($_POST['urcene_sb_od']);
$urcene_sb_do = $wpdb->escape($_POST['urcene_sb_do']);
$urcene_nv_od = $wpdb->escape($_POST['urcene_nv_od']);
$urcene_nv_do = $wpdb->escape($_POST['urcene_nv_do']);
$urcene_fl_od = $wpdb->escape($_POST['urcene_fl_od']);
$urcene_fl_do = $wpdb->escape($_POST['urcene_fl_do']);
$urcene_sng_od = $wpdb->escape($_POST['urcene_sng_od']);
$urcene_sng_do = $wpdb->escape($_POST['urcene_sng_do']);
$url = $wpdb->escape($_POST['url']);
$podporovane = ($_POST['podporovane'] == 'on' ? 1:0);
$forum = $wpdb->escape($_POST['forum']);
$nahlasit = $wpdb->escape($_POST['nahlasit']);
$homepage = $wpdb->escape($_POST['homepage']);
$czilla = $wpdb->escape($_POST['czilla']);
$addon = $wpdb->escape($_POST['addon']);
$publikovat = $_POST['publikovat'];
$starsie = $wpdb->escape($_POST['starsie']);
$poznamka = $_POST['poznamka'];
$kategoria = $wpdb->escape($_POST['kategoria']);
$interna_pozn = $_POST['interna_pozn'];

$wpdb->query("UPDATE mozsk_rozsirenia SET
urlid = '$urlid',
nazov = '$nazov',
popis = '$popis',
obrazok = '$obrazok',
autor = '$lokalizuje',
datum = '$datum',
cas = '$cas',
verzia = '$verzia',
neaktualne = '$neaktualne',
urcene_ff_od = '$urcene_ff_od',
urcene_ff_do = '$urcene_ff_do',
urcene_tb_od = '$urcene_tb_od',
urcene_tb_do = '$urcene_tb_do',
urcene_ms_od = '$urcene_ms_od',
urcene_ms_do = '$urcene_ms_do',
urcene_sm_od = '$urcene_sm_od',
urcene_sm_do = '$urcene_sm_do',
urcene_ns_od = '$urcene_ns_od',
urcene_ns_do = '$urcene_ns_do',
urcene_sb_od = '$urcene_sb_od',
urcene_sb_do = '$urcene_sb_do',
urcene_nv_od = '$urcene_nv_od',
urcene_nv_do = '$urcene_nv_do',
urcene_fl_od = '$urcene_fl_od',
urcene_fl_do = '$urcene_fl_do',
urcene_sng_od = '$urcene_sng_od',
urcene_sng_do = '$urcene_sng_do',
url = '$url',
podporovane = '$podporovane', 
forum = '$forum',
nahlasit = '$nahlasit',
homepage = '$homepage',
czilla = '$czilla',
addon = '$addon',
publikovat = '$publikovat',
starsie = '$starsie',
poznamka = '$poznamka',
kategoria = '$kategoria',
interna_pozn = '$interna_pozn'
WHERE id = '$uprav_id'
");
if ($neaktualne==1) {
  $lokmail = $wpdb->get_var("SELECT email FROM mozsk_roz_localizator WHERE id='$lokalizuje'");
  if ($lokmail != "") {
      mail($lokmail, 'Mozilla.sk - Upozornenie pre lokalizátora: Nová verzia rozšírenia '.$nazov,
         'Pekný deň,<br><br>rozšírenie '.$nazov.' bolo jeho autorom aktualizované na novšiu verziu, ktorá však neobsahuje slovenskú lokalizáciu. V rámci tvojich možností je potrebné lokalizáciu tohto rozšírenia aktualizovať na najnovšiu verziu.<br><br>
         Rozšírenie na stránke Mozilla Addons: <a href="https://addons.mozilla.org/extensions/moreinfo.php?id='.$addon.'">'.$nazov.'</a>
         <br><br>Vopred ďakujeme.<br><br>Vlado Valaštiak<br>Mozilla.sk<br><br>Poznámka: Táto e-mailová správa je automaticky generovaná systémom správy rozšírení portálu Mozilla.sk. Ak ďalej nechceš dostávať tieto upozornenia, napíš na adresu valastiak@mozilla.sk.', "From:Vlado Valaštiak [Mozilla.sk] <valastiak@mozilla.sk>\nContent-type: text/html; charset=utf-8");
      }
  }
  
$wpdb->query("UPDATE mozsk_rozsirenia SET publikovat = '$publikovat' WHERE urlid = '$urlid'");

?>
<div class="updated">
	<p><strong>Rozšírenie upravené. (ID=<?php echo $uprav_id ?>)</strong>
  <?php if ($lokmail != "") echo "<br/>Notifikácia odoslaná na adresu $lokmail."; ?>
  </p>
</div>
<?php
require_once("form-zoznam.php");
?>
