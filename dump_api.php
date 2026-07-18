<?php
$json_data = file_get_contents('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm1=65');
if ($json_data) {
    file_put_contents('api_response.json', $json_data);
    echo "Saved to api_response.json";
} else {
    echo "Failed to fetch";
}
?>
