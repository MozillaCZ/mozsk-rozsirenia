<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Upload obrázku rozšírenia</title>
<link rel="stylesheet" href="http://www.mozilla.sk/wp-admin/wp-admin.css?version=2.0" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<div class="wrap">

<?php
require ("lib-obrazok.php"); 
$id = $_GET["id"];
$pid = $_POST["id"];
?>
<h2>Upload obrázku <?php echo $id?></h2>
<?php 
if(!$pid) 
{
?>
<form enctype="multipart/form-data" method="post" action="" id="f1" name="f1">
<p>
	<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
	<input type="file" id="subor" name="subor" title="Zdroj obrazku na upload" />
	<input type="hidden" name="id" value="<?php echo $id?>" />
	
</p>
<div class="submit">
	<input id="ok-submit" type="submit" name="ok-submit" value="Upload &amp; vytvoriť thumbnail &raquo;" />
</div>
</form>
<?php
} else 
{
	$cesta = "/wpcontent/images/rozsirenia/";
	$ul = new bp_img_UploadObrazku("../../images/rozsirenia/", $id, true);
	if($ul->ok)
	{
		echo "<p>Nahral som: $ul->nazovSuboru</p>";
/*		echo "<p><img src=\"/wp-content/images/rozsirenia/{$ul->nazovSuboru}\" alt=\"$id\" /></p>";
		echo "<p><img src=\"/wp-content/images/rozsirenia/t/{$ul->nazovSuboru}\" alt=\"$id\" /></p>"; */
		echo "<div class=\"submit\"><input type=\"button\" onclick=\"window.opener.document.getElementById('obrazok').value='$id.png';window.close();\" value=\"OK - Doplniť a zavrieť\" /></div>";
	}
	else
	{
		echo "Nieco je zle: " . $ul->sprava;
	}
}
?>

</div>

</body>
</html>
