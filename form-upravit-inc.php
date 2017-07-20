<table cellpadding="2" cellspacing="2" border="0" style="text-align: left; width: 80%;">
<tbody>
	<tr>
		<td style="width:15%"><label for="nazov">Názov</label></td>
		<td><input type="text" id="nazov" name="nazov" size="50" value="<?php echo $nazov; ?>" /> </td>
	</tr>
	<tr>
		<td><label for="urlid">Úderník</label></td>
		<td><input type="text" id="urlid" name="urlid" size="50" value="<?php echo $urlid; ?>" />  (iba písmená, čísla, mínus)</td>
	</tr>
	<tr>
		<td><label for="popis">Popis</label></td>
		<td><textarea id="popis" name="popis" cols="80" rows="6"><?php echo $popis; ?></textarea></td>
	</tr>
	<tr>
		<td><label for="obrazok">Obrázok</label></td>
		<td><input id="obrazok" name="obrazok" type="text" size="50" value="<?php echo $obrazok; ?>" />
		<input id="obrazok-upload" type="button" class="button" onclick="msk_ImgWin();" value="Upload"/>
		</td>
	</tr>
	<tr>
		<td><label for="kategoria">Kategória</label></td>
		<td>
			<select class="filter" size="1" name="kategoria" id="kategoria">
			<?php
			  $category = $wpdb->get_results('SELECT kategoria,id FROM mozsk_roz_meta ORDER BY kategoria');
              foreach ($category as $kat)
				{
				echo '<option ';
				if ($kat->id==$kategoria) echo 'selected="selected" ';
				echo 'value='.$kat->id.'>'.$kat->kategoria.'</option>';
				}
			?>
            </select>
        </td>
	</tr>
	<tr>
		<td>Stav</td>
		<td>
		<input type="radio" id="publikovat2" name="publikovat" value="1" <?php if($publikovat==1) echo ('checked="checked" '); ?> />&nbsp;<label for="publikovat2">Vydané</label>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" id="publikovat1" name="publikovat" value="0" <?php if($publikovat==0) echo ('checked="checked" '); ?> />&nbsp;<label for="publikovat1">Nevydané</label>&nbsp;&nbsp;
		<input type="radio" id="publikovat3" name="publikovat" value="2" <?php if($publikovat==2) echo ('checked="checked" '); ?> />&nbsp;<label for="publikovat3">Zapísané</label>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" id="publikovat4" name="publikovat" value="3" <?php if($publikovat==3) echo ('checked="checked" '); ?> />&nbsp;<label for="publikovat4">Sandbox</label>&nbsp;&nbsp;&nbsp;&nbsp;
		<input id="podporovane" name="podporovane" type="checkbox" <?php if($podporovane) echo ('checked="checked" '); ?>/> <label for="podporovane">SK locale podporované autorom</label>
		</td>
	</tr>
	<tr>
		<td colspan="2"><h3>Informácie o lokalizácii</h3></td>
	</tr>
	<tr>
		<td><label for="lokalizuje">Lokalizuje</label></td>
		<td>
			<select class="filter" size="1" name="lokalizuje" id="lokalizuje">
			<?php
			  $lokalizator = $wpdb->get_results('SELECT id,localizator FROM mozsk_roz_localizator ORDER BY localizator');
				foreach ($lokalizator as $lok) 
				{
					echo '<option ';
					if ($lok->id==$lokalizuje) echo 'selected="selected" ';
					echo 'value="'.$lok->id.'">'.$lok->localizator.'</option>';
				}


			?>
            </select>
            <input id="lokalizuje_new" type="button" class="button" onclick="msk_locWin();" value="Správa lokalizátorov"/>
<?php /*            <br/>
            <fieldset style="border: 1px black solid">
			<legend>Nový lokalizator</legend>
			<label for="lokalizuje_new">Meno:&nbsp;&nbsp;</label><input id="lokalizuje_new" name="lokalizuje_new" type="text" size="10" value="" />
            &nbsp;<label for="lok_url">Úderník:&nbsp;&nbsp;</label><input id="lok_url" name="lok_url" type="text" size="10" value="" />
            &nbsp;<label for="lok_hmp">Homepage:&nbsp;&nbsp;</label><input id="lok_hmp" name="lok_hmp" type="text" size="20" value="" />
            &nbsp;<label for="lok_profil">Profil:&nbsp;&nbsp;</label><input id="lok_profil" name="lok_profil" type="checkbox" />
            </fieldset>
       */ ?>    </td>
	</tr>
	<tr>
		<td><label for="datum">Dátum</label></td>
		<td><input id="datum" name="datum" type="text" value="<?php echo $datum; ?>" size="10"/> (formát RRRR-MM-DD)</td>
	</tr>
	<tr>
		<td><label for="cas">Čas</label></td>
		<td><input id="cas" name="cas" type="text" value="<?php echo $cas; ?>" size="10"/> (formát HH:MM:SS)</td>
	</tr>
	<tr>
		<td><label for="verzia">Verzia</label></td>
		<td><input id="verzia" name="verzia" type="text" size="20" value="<?php echo $verzia; ?>" /></td>
	</tr>
	<tr>
		<td><label for="verzia">Aktuálnosť verzie</label></td>
		<td><input type="radio" id="neaktualne1" name="neaktualne" value="0" <?php if($neaktualne==0) echo ('checked="checked" '); ?> />&nbsp;<label for="neaktualne1">Aktuálne</label>&nbsp;&nbsp;
		<input type="radio" id="neaktualne2" name="neaktualne" value="1" <?php if($neaktualne==1) echo ('checked="checked" '); ?> />&nbsp;<label for="neaktualne2">Neaktuálne</label>&nbsp;&nbsp;
		<input type="radio" id="neaktualne3" name="neaktualne" value="2" <?php if($neaktualne==2) echo ('checked="checked" '); ?> />&nbsp;<label for="neaktualne3">Už nepodporované</label>&nbsp;&nbsp;
		<input type="radio" id="neaktualne4" name="neaktualne" value="3" <?php if($neaktualne==3) echo ('checked="checked" '); ?> />&nbsp;<label for="neaktualne4">Ďalej nevyvíjané</label>&nbsp;&nbsp;
	</tr>
	<tr>
		<td colspan="2"><h3>Určené pre:</h3></td>
	</tr>
	<tr>
		<td><label for="urcene_ff_od"><img src="/wp-content/images/logo/ff_small.png" alt="Firefox" /> Firefox</label></td>
		<td><input id="urcene_ff_od" name="urcene_ff_od" type="text" size="7" value="<?php echo $urcene_ff_od; ?>" />&nbsp; až &nbsp;<input id="urcene_ff_do" name="urcene_ff_do" type="text" size="7" value="<?php echo $urcene_ff_do; ?>" /> </td>
	</tr>
	<tr>
		<td><label for="urcene_tb_od"><img src="/wp-content/images/logo/tb_small.png" alt="Thunderbird" /> Thundebird</label></td>
		<td><input id="urcene_tb_od" name="urcene_tb_od" type="text" size="7"  value="<?php echo $urcene_tb_od; ?>" />&nbsp; až &nbsp;<input name="urcene_tb_do" type="text" size="7" value="<?php echo $urcene_tb_do; ?>" /></td>
	</tr>
	<tr>
		<td><label for="urcene_ms_od"><img src="/wp-content/images/logo/ms_small.png" alt="Mozilla Suite" /> Mozilla Suite</label></td>
		<td><input id="urcene_ms_od" name="urcene_ms_od" type="text" size="7" value="<?php echo $urcene_ms_od; ?>" />&nbsp; až &nbsp;<input name="urcene_ms_do" type="text" size="7" value="<?php echo $urcene_ms_do; ?>" /></td>
	</tr>
	<tr>
		<td><label for="urcene_sm_od"><img src="/wp-content/images/logo/seamonkey16.png" alt="SeaMonkey" /> SeaMonkey</label></td>
		<td><input id="urcene_sm_od" name="urcene_sm_od" type="text" size="7" value="<?php echo $urcene_sm_od; ?>" />&nbsp; až &nbsp;<input name="urcene_sm_do" type="text" size="7" value="<?php echo $urcene_sm_do; ?>" /></td>
	</tr>
	<tr>
		<td><label for="urcene_ns_od"><img src="/wp-content/images/logo/ns_small.png" alt="Netscape" /> Netscape</label></td>
		<td><input id="urcene_ns_od" name="urcene_ns_od" type="text" size="7" value="<?php echo $urcene_ns_od; ?>" />&nbsp; až &nbsp;<input name="urcene_ns_do" type="text" size="7" value="<?php echo $urcene_ns_do; ?>" /></td>
	</tr>
	<tr>
		<td><label for="urcene_sb_od"><img src="/wp-content/images/logo/sn_small.png" alt="Sunbird" /> Sunbird</label></td>
		<td><input id="urcene_sb_od" name="urcene_sb_od" type="text" size="7" value="<?php echo $urcene_sb_od; ?>" />&nbsp; až &nbsp;<input name="urcene_sb_do" type="text" size="7" value="<?php echo $urcene_sb_do ?>" /></td>
	</tr>
	<tr>
		<td><label for="urcene_nv_od"><img src="/wp-content/images/logo/nvu_small.png" alt="NVU" /> NVU</label></td>
		<td><input id="urcene_nv_od" name="urcene_nv_od" type="text" size="7" value="<?php echo $urcene_nv_od; ?>" />&nbsp; až &nbsp;<input name="urcene_nv_do" type="text" size="7" value="<?php echo $urcene_nv_do; ?>" /></td>
	</tr>
	<tr>
		<td><label for="urcene_fl_od"><img src="/wp-content/images/logo/fl_small.png" alt="Flock" /> Flock</label></td>
		<td><input id="urcene_fl_od" name="urcene_fl_od" type="text" size="7" value="<?php echo $urcene_fl_od; ?>" />&nbsp; až &nbsp;<input name="urcene_fl_do" type="text" size="7" value="<?php echo $urcene_fl_do; ?>" /></td>
	</tr>
	<tr>
		<td><label for="urcene_sng_od"><img src="/wp-content/images/logo/sng_small.png" alt="Songbird" /> Songbird</label></td>
		<td><input id="urcene_sng_od" name="urcene_sng_od" type="text" size="7" value="<?php echo $urcene_sng_od; ?>" />&nbsp; až &nbsp;<input name="urcene_sng_do" type="text" size="7" value="<?php echo $urcene_sng_do; ?>" /></td>
	</tr>
	<tr>
		<td colspan="2"><h3>Download</h3></td>
	</tr>
	<tr>
		<td><label for="url">URL</label></td>
		<td>/wp-content/download/rozsirenia/<input id="url" name="url" type="text" size="50" value="<?php echo $url; ?>" /> <input id="overit" type="button" class="button" onclick="msk_overWin();" value="Overiť"/></td>
	</tr>
	<tr>
		<td><label for="poznamka">Poznámka</label></td>
		<td><textarea id="poznamka" name="poznamka" cols="80" rows="4"><?php echo $poznamka; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><h3>Súvisiace odkazy</h3></td>
	</tr>
	<tr>
		<td><label for="forum">Fórum</label></td>
		<td>http://forum.mozilla.sk/viewforum.php?f=<input name="forum" type="text" id="forum" size="2" value="<?php echo $forum; ?>" /></td>
	</tr>
	<tr>
		<td><label for="nahlasit">Nahlásiť chybu</label></td>
		<td>http://forum.mozilla.sk/viewtopic.php?t=<input name="nahlasit" type="text" id="nahlasit" size="4" value="<?php echo $nahlasit; ?>" /></td>
	</tr>
	<tr>
		<td><label for="homepage">Homepage</label></td>
		<td><input name="homepage" type="text" id="homepage" size="82" value="<?php echo $homepage; ?>" /></td>
	</tr>
	<tr>
		<td><label for="czilla">CZilla</label></td>
		<td>http://www.czilla.cz/doplnky/rozsireni/<input name="czilla" type="text" id="czilla" size="46" value="<?php echo $czilla; ?>" /></td>
	</tr>
	<tr>
		<td><label for="addon">Mozilla Add-ons</label></td>
		<td>https://addons.mozilla.org/extensions/moreinfo.php?id=<input name="addon" type="text" id="addon" size="3" value="<?php echo $addon; ?>" /></td>
	</tr>
	<tr>
		<td colspan="2"><h3>Staršie verzie</h3></td>
	</tr>
	<tr>
		<td><label for="starsie">ID starších verzií</label></td>
		<td><input name="starsie" type="text" id="starsie" size="50" value="<?php echo $starsie; ?>" /> (oddeliť čiarkou)</td>
	</tr>
	<tr>
		<td colspan="2"><h3>Ostatné</h3></td>
	</tr>
	<tr>
		<td><label for="interna_pozn">Interná poznámka</label></td>
		<td><textarea id="interna_pozn" name="interna_pozn" cols="80" rows="4"><?php echo $interna_pozn; ?></textarea><br/>
		<input id="babel" name="babel" type="checkbox" <?php if (strpos($interna_pozn, 'babel') != false) echo ('checked="checked" '); ?> onclick="if (document.getElementById('babel').checked==1) { document.getElementById('interna_pozn').value='locale na babel' } else {document.getElementById('interna_pozn').value=''}" /> <label for="babel">locale na babel</label>
		</td>
	</tr>
</tbody>
</table>
