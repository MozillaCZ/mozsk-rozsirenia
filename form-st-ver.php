<form method="post" action="">
<?php
if (isset($_POST['param1']))
{
$zobraz_id = $_POST['param1'];

$hlavne_roz = $wpdb->get_row("SELECT nazov, starsie FROM mozsk_rozsirenia WHERE id=$zobraz_id");

echo '<h2>Zoznam verzií rozšírenia '.$hlavne_roz->nazov.'</h2>';
?>
	<div style="overflow:auto;height:450px;border:solid 1px #ccc;margin-bottom:10px">
	<table id="the-list-x" width="100%" cellpadding="3" cellspacing="3">
	<thead>
		<tr>
			<th scope="col">ID</th>
			<th scope="col">Názov</th>
			<th scope="col">Verzia</th>
			<th scope="col">Lokalizuje</th>
		</tr>
	</thead>
	<tbody>
	
<?php
$folder = '/rozsirenia/';
	$r = 0;
	$rozsirenia = $wpdb->get_results("SELECT mozsk_rozsirenia.id, publikovat, verzia, starsie, nazov, localizator,urlid FROM mozsk_rozsirenia, mozsk_roz_localizator WHERE mozsk_rozsirenia.autor=mozsk_roz_localizator.id AND (mozsk_rozsirenia.id=$zobraz_id OR mozsk_rozsirenia.id IN ($hlavne_roz->starsie)) ORDER BY nazov ASC, mozsk_rozsirenia.ID DESC");
	if($rozsirenia)
	{
		foreach ($rozsirenia as $rozsirenie) 
		{
			if($rozsirenie->publikovat) $styl_nepub = "";
			else $styl_nepub = ' style="color: red"';
			
			if($r % 2) echo '<tr>';
			else echo '<tr class="alternate">';
			
			$ver = $rozsirenie->verzia;
			
			echo "<th scope=\"row\"$styl_nepub>{$rozsirenie->id}</th>";
			echo "<td$styl_nepub>{$rozsirenie->nazov}</td>";
			echo "<td style=\"text-align:center\"$tit_ver>$ver</td>";
			echo '<td>' . $rozsirenie->localizator . '</td>';
			echo '<td><a href="'.$folder . $rozsirenie->urlid . '/" class="edit">Zobraziť</a></td>';
			echo '<td><a href="#" class="edit" onclick="msk_Edit('.$rozsirenie->id.')">Upraviť</a></td>';
			echo '<td><a href="#" class="edit" onclick="msk_NuVer('.$rozsirenie->id.')">+Verzia</a></td>';
			echo '<td><a href="#" class="delete" onclick="msk_AskDel('.$rozsirenie->id.')">Zmazať</a></td>';
			echo '</tr>';
			$r++;
		}
	}
	else
	{
		echo '<tr><td colspan="6">V databáze nie sú žiadne rozšírenia.</td></tr>';
	}
}
else echo "Chyba";
?>
	</tbody>
	</table>
	</div>
	<div class="submit">
		<input id="ok-submit" type="submit" name="ok-submit" value="Zoznam rozšírení &raquo;" />
	</div>
	<input id="todo" name="todo" type="hidden" value="zoznam-st-ok"/>
	<input id="param1" name="param1" type="hidden" value=""/>
</form>