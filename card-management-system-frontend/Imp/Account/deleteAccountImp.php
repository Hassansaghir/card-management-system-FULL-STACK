<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['dashboard']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode(["success" => false, "message" => "Access denied!"]);
    exit;
}

$accountId = $_POST['accountId'] ?? '';

if(empty($accountId)){
    echo json_encode(["success" => false, "message" => "Account ID is required."]);
    exit;
}

$url = "http://localhost:9090/v1/accounts/$accountId";

// Send DELETE request via cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if($error){
    echo json_encode(["success" => false, "message" => "cURL Error: $error"]);
    exit;
}

$json = json_decode($response, true);

if($httpCode === 200 || $httpCode === 204){
    echo json_encode(["success" => true]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Delete failed!",
        "response" => $response
    ]);
}
?>
