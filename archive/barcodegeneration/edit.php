<html><head>
<title>barcode generation</title>
<link rel="stylesheet" type="text/css" href="5160.css" />
<link rel="stylesheet" type="text/css" href="print.css" media="print"/>
<style type="text/css">
      @font-face {
        font-family: "Code39Slim";
        src: url("http://lantius.org/leew/projects/abr/code39slim.ttf") format("truetype");
      }

span.bc { font-family: "Code39Slim"; font-size: 24pt; }
span.txt { font-family: verdana; font-size: 8pt; }


</style>

</head><body>
<h3 class="noprint">Barcodes that need to be edited</h3>
<ol>
<?php

// step one take the uploaded file

if ($_POST['upload'] == "") { 

echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"edit.php\">";
echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1000000\" />";
echo "<input type=\"file\" name=\"sourcefile\"><input type=\"submit\" name=\"upload\" value=\"upload file\" />";
echo "</form>";

} else {

// step two parse and display
$ourFileHandle = fopen($_FILES['sourcefile']['tmp_name'], 'r');

echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
$i = 0;
while ($line = fgets($ourFileHandle)) {
	// parse $line

	$chunks = preg_split("/\",\"/",$line);
	
	if (count($chunks) < 3) {
		continue;
	}

	$parsed = explode(":",$chunks[1]);
	
	// fancyname, description ... , upc / barcode
	$cat = $chunks[1];

	$upc = substr(preg_replace("/(\W|_)/","",strtoupper(end($parsed))),0,13);
	
	if(0 != strcmp($upc,strtoupper(end($parsed)))) {
		echo "<li>$chunks[1]</li>";
	}
}

fclose($ourFileHandle);
}
?>
</ol>
</body></html>