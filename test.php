<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sl" lang="sl" dir="ltr"> 
<head> 
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
</head>

<pre>
<?php 

include 'index.php';

$lines = file('d1f5630a0144ee4cb8f9241795b2acbf');

$counter = 0;
$n = 0;

// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
	
	$ok = preg_match_all ('/(P:|prodam)/i',$line, $vsecene);
	
	if($ok) {
		$line2 = str_replace(array("\r\n", "\n", "\r"), " ", $line);
	    echo "Line #<b>{$line_num}</b> : " . $line2 . "<br />\n";
	    $okvirnacena = cena($line2);
	    echo "Okvirna cena: " . $okvirnacena . "<br>\n";
	    
	    $n++;
	    if($okvirnacena > 0) {
	    	$counter++;
	    }
	}
}

?>
</pre>
<?php 

echo "uspesno ocenjenih $counter oglasov od $n!<br>\n";
echo "razmerje je" . ((float)$counter/(float)$n);

?>
