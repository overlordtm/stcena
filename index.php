<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sl" lang="sl" dir="ltr"> 
<head> 
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" /> 
</head>

<?php 

if(isset($_POST["besedilo"])) {
	//$ncen = preg_match_all ('/([\d\.\,]+[\-]*\s*(€|EUR|evr|e\s|&#8364;|e\.|e\,|eu))/i',$_POST["besedilo"], $vsecene);

	// pogledamo za skupno ceno
    $skupnaCena = preg_match_all ('/(?:sku|oba|oboje|vse)[a-z\s:=\,~]+\s*([\d\,\.]+)\s*(?:€|EUR|evr|&#8364;|e[\,\.\s]|eu)/i',$_POST["besedilo"], $vsecene);
	if ($skupnaCena) {
		echo "Nasel skupno ceno!<br>";
		print_r($vsecene);
    	$okvirnacena = (max(array_map('floatval',$vsecene[1])));	
    } else {
    	echo "Iscem take z prefixom ce<br>";
    	// pogledamo za cene ki imajo prefix "ce". Zato da se izognemo raznim oznakam izdelkov ala WRT1000E
    	$ncen = preg_match_all ('/(?:ce)[a-z\s:=~]+\s*([\d\,\.]+)\s*(?:€|EUR|evr|&#8364;|e[\,\.\s]|eu)/i',$_POST["besedilo"], $vsecene);
    	if($ncen) {
    		echo "Nasel take z prefixom ce<br>";
    		print_r($vsecene);
    		$okvirnacena = (max(array_map('floatval',$vsecene[1])));	
    	} else {
    		echo "Obupano iskanje vsega kar zgleda kot cena<br>";
    		$ncen = preg_match_all ('/([\d\,\.]+)\s*(?:€|EUR|evr|&#8364;|e[\,\.\s]|eu)/i',$_POST["besedilo"], $vsecene);
    		if($ncen) {
    			print_r($vsecene);
    			$okvirnacena = (max(array_map('floatval',$vsecene[1])));	
    		} else {
    			$okvirnacena = -1.0;	
    		}
    	}
    }
	echo "<pre>" . $_POST["besedilo"] . "</pre>";
	echo "<br> Okvirna cena je: " . $okvirnacena;
} else {
	?>
	<form method="post">
		<textarea name="besedilo" cols="80" rows="30"></textarea>
		<br>
		<input type="submit"/>
	</form>
	<?php 
}

?>
