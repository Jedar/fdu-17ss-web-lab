<?php
$lryicsrc=$_POST["value"];
$myfile = fopen('upload/'.$lryicsrc.'.lrc', "r");
$mylryic=fread($myfile,filesize(iconv ( 'UTF-8', 'GBK', 'upload/'.$lryicsrc.'.lrc' )));
fclose($myfile);
echo($mylryic);
?>
