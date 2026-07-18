<?php
$content = file_get_contents('web/cuaca.php');
$fixed = mb_convert_encoding($content, 'ISO-8859-1', 'UTF-8');
file_put_contents('web/cuaca.php', $fixed);
echo "Fixed via mb_convert_encoding.";
?>
