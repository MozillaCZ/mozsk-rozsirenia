<?php
$urlid = $wpdb->escape($_POST['urlid']);
$nazov = $wpdb->escape($_POST['nazov']);
$popis = $_POST['popis'];
$obrazok = $wpdb->escape($_POST['obrazok']);
$lokalizuje = $wpdb->escape($_POST['lokalizuje']);
$datum = $wpdb->escape($_POST['datum']);
$cas = $wpdb->escape($_POST['cas']);
$verzia = $wpdb->escape($_POST['verzia']);
$neaktualne = $_POST['neaktualne'];
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
$interna_pozn = $wpdb->escape($_POST['interna_pozn']);

$wpdb->query("INSERT INTO mozsk_rozsirenia
(
urlid, nazov, popis, obrazok, autor, datum, cas, verzia, neaktualne,
urcene_ff_od, urcene_ff_do, urcene_tb_od, urcene_tb_do,
urcene_ms_od, urcene_ms_do, urcene_sm_od, urcene_sm_do,
urcene_ns_od, urcene_ns_do, urcene_sb_od, urcene_sb_do,
urcene_nv_od, urcene_nv_do, urcene_fl_od, urcene_fl_do, 
urcene_sng_od, urcene_sng_do, url, podporovane, 
forum, nahlasit, homepage, czilla, addon, publikovat, starsie, poznamka, kategoria, interna_pozn
) VALUES (
'$urlid', '$nazov', '$popis', '$obrazok', '$lokalizuje', '$datum', '$cas', '$verzia', '$neaktualne',
'$urcene_ff_od', '$urcene_ff_do', '$urcene_tb_od', '$urcene_tb_do',
'$urcene_ms_od', '$urcene_ms_do', '$urcene_sm_od', '$urcene_sm_do',
'$urcene_ns_od', '$urcene_ns_do', '$urcene_sb_od', '$urcene_sb_do',
'$urcene_nv_od', '$urcene_nv_do', '$urcene_fl_od', '$urcene_fl_do',
'$urcene_sng_od', '$urcene_sng_do', '$url', '$podporovane',
'$forum', '$nahlasit', '$homepage', '$czilla', '$addon','$publikovat', '$starsie', '$poznamka', '$kategoria', '$interna_pozn'
)");

?>
<div class="updated">
	<p><strong>Rozšírenie pridané. (ID=<?php echo $wpdb->insert_id ?>)</strong></p>
</div>
<?php
require_once("form-zoznam.php");
?>
