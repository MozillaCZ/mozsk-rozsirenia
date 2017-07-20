<?php

if (empty($wp)) {
	require_once('wp-config.php');
	wp('feed=rss2');
}

header('Content-type: text/xml; charset=' . get_settings('blog_charset'), true);
$more = 1;

?>
<?php echo '<?xml version="1.0" encoding="'.get_settings('blog_charset').'"?'.'>'; ?>

<!-- generator="wordpress/<?php bloginfo_rss('version') ?>" -->
<rss version="2.0" 
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	<?php do_action('rss2_ns'); ?>
>

<channel>
	<title><?php bloginfo_rss('name') ?> - rozšírenia</title>
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></pubDate>
	<generator>http://wordpress.org/?v=<?php bloginfo_rss('version'); ?></generator>
	<language><?php echo get_option('rss_language'); ?></language> 
	
<?php
$ids = $wpdb->get_col("SELECT MAX(id) AS id FROM mozsk_rozsirenia WHERE publikovat=1 AND TO_DAYS(datum)>TO_DAYS(CURDATE())-7 GROUP BY nazov ORDER BY id DESC");
if($ids)
		{
			foreach($ids AS $id)
				{
					$rozsirenie = $wpdb->get_row("SELECT urlid, nazov, starsie, popis, datum,cas, verzia FROM mozsk_rozsirenia WHERE mozsk_rozsirenia.id=$id");
          $stav = ($rozsirenie->starsie == '') ? 'Nové: ' : 'Aktualizované: '; 
          $urlid = $rozsirenie->urlid;
          $predmet = $stav . $rozsirenie->nazov . ' '.$rozsirenie->verzia;
          $predmet = htmlspecialchars($predmet); // ošetrenie na entity
          $popis = $rozsirenie->popis;
          $popis = htmlspecialchars($popis); // ošetrenie na entity
          $datum = strtotime($rozsirenie->datum ." ".$rozsirenie->cas);
//		  $den = date("d",$datum);
//		  $mesiac = date("m",$datum);
//		  $rok = date("Y",$datum);
//	      $datum = date ("r", mktime (0,0,0,$mesiac,$den,$rok));
	      $datum = date ("r", $datum);
          echo '<item>';
          echo '<title>'.$predmet.'</title>';
          echo '<link>http://www.mozilla.sk/rozsirenia/'.$urlid.'/</link>';
          echo '<description>'.$popis.'</description>';
          echo '<pubDate>'.$datum.'</pubDate>';
          echo '</item>';
        } 
    }
?>
</channel>
</rss>

