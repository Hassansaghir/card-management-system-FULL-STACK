<?php
session_start();

// Return JSON
header('Content-Type: application/json');

// Access check
if(!isset($_SESSION['dashboard']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode([
        "success" => false, 
        "message" => "🚫 Access denied!",
        "emoji" => "❌"
    ]);
    exit;
}

// Get input
$accountId = $_POST['accountId'] ?? '';
$balance = $_POST['balance'] ?? null;
$status = $_POST['status'] ?? null;

// Validate account ID
if(empty($accountId)){
    echo json_encode([
        "success" => false, 
        "message" => "⚠️ Account ID is required.",
        "emoji" => "⚠️"
    ]);
    exit;
}

// API URL
$url = "http://localhost:9090/v1/accounts/$accountId";

// Prepare data — allow empty values
$data = [];
if($balance !== '' && $balance !== null) $data['balance'] = (float)$balance;
if($status !== '' && $status !== null) $data['status'] = $status;

// Check if there's anything to update
if(empty($data)){
    echo json_encode([
        "success" => false, 
        "message" => "💡 No fields to update. Please provide balance or status.",
        "emoji" => "💡"
    ]);
    exit;
}

// Send PATCH request via cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

// Handle cURL errors
if($error){
    echo json_encode([
        "success" => false, 
        "message" => "❌ cURL Error: " . htmlspecialchars($error),
        "emoji" => "❌"
    ]);
    exit;
}

// Decode API response
$json = json_decode($response, true);

// Success
if($httpCode === 200 && isset($json['data'])){
    // Format response with enhanced data
    $account = $json['data'];
    
    // Add status emoji
    $statusEmoji = '✅';
    if(isset($account['status'])){
        $statusEmoji = $account['status'] === 'Active' ? '✅' : 
                      ($account['status'] === 'Inactive' ? '⏸️' : '🔴');
    }
    
    // Format balance
    if(isset($account['balance'])){
        $account['balanceFormatted'] = number_format((float)$account['balance'], 2);
    }
    
    echo json_encode([
        "success" => true,
        "message" => "🎉 Account updated successfully!",
        "emoji" => "✅",
        "statusEmoji" => $statusEmoji,
        "account" => $account,
        "updatedFields" => array_keys($data),
        "timestamp" => date('Y-m-d H:i:s')
    ]);
} else {
    // Handle different error scenarios
    $errorMessage = "Update failed!";
    $errorEmoji = "❌";
    
    if($httpCode === 404){
        $errorMessage = "Account not found with ID: " . htmlspecialchars($accountId);
        $errorEmoji = "🔍";
    } elseif($httpCode === 400){
        $errorMessage = "Invalid data provided. Please check your input.";
        $errorEmoji = "⚠️";
    } elseif($httpCode === 500){
        $errorMessage = "Server error occurred. Please try again later.";
        $errorEmoji = "🔧";
    }
    
    echo json_encode([
        "success" => false,
        "message" => $errorEmoji . " " . $errorMessage,
        "emoji" => $errorEmoji,
        "httpCode" => $httpCode,
        "response" => $response,
        "debug" => [
            "accountId" => $accountId,
            "requestedUpdates" => $data
        ]
    ]);
}
?>