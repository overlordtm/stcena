<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sl" lang="sl" dir="ltr"> 
<head> 
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" /> 
</head>
<?php 

if(isset($_POST["besedilo"])) {
	//$ncen = preg_match_all ('/([\d\.\,]+[\-]*\s*(€|EUR|evr|e\s|&#8364;|e\.|e\,|eu))/i',$_POST["besedilo"], $vsecene);

	// pogledamo za skupno ceno
    $skupnaCena = preg_match_all ('/(?:skup|oba|oboje|vse|komplet)[a-z\s\-\,:=~>]+\s+([\d\,\.]+)\s*(?:€|EUR|evr|&#8364;|e[\,\.\s]|eu)/i',$_POST["besedilo"], $vsecene);
	if ($skupnaCena) {
		echo "Nasel skupno ceno!<br>";
		print_r($vsecene);
    	$okvirnacena = (max(array_map('floatval',$vsecene[1])));	
    } else {
 		echo "Failover<br>";
 		$ncen = preg_match_all ('/[\s=:>\(]+([\d\.\,]+)[\-\s]*(?:€|EUR|evr|e[\,\.\s]|&#8364;|eu)(\)){0,1}/i',$_POST["besedilo"], $vsecene);
		print_r($vsecene);
 		if($ncen) {
 			preg_match_all ('/(?:trgovi)[a-z\s\-\,:=~>]+\s+([\d\.\,]+)[\-\s]*(?:€|EUR|evr|e[\,\.\s]|&#8364;|eu)(\)){0,1}/i',$_POST["besedilo"], $trgovinacene);
			$okvirnacena = array_sum(array_map('floatval',$vsecene[1])) - array_sum(array_map('floatval',$trgovinacene[1]));
		} else {
   			$okvirnacena = -1.0;	
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
