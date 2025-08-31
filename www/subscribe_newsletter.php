<?php
/**
 * zaregistruje email k zasilani newslatteru a posle uvitaci email
 * request je POST v JSON s polem email:string
 */
require_once '../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode((object)[
        'status' => 'error', 
        'message' => 'Request must be POST'
    ]);
    exit();
}

$request = json_decode(file_get_contents('php://input'), true);
$email = $request['email'] ?? '';
        
$controller = new App\SubscribeNewsletterController();
$controller->subscribe($email);
