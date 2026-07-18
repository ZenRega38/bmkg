<?php
for($i=1; $i<=10; $i++) {
    $c = '65.01.0' . $i . '.2001';
    $res = @file_get_contents('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=' . $c);
    if ($res && strpos($res, 'lokasi') !== false) {
        $d = json_decode($res, true);
        echo $c . ' - ' . $d['data'][0]['lokasi']['kotkab'] . "\n";
        break;
    }
}
for($i=1; $i<=10; $i++) {
    $c = '65.03.0' . $i . '.1001';
    $res = @file_get_contents('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=' . $c);
    if ($res && strpos($res, 'lokasi') !== false) {
        $d = json_decode($res, true);
        echo $c . ' - ' . $d['data'][0]['lokasi']['kotkab'] . "\n";
        break;
    }
}
?>
