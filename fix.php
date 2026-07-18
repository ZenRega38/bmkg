<?php
$content = file_get_contents('web/cuaca.php');
$fixed = utf8_decode($content);
file_put_contents('web/cuaca.php', $fixed);
echo "Fixed encoding.";
?>
