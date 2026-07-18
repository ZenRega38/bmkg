<?php
$ch = curl_init('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm1=65');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$response = curl_exec($ch);
echo substr($response, 0, 500);
?>
