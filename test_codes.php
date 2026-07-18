<?php
$codes = ['65.71.01.1001', '65.01.05.2001', '65.02.04.2001', '65.03.05.1001', '65.04.01.2001'];
foreach($codes as $c) {
    $res = @file_get_contents('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=' . $c);
    if ($res && strpos($res, 'lokasi') !== false) {
        $d = json_decode($res, true);
        echo $c . ' - ' . $d['data'][0]['lokasi']['kotkab'] . "\n";
    } else {
        echo $c . ' - FAILED' . "\n";
    }
}
?>
