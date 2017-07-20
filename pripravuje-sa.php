<?php


echo '<div class="post-page"><h2>Zoznam pripravovaných rozšírení</h2><div class="entrytext">';

echo '<div>Na tejto stránke je dostupný zoznam rozšírení, na ktorých lokalizácii sa práve teraz pracuje. Je to užitočné pre súčasných aj potenciálnych lokalizátorov a jej cieľom je zabránenie tomu, aby jedno rozšírenie nezávisle prekladali viacerí lokalizátori.
</div><br/>'; 


$rozsirenia = $wpdb->get_results("SELECT nazov, publikovat FROM mozsk_rozsirenia
										WHERE publikovat=0 OR publikovat=2 GROUP BY nazov ORDER BY nazov ASC");

   
	if($rozsirenia)
	{
		echo '<table align="center" width="100%" class="tabulka">';
		echo '<thead><tr><th>Názov rozšírenia</th><th>Stav lokalizácie</th></tr></thead>';
		foreach ($rozsirenia as $rozsirenie) 
		{
		echo '<tr><td><strong>'.$rozsirenie->nazov.'</strong></td><td>';
		if ($rozsirenie->publikovat==0) echo "testuje sa"; else if ($rozsirenie->publikovat==2) echo "lokalizuje sa";
		echo '</td></tr>';

		}
		echo '</table>';
	}
	else
	{

		echo '<div class="error">Momentálne sa nepripravujú a nie sú lokalizované žiadne nové rozšírenia.</div>';
	}
?>
<br/>	
Chcete, aby bolo preložené nejaké iné rozšírenie? Napíšte nám jeho názov do <a href="/forum/viewtopic.php?t=28">príslušnej témy</a> v našom fóre...
<br/><br/>
Chcete vy sami lokalizovať nejaké rozšírenie? Píšte na <em>valastiak [zavináč] mozilla.sk</em>.
<br/><br/>
Pre lokalizátorov sme pripravili niekoľko zásad, ktoré je nutné pri prekladaní dodržiavať. Nájdete ich na stránke <a href="/rozsirenia/ako-spravne-lokalizovat/">Ako správne lokalizovať</a>.

</div></div>