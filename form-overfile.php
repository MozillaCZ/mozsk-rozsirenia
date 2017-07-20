<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Overenie súboru na serveri</title>
<link rel="stylesheet" href="http://www.mozilla.sk/wp-admin/wp-admin.css?version=2.0" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<div class="wrap">

<?php
$url = $_GET["url"];
$ok = 0;
?>
<h2>Kontrola súboru na serveri</h2>
<?php 
	$url = explode(',',$url);

		if (count($url)>1) {
			 if (is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[0])) $OK++;
			 if (is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[2])) $OK = $OK + 2;
			 }
			 else if(is_file('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[0])) $OK = 3;
			 
			 
			
			 if (count($url)>1) {
				echo '<a href="/wp-content/download/rozsirenia/'.$url[0].'">'.$url[0].'</a>';
				echo ' <small class="velkost">veľkosť: <strong>';
				if (($OK==1) || ($OK==3)) echo round(filesize('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[0])/1024).' kB</strong></small> - <strong>OK</strong><br/>';
				else echo 'neznáma</strong></small> - <strong><span style="color: red">FAILED</span></strong><br/>';
				
				echo '<a href="/wp-content/download/rozsirenia/'.$url[2].'">'.$url[2].'</a>';
				echo ' <small class="velkost">veľkosť: <strong>';
				if (($OK==2) || ($OK==3)) echo round(filesize('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[2])/1024).' kB</strong></small> - <strong>OK</strong>';
				else echo 'neznáma</strong></small> - <strong><span style="color: red">FAILED</span></strong>';
			
			}
			else
			{ 	
				echo '<a href="/wp-content/download/rozsirenia/'.$url[0].'">'.$url[0].'</a>';
				echo ' <small class="velkost">veľkosť: <strong>';
				if (($OK==1) || ($OK==3)) echo round(filesize('/home/epicnet/mozilla.sk/wp-content/download/rozsirenia/'.$url[0])/1024).' kB</strong></small> - <strong>OK</strong>';
				else echo 'neznáma</strong></small> - <strong><span style="color: red">FAILED</span></strong>';

			}

		echo "<br/><br/><div class=\"submit\"><input type=\"button\" onclick=\"window.close();\" value=\"OK\" /></div>";

?>

</div>

</body>
</html>