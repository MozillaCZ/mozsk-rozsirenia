<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Lokalizátori</title>
<link rel="stylesheet" href="http://www.mozilla.sk/wp-admin/wp-admin.css?version=2.0" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


</head>

<body>

<script type="text/javascript">
function setLok() {
    var newElem;
    var where = (navigator.appName == "Microsoft Internet Explorer") ? -1 : null;
    var lokChooser = window.opener.document.getElementById('lokalizuje');
    while (lokChooser.options.length) {
        lokChooser.remove(0);
    }

//     if (choice != "") {
//         for (var i = 0; i < db.length; i++) {
//             newElem = document.createElement("option");
//             newElem.text = db[i].text;
//             newElem.value = db[i].value;
//             cityChooser.add(newElem, where);
//         }
//     }
     $query = $wpdb->query("SELECT id,localizator FROM mozsk_roz_localizator ORDER BY localizator");
     $rs=mysql_query($query);
	   if(!$rs)
	    {
	     echo "Error while exeuting the query";
	    }
	   else
	    {
	     while($row=mysql_fetch_array($rs))
		      {
		      $id=$row['id'];
		      $lok=$row['localizator'];
		      echo "<option value=\"$id\">$lok</option>";
		      }
	    }

}

function AskDel(id)
{
	answer = window.confirm("Naozaj odstrániť tohto lokalizátora? Pozor, po stlačení OK ihneď maže!");
	if(answer)
	{
		document.getElementById("id_lok").value = id;
		document.getElementById("param").value = "del";
		document.getElementById("first_run").value = 0;
		document.getElementById("ok-submit").click();
	}
}

function AskEdit(id)
{
		document.getElementById("id_lok").value = id;
		document.getElementById("param").value = "edit";
		document.getElementById("ok-submit").click();
	}

</script>

<div class="wrap">

<?php
require_once('/home/epicnet/mozilla.sk/wp-config.php');
//-global $wpdb;
$lokalizuje_new = $_POST["lokalizuje_new"];
$lok_url = $_POST["lok_url"];
$lok_hmp = $_POST["lok_hmp"];
if (isset($_POST['lok_profil'])) 
	$lok_profil=1;  
 else $lok_profil=0;
if (isset($HTTP_POST_VARS['first_run'])) 
	$first_run=$HTTP_POST_VARS['first_run'];  
 else $first_run=0;

if (isset($HTTP_POST_VARS['id_lok'])) 
	$id_lok=$HTTP_POST_VARS['id_lok'];  
 else $id_lok=0;

if (isset($HTTP_POST_VARS['param'])) 
	$param=$HTTP_POST_VARS['param'];  
 else $param="list";
 
$lok_email = $_POST["lok_email"];

if ($first_run==0) {

  if (($id_lok!=0) && $param=="del") { $wpdb->query("DELETE FROM mozsk_roz_localizator WHERE id = '$id_lok'"); $id_lok = 0; $param="list";}

?>

<form method="post" action="">

<h2>Lokalizátori</h2>

<div style="overflow:auto;height:390px;width:100%;border:solid 1px #ccc;margin-bottom:10px">
<table id="the-list-lok" width="100%" cellpadding="3" cellspacing="3">
	<thead>
		<tr>
			<th scope="col">ID</th>
			<th scope="col">Meno</th>
			<th scope="col">Úderník</th>
			<th scope="col">hmp</th>
			<th scope="col">Profil</th>
			<th scope="col">E-mail</th>
			<th scope="col" colspan="2">-</th>
		</tr>
	</thead>
	<tbody>
	<?php $r = 0;
	     $lokalizator = $wpdb->get_results('SELECT id,localizator, lok_url, profil, lok_hmp, email FROM mozsk_roz_localizator ORDER BY localizator');
				if($lokalizator)
    	   {
            foreach ($lokalizator as $lok) 
				    {
					     if($r % 2) echo '<tr>'; else echo '<tr class="alternate">';
					     	echo "<th scope=\"row\">{$lok->id}</th>";
                echo "<td>{$lok->localizator}</td>";
                echo "<td>{$lok->lok_url}</td><td style=\"text-align:center\">";
			          if ($lok->lok_hmp) echo ' <a href="'.$lok->lok_hmp.'" title="Domovská stránka"><img src="/wp-content/images/logo/rozsirenia_lok/domov.png" alt="Domovská stránka" /></a>'; else echo "-";
			          echo "</td><td style=\"text-align:center\">"; if ($lok->profil==1) echo "áno</td>"; else echo "nie</td>";
			          echo "<td>{$lok->email}</td>";
	              echo '<td><a href="#" class="edit" onclick="AskEdit('.$lok->id.')">Edit</a></td>';			
			          echo '<td><a href="#" class="delete" onclick="AskDel('.$lok->id.')">Del</a></td>';
			          echo '</tr>';
  		          $r++;
				    }
				 }
      else echo '<tr><td colspan="6">V databáze nie sú žiadni lokalizátori.</td></tr>';
  ?>
	</tbody>
	</table>
	</div>

	<div class="submit">
	<input id="ok-submit" type="submit" name="ok-submit" value="Pridať lokalizátora &raquo;" />
	<input id="close" type="button" value="OK - zavrieť &raquo;" onclick="setLok();window.close();" />
 	<input id="first_run" type="hidden" value="1" name="first_run" />
 	<input id="id_lok" name="id_lok" type="hidden" value="0"/>
	<input id="param" name="param" type="hidden" value="list"/>

  </div>
  </form>
<?php
}
else if(!$lokalizuje_new)
{
  echo '<form method="post" action="">';
  if ($param=="edit") {
          echo '<h2>Úprava lokalizátora</h2>';
    	    $lokalizator = $wpdb->get_row("SELECT * FROM mozsk_roz_localizator WHERE id = $id_lok LIMIT 1");
          $lokalizuje_new = $lokalizator->localizator;
          $lok_url = $lokalizator->lok_url;
          $lok_hmp = $lokalizator->lok_hmp;
          $lok_profil = $lokalizator->profil;
          $lok_email = $lokalizator->email;
 
  } else
  {
  echo '<h2>Nový lokalizátor</h2>';
          $lokalizuje_new = "";
          $lok_url = "";
          $lok_hmp = "";
          $lok_profil = 0;
          $lok_email = "";
  }
?>
      <table cellpadding="2" cellspacing="2" border="0" style="text-align: left; width: 80%;">
        <tbody>
          
          <tr>
    			<td><label for="lokalizuje_new">Meno:&nbsp;&nbsp;</label></td><td><input id="lokalizuje_new" name="lokalizuje_new" type="text" size="20" value="<?php echo $lokalizuje_new ?>" /></td>
	        </tr>
	        
          <tr>
            <td><label for="lok_url">Úderník:&nbsp;&nbsp;</label></td><td><input id="lok_url" name="lok_url" type="text" size="20" value="<?php echo $lok_url ?>" /></td>
	        </tr>
	
          <tr>
            <td><label for="lok_hmp">Homepage:&nbsp;&nbsp;</label></td><td><input id="lok_hmp" name="lok_hmp" type="text" size="20" value="<?php echo $lok_hmp ?>" /></td>
	        </tr>
	         
          <tr>
            <td><label for="lok_profil">Profil:&nbsp;&nbsp;</label></td><td><input id="lok_profil" name="lok_profil" type="checkbox" value="<?php echo $lok_profil.'"'; if ($lok_profil=1) echo 'checked="checked" '?>"/></td>
	        </tr>
	
          <tr>
            <td><label for="lok_email">E-mail:&nbsp;&nbsp;</label></td><td><input id="lok_email" name="lok_email" type="text" size="20" value="<?php echo $lok_email ?>" /></td>
	        </tr>
        </tbody>
      </table>	
      
      <div class="submit">
    	<input id="first_run" type="hidden" value="1" name="first_run" />
	     <?php if ($param=="edit") echo '<input id="ok-submit" type="submit" name="ok-submit" value="Upraviť &raquo;" /><input id="param" name="param" type="hidden" value="edit"/><input id="id_lok" name="id_lok" type="hidden" value="'.$id_lok.'"/>';
        else echo '<input id="ok-submit" type="submit" name="ok-submit" value="Pridať do databázy &raquo;" />'; ?>
      </div>
</form>

<?php
} else 
{
if ($param=="edit") {
  if (!$wpdb->query("UPDATE mozsk_roz_localizator SET localizator = '$lokalizuje_new', lok_url = '$lok_url', profil = '$lok_profil', lok_hmp = '$lok_hmp', email = '$lok_email' WHERE id = $id_lok")) echo "Problem s databazou";

	}
  else 

  if (!$wpdb->query("INSERT INTO mozsk_roz_localizator
	(
		localizator, lok_url, profil, lok_hmp, email
	) VALUES (
	'$lokalizuje_new', '$lok_url', '$lok_profil', '$lok_hmp', '$lok_email')")) echo "Problem s databazou";
  
  ?>

  <form method="post" action="">
 
  <?php if ($param=="edit") echo '<h2>Úprava lokalizátora úspešne vykonaná</h2>'; else echo '<h2>Nový lokalizátor úspešne pridaný</h2>'; ?>
  		<table cellpadding="2" cellspacing="2" border="0" style="text-align: left; width: 80%;">
				<tbody>
					<tr>
						<td>Meno:</td><td><strong><?php echo $lokalizuje_new ?></strong></td>
					</tr>
					<tr>
						<td>Úderník:</td><td><strong><?php echo $lok_url ?></strong></td>
					</tr>
					<tr>
						<td>Homepage:</td><td><strong><?php echo $lok_hmp ?></strong></td>
					</tr>
					<tr>
						<td>Profil:</td><td><strong><?php echo ($lok_profil == 1) ? 'áno' : 'nie' ?></strong></td>
					</tr>
					<tr>
						<td>E-mail:</td><td><strong><?php echo $lok_email ?></strong></td>
					</tr>
				</tbody>
			</table>	
	<?php
		echo '<div class="submit">
    <input type="hidden" value="0" name="first_run" id="first_run" />
    <input type="hidden" value="list" name="param" id="param" />
    <input type="hidden" value="0" name="id_lok" id="id_lok" />
    <input id="ok-submit" name="ok-submit" type="submit" value="Návrat na zoznam" />
    <input id="close" type="button" onclick="window.close();" value="OK - zavrieť" />
    </div>
    </form>';
	}

?>

</div>

</body>
</html>
