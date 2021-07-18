<?php

function bp_img_vyrobZmenseninu($aCesta, $aObrazok, $aNazov) 
{
	$ngi = imagecreatetruecolor(20, 10);
	$gi = "";

	$obrazok = $aObrazok;
	$cesta = $aCesta;

	$casti = explode (".", $obrazok);
	$pocet = count($casti);
	$koncovka = "";
	if($pocet > 1) $koncovka = $casti[$pocet-1];
	$rozmer = 300;

	switch($koncovka) 
	{
		case "jpg":
		case "JPG":
		case "jpeg":
		case "JPEG":
			$gi = imagecreatefromjpeg($cesta . $obrazok);
			break;
		case "png":
		case "PNG":
			$gi = imagecreatefrompng($cesta . $obrazok);
			break;
		case "gif":
		case "GIF":
			$gi = imagecreatefrompng($cesta . $obrazok);
			break;
	}
			
	if (!$gi) die ("CHYBA! Imagecreatefrom($cesta$obrazok)");

	$x = imagesx($gi);
	$y = imagesy($gi);
	if($x>$rozmer || $y>$rozmer)
	{
		if ($x >= $y) 
		{
			$nx = $rozmer;
			$koef = $x / $nx;
			$ny = $y / $koef;
		} 
		else 
		{
			$ny = $rozmer;
			$koef = $y / $ny;
			$nx = $x / $koef;
		}
	}
	else
	{
		$nx = $x;
		$ny = $y;
	}

	$ngi = imagecreatetruecolor($nx, $ny);
	if (!$ngi) die ("CHYBA! Imagecreatetruecolor.");

	if($ngi)
	{
		imagecopyresampled($ngi, $gi, 0, 0, 0, 0, $nx, $ny, $x, $y);
		$novy = $cesta . "t/" . $aNazov . ".png";
		imagetruecolortopalette($ngi, false, 256);
		$r = imagepng($ngi, $novy);
		if($r) chmod($novy, 0644);
		return $r;
	}
	else
	{
		return FALSE;
	} 
}

class bp_img_UploadObrazku 
{
	var $cesta;
	var $predpona;
	var $mini;
	var $pripona;
	var $sprava;
	var $ok;
	var $nazovSuboru;
	var $bolUpload;

	function bp_img_UploadObrazku($aKamUlozit, $aPredpona, $aVyrobitMini = TRUE) 
	{
		$this->cesta = $aKamUlozit;
		$this->predpona = $aPredpona;
		$this->mini = $aVyrobitMini;
		$this->ok = FALSE;
		$this->pripona = "";
		$this->sprava = "";

		if (is_uploaded_file($_FILES['subor']['tmp_name'])) 
		{
			switch(stristr($_FILES['subor']['type'], "/"))
			{
				case "/jpeg":
				case "/pjpeg":
					$this->sprava = "Uploadovany bol JPEG.";
					$this->pripona = ".jpg";
					$this->ok = TRUE;
					break;
				case "/gif":
					$this->sprava = "Uploadovany bol GIF.";
					$this->pripona = ".gif";
					$this->ok = TRUE;
					break;
				case "/png":
					$this->sprava = "Uploadovany bol PNG.";
					$this->pripona = ".png";
					$this->ok = TRUE;
					break;
				default:
					$this->sprava = "Chyba pri uploade! Typ=". $_FILES['subor']['type'] . " Chyba=" . $_FILES['subor']['error'];
					$this->ok = FALSE;
			}
			if($this->ok) 
			{
				$this->nazovSuboru = $this->predpona . $this->pripona;
				move_uploaded_file($_FILES['subor']['tmp_name'], $this->cesta . $this->nazovSuboru);
				chmod($this->cesta . $this->nazovSuboru, 0644);
				if($this->mini)
				{
					if(bp_img_vyrobZmenseninu($this->cesta, $this->nazovSuboru, $this->predpona))
					{
						$this->sprava .= " Zmensenina vyrobena.";
					}
					else
					{
						$this->ok = FALSE;
						$this->sprava .= " Chyba pri vyrabani zmenseniny.";
					}
				}
			}
			$this->bolUpload = TRUE;
		}
		else
		{
			$this->sprava = "Ziadny upload!";
			$this->bolUpload = FALSE;
		}
		return $this->ok;
	}

}
?>
