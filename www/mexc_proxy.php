<?php
// proxy na ziskani cen z merx, bo jinak prohlizec pri primem fetch() haze cors

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$url = "https://api.mexc.com/api/v3/avgPrice?symbol=BTCUSDC";

@$response = file_get_contents($url);

if ($response === FALSE) {
    http_response_code(500);
    echo json_encode((object)["error" => "cant get data"]);
    exit;
}

echo $response;