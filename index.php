<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sl" lang="sl" dir="ltr"> 
<head> 
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
</head>
<?php 

function cena($string) {
	// pogledamo za skupno ceno
    $skupnaCena = preg_match_all ('/(?:skup|oba|oboje|vse|komplet)[a-z\s\-\,:=~>]+\s+([\d\,\.]+)\s*(?:€|EUR|evr|&#8364;|e[\,\.\s]|eu)/i',$string, $vsecene);
	if ($skupnaCena) {
		//echo "Nasel skupno ceno!<br>";
		//print_r($vsecene);
    	$okvirnacena = (max(array_map('floatval',$vsecene[1])));	
    } else {
 		//echo "Failover<br>";
 		$ncen = preg_match_all ('/[\s=:>\(]+([\d\.\,]+)[\-\s]*(?:€|EUR|evr|e[\,\.\s]|&#8364;|eu)(\)){0,1}/i',$string, $vsecene);
		//print_r($vsecene);
 		if($ncen) {
 			preg_match_all ('/(?:trgovi)[a-z\s\-\,:=~>]+\s+([\d\.\,]+)[\-\s]*(?:€|EUR|evr|e[\,\.\s]|&#8364;|eu)(\)){0,1}/i',$string, $trgovinacene);
			$okvirnacena = array_sum(array_map('floatval',$vsecene[1])) - array_sum(array_map('floatval',$trgovinacene[1]));
		} else {
			
			$ncen = preg_match_all ('/(?:)[\s=:>\(]+([\d\.\,]+)[\-\s]*(?:€|EUR|evr|e[\,\.\s]|&#8364;|eu)(\)){0,1}/i',$string, $vsecene);
			
   			$okvirnacena = -1.0;	
   		}	
   	}
   	return $okvirnacena;
}

if(isset($_POST["besedilo"])) {
	//$ncen = preg_match_all ('/([\d\.\,]+[\-]*\s*(€|EUR|evr|e\s|&#8364;|e\.|e\,|eu))/i',$_POST["besedilo"], $vsecene);
	
	$okvirnacena = cena($_POST["besedilo"]);
		
	echo "<pre>" . $_POST["besedilo"] . "</pre>";
	echo "<br> Okvirna cena je: " . $okvirnacena;
} else if($_SERVER["SCRIPT_NAME"] == "/st/index.php") {
	?>
	<form method="post">
		<textarea name="besedilo" cols="80" rows="30"></textarea>
		<br>
		<input type="submit"/>
	</form>
	<?php 
}

?>
