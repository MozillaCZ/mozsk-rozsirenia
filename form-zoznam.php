<form method="post" action="">
<h2>Zoznam rozšírení</h2>
	<div style="overflow:auto;height:450px;border:solid 1px #ccc;margin-bottom:10px">
	<table id="the-list-x" width="100%" cellpadding="3" cellspacing="3">
	<thead>
		<tr>
			<th scope="col">ID</th>
			<th scope="col">Názov</th>
			<th scope="col">Najnovšia verzia</th>
			<th scope="col">Dátum</th>
			<th scope="col">Lokalizuje</th>
			<th scope="col" colspan="5">-</th>
		</tr>
	</thead>
	<tbody>
<?php
$folder = '/rozsirenia/';
	$r = 0;
	$rozsirenia = $wpdb->get_results("SELECT nazov, MAX(id) as ID FROM mozsk_rozsirenia GROUP BY nazov ORDER BY nazov ASC");
	if($rozsirenia)
	{
		foreach ($rozsirenia as $rozsirenie) 
		{
			$pom_roz = $wpdb->get_row("SELECT mozsk_rozsirenia.id, publikovat, verzia, starsie, datum, nazov, localizator,urlid  FROM mozsk_rozsirenia, mozsk_roz_localizator WHERE mozsk_rozsirenia.id={$rozsirenie->ID} AND mozsk_rozsirenia.autor=mozsk_roz_localizator.id");
			if($pom_roz->publikovat==1) $styl_nepub = "";
			else if($pom_roz->publikovat==2) $styl_nepub = ' style="color: blue"';
			else if($pom_roz->publikovat==3) $styl_nepub = ' style="color: grey"';
			else $styl_nepub = ' style="color: red"';
			
			if($r % 2) echo '<tr>';
			else echo '<tr class="alternate">';
			
			$ver = $pom_roz->verzia;
			if($pom_roz->starsie == "")
			{
				$tit_ver = "";
			}
			else
			{
				$tit_ver = " title=\"Staršie verzie: ID={$pom_roz->starsie}\"";
			}
			$df = get_settings('date_format');
			$datum = mysql2date($df, $pom_roz->datum);

			echo "<th scope=\"row\"$styl_nepub>{$pom_roz->id}</th>";
			echo "<td$styl_nepub>{$pom_roz->nazov}</td>";
			echo "<td style=\"text-align:center\"$tit_ver>$ver</td>";
			echo "<td style=\"text-align:center\">$datum</td>";
			echo '<td>' . $pom_roz->localizator . '</td>';
			echo '<td><a href="'.$folder . $pom_roz->urlid . '/';if ($pom_roz->publikovat ==0) echo 'test/'; echo'" class="edit">Zobraziť</a></td>';
			echo '<td><a href="#" class="edit" onclick="msk_Edit('.$pom_roz->id.')">Upraviť</a></td>';
			echo '<td><a href="#" class="edit" onclick="msk_NuVer('.$pom_roz->id.')">+Verzia</a></td>';
			if ($tit_ver != "") echo '<td '.$tit_ver.'><a href="#" class="edit" onclick="msk_StVer('.$pom_roz->id.')">Staršie</a>'; else echo '<td style="text-align: center"><span style="color: #999">Staršie</span>';
			echo '</td>';
			echo '<td><a href="#" class="delete" onclick="msk_AskDel('.$pom_roz->id.')">Zmazať</a></td>';
			echo '</tr>';
			$r++;
		}
	}
	else
	{
		echo '<tr><td colspan="6">V databáze nie sú žiadne rozšírenia.</td></tr>';
	}
?>
	</tbody>
	</table>
	</div>
	<div class="submit">
		<input id="prekop-obrazky" type="button" value="Prekopať obrázky &raquo;" onclick="msk_DigPix()" />
		<input id="ok-submit" type="submit" name="ok-submit" value="Pridať rozšírenie &raquo;" />
	</div>
	<input id="todo" name="todo" type="hidden" value="pridat"/>
	<input id="param1" name="param1" type="hidden" value=""/>
</form>
