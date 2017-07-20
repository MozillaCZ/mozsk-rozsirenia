<?php
/*
Plugin Name: Rozšírenia
Plugin URI: http://www.mozilla.sk/
Description: Správa tabuľky rozšírení.
Author: Braňo Pavelka &amp; wladow
Version: 0.7.7
Author URI: http://www.webpilot.sk/
*/ 

function msk_PanelRozsirenia() 
{
	global $wpdb;

	echo '<div class="wrap">';
	if (isset($_POST['todo'])) 
	{
		$todo = $_POST['todo'];
		//echo "todo: $todo";
		switch($todo)
		{
			case 'pridat':
				require_once("form-pridat.php");
				break;
			case 'pridat-ok':
				require_once("form-pridat-ok.php");
				break;
			case 'zmazat-ok':
				require_once("form-zmazat-ok.php");
				break;
			case 'upravit':
				require_once("form-upravit.php");
				break;
			case 'upravit-ok':
				require_once("form-upravit-ok.php");
				break;
			case 'pridat-ver':
				require_once("form-pridat-ver.php");
				break;
			case 'pridat-ver-ok':
				require_once("form-pridat-ver-ok.php");
				break;
			case 'zoznam-st':
				require_once("form-st-ver.php");
				break;
			case 'zoznam-st-ok':
				require_once("form-zoznam.php");
				break;
			case 'prekop-obrazky':
				require_once("prekop-obrazky.php");
				break;
			default:
				echo '<p>Neviem, čo mám robiť.</p>';
				break;
		}
	}
	else
	{
		require_once("form-zoznam.php");
	} 
	echo "</div>";
}

function msk_title() 
{
	global $wpdb;

  $urlid = get_query_var('rozsirenie');

	switch ($urlid) {
	case 'firefox': 	    echo ' pre Firefox';
					break;
	case 'thunderbird': 	echo ' pre Thunderbird';
					break;
	case 'mozilla-sunbird': 	    echo ' pre Sunbird';
					break;
	case 'seamonkey': 	  echo ' pre SeaMonkey';
					break;
	case 'netscape': 	    echo ' pre Netscape';
					break;
	case 'mozilla-suite': echo ' pre Mozilla Suite';
					break;
	case 'nvu': 	        echo ' pre NVU';
					break;
	case 'songbird': 	    echo ' pre Songbird';
					break;
	case 'flock': 	      echo ' pre Flock';
					break;
	case 'lok': 	        echo ' podľa lokalizátorov';
                        $ver = get_query_var('verzia');
                        if ($ver != '') $rozsirenie = $wpdb->get_var("SELECT localizator FROM mozsk_roz_localizator WHERE lok_url='$ver' LIMIT 1");
                        if ($rozsirenie != '') echo ' &raquo; '.$rozsirenie;
					break;
	case 'kat': 	        echo ' podľa kategórií';
                        $ver = get_query_var('verzia');
                        if ($ver != '') $rozsirenie = $wpdb->get_var("SELECT kategoria FROM mozsk_roz_meta WHERE kat_url='$ver' LIMIT 1");
                        if ($rozsirenie != '') echo ' &raquo; '.$rozsirenie;
					break;
	case 'pripravuje-sa': echo ' &raquo; Pripravuje sa';
					break;
	case 'vyhladavanie':  echo ' &raquo; Vyhľadávanie';
					break;
						
  default: {
          if ($urlid != '' ) {
		        $rozsirenie = $wpdb->get_var("SELECT nazov FROM mozsk_rozsirenia WHERE urlid='$urlid' ORDER BY id DESC LIMIT 1");
          	if ($rozsirenie != '') echo ' &raquo; '.$rozsirenie;
    			   }
	         }			
	}			

}

function msk_PanelPrehlad() 
{
	global $wpdb;

	echo '<div class="wrap">';
	require_once("prehlad.php");
	echo "</div>";
}

function msk_PanelRozZoznam() 
{
	echo '<div class="wrap"><h2>Zoznam rozšírení</h2></div>';
}


function msk_AddOptionsPage() 
{
	if (function_exists('add_submenu_page')) 
	{
		add_submenu_page('plugins.php', 'Rozšírenia', 'Rozšírenia', 3, basename(__FILE__), 'msk_PanelRozsirenia');
		$page = add_submenu_page('plugins.php', 'Interný prehľad rozšírení', 'Interný prehľad rozšírení', 1, 'prehlad.php','msk_PanelPrehlad');

  /* Using registered $page handle to hook stylesheet loading */
  add_action('admin_print_styles-' . $page, 'msk_admin_styles');

	}
}

function msk_admin_styles()
{
  /*
  * It will be called only on your plugin admin page, enqueue our stylesheet here
  */
  wp_enqueue_style('msk_Stylesheet');
}


function msk_Install()
{
	global $wpdb;
	
	$table_name = 'mozsk_rozsirenia';
	if($wpdb->get_var("show tables like '$table_name'") != $table_name)
	{
		$sql = "CREATE TABLE `$table_name` (
  `id` int(11) NOT NULL auto_increment,
  `urlid` varchar(50) default NULL,
  `nazov` varchar(80) default NULL,
  `popis` text,
  `obrazok` varchar(100) default NULL,
  `autor` int(11) default '16',
  `datum` date default NULL,
  `cas` time default NULL,
  `verzia` varchar(20) default NULL,
  `urcene_ff_od` varchar(10) default NULL,
  `urcene_ff_do` varchar(10) default NULL,
  `urcene_tb_od` varchar(10) default NULL,
  `urcene_tb_do` varchar(10) default NULL,
  `urcene_ms_od` varchar(10) default NULL,
  `urcene_ms_do` varchar(10) default NULL,
  `urcene_sm_od` varchar(10) default NULL,
  `urcene_sm_do` varchar(10) default NULL,
  `urcene_ns_od` varchar(10) default NULL,
  `urcene_ns_do` varchar(10) default NULL,
  `urcene_sb_od` varchar(10) default NULL,
  `urcene_sb_do` varchar(10) default NULL,
  `urcene_nv_od` varchar(10) default NULL,
  `urcene_nv_do` varchar(10) default NULL,
  `urcene_fl_od` varchar(10) default NULL,
  `urcene_fl_do` varchar(10) default NULL,
  `urcene_sng_od` varchar(10) default NULL,
  `urcene_sng_do` varchar(10) default NULL,
  `url` varchar(100) default NULL,
  `podporovane` tinyint(1) default '0',
  `forum` varchar(100) default NULL,
  `nahlasit` varchar(100) default NULL,
  `homepage` varchar(100) default NULL,
  `czilla` varchar(100) default NULL,
  `addon` varchar(100) default NULL,
  `publikovat` tinyint(1) default '0',
  `starsie` varchar(50) default NULL,
  `poznamka` text,
  `kategoria` int(11) default '1',
  `neaktualne` tinyint(1) default '0',
  `interna_pozn` text,
  PRIMARY KEY (`id`) );";
		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql);
		//$wpdb->query($sql);
	}
}

function msk_AddAdminJS() 
{
	if($_SERVER['SCRIPT_NAME'] == '/wp-admin/plugins.php' && $_GET['page'] == basename(__FILE__))
	{
		echo '<script type="text/javascript">
//<![CDATA[
function msk_AskDel(id)
{
	answer = window.confirm("Naozaj odstrániť toto rozšírenie? Pozor, po stlačení OK ihneď maže!");
	if(answer)
	{
		document.getElementById("todo").value = "zmazat-ok";
		document.getElementById("param1").value = id;
		document.getElementById("ok-submit").click();
	}
}

function msk_Edit(id)
{
	document.getElementById("todo").value = "upravit";
	document.getElementById("param1").value = id;
	document.getElementById("ok-submit").click();
}

function msk_NuVer(id)
{
	document.getElementById("todo").value = "pridat-ver";
	document.getElementById("param1").value = id;
	document.getElementById("ok-submit").click();
}

function msk_StVer(id)
{
	document.getElementById("todo").value = "zoznam-st";
	document.getElementById("param1").value = id;
	document.getElementById("ok-submit").click();
}

function msk_DigPix(id)
{
	document.getElementById("todo").value = "prekop-obrazky";
	document.getElementById("param1").value = id;
	document.getElementById("ok-submit").click();
}

function msk_ImgWin()
{
	var urlid = document.getElementById("urlid").value;
	var obrazok = document.getElementById("obrazok").value;
	var id;
	if(obrazok.length != 0)
	{
		var p = obrazok.indexOf(".png");
		id = obrazok.substring(0, p-1);
	}
	else
	{
		id = urlid;
	}
	w = window.open("/wp-content/plugins/mozsk-rozsirenia/form-obrazok.php?id="+id, "Obrazok", "width=650,height=200,resizable=yes,scrollbars=yes");
	w.focus();
}

function msk_locWin()
{
	var id;
	w = window.open("/wp-content/plugins/mozsk-rozsirenia/form-localizator.php", "Lokalizátori", "width=650,height=550,resizable=no,scrollbars=yes");
	w.focus();
}

function URLencode(sStr) {
    return escape(sStr).
             replace(/\+/g, "%2B").
                replace(/\"/g,"%22").
                   replace(/\'/g, "%27").
                     replace(/\//g,"%2F");
  }
  
function msk_overWin()
{
	var url = document.getElementById("url").value;
	w = window.open("/wp-content/plugins/mozsk-rozsirenia/form-overfile.php?url="+URLencode(url), "Overit", "width=650,height=200,resizable=yes,scrollbars=yes");
	w.focus();
}

//]]>
</script>';
	}
	//echo '<!-- ' . $_SERVER['SCRIPT_NAME'] . ' -->';
}

function msk_RewriteRules($rules)
{
	global $wp_rewrite;

	$msk_rules['rozsirenia/?$'] = "index.php?pagename=rozsirenia/test";
	$msk_rules['rozsirenia/(.*)/(.*)/?$'] = "index.php?pagename=rozsirenia/test&rozsirenie=\$matches[1]&verzia=\$matches[2]";
	$msk_rules['rozsirenia/(.*)/?$'] = "index.php?pagename=rozsirenia/test&rozsirenie=\$matches[1]";

	$msk_rules = array_merge($msk_rules,$rules);
	return $msk_rules;
}

function msk_QueryVars($vars)
{
	$vars[] = 'rozsirenie';
	$vars[] = 'verzia';
	
	return $vars;
}

function msk_admin_init()
    {
        /* Register our stylesheet. */
  wp_register_style('msk_Stylesheet', '/wp-content/plugins/mozsk-rozsirenia/custom.css');
}


add_action('admin_init', 'msk_admin_init');
add_action('admin_menu', 'msk_AddOptionsPage');
add_action('admin_head', 'msk_AddAdminJS');
add_action('activate_mozsk-rozsirenia/mozsk-rozsirenia.php','msk_Install');
add_filter('rewrite_rules_array', 'msk_RewriteRules'); 
add_filter('query_vars', 'msk_QueryVars');

?>
