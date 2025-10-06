<?php
session_start();
if(!isset($_SESSION['dashboard']) || $_SERVER['REQUEST_METHOD']!=='POST'){
    echo "<div class='message error'>Access denied!</div>";
    exit;
}

$account_id = $_POST['account_id'] ?? '';
$expiry = $_POST['expiry'] ?? '';

if(!$account_id || !$expiry){
    echo "<div class='message error'>All fields are required.</div>";
    exit;
}

$url = "http://localhost:9090/v1/cards/$account_id";
$data = [
    "account_id" => $account_id,
    "expiry" => $expiry
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if($error){
    echo "
    <div class='message error'>
        <i class='fas fa-circle-exclamation'></i> 
        <strong>Connection Error:</strong> ".htmlspecialchars($error)."
    </div>
    ";
    exit;
}

$json = json_decode($response, true);

if($httpCode == 200 && isset($json['data'])){
    $card = $json['data'];
    echo "
    <div class='message success'>
        <div class='icon success-icon'><i class='fas fa-check-circle'></i></div>
        <h3>Card Created Successfully!</h3>
        <p>Card Number: <strong>".htmlspecialchars($card['cardNumber'])."</strong></p>
    </div>
    ";
}else{
    echo "
    <div class='message error'>
        <div class='icon error-icon'><i class='fas fa-times-circle'></i></div>
        <h3>Failed to Create Card</h3>
        <p>".htmlspecialchars($response)."</p>
    </div>
    ";
}
?>

<style>
:root {
  --primary: #3b82f6;
  --success: #10b981;
  --danger: #ef4444;
  --text-light: #f1f5f9;
  --text-muted: #94a3b8;
  --radius: 14px;
  --bg-dark: #1e293b;
  --border: rgba(255,255,255,0.1);
}

/* Base styles for messages */
.message {
  padding: 20px 24px;
  border-radius: var(--radius);
  margin-top: 20px;
  animation: fadeInUp 0.6s ease;
  border: 1px solid var(--border);
  box-shadow: 0 4px 20px rgba(0,0,0,0.3);
  background: var(--bg-dark);
  position: relative;
  overflow: hidden;
  text-align: center;
}

/* Success style */
.message.success {
  border-left: 5px solid var(--success);
}
.message.success h3 {
  color: var(--success);
  margin-bottom: 8px;
}
.message.success p {
  color: var(--text-light);
  font-size: 15px;
}

/* Error style */
.message.error {
  border-left: 5px solid var(--danger);
}
.message.error h3 {
  color: var(--danger);
  margin-bottom: 8px;
}
.message.error p {
  color: var(--text-light);
  font-size: 15px;
}

/* Icons */
.icon {
  font-size: 40px;
  margin-bottom: 10px;
}
.success-icon i {
  color: var(--success);
  animation: pop 0.8s ease;
}
.error-icon i {
  color: var(--danger);
  animation: shake 0.8s ease;
}

/* Animations */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes pop {
  0% { transform: scale(0); opacity: 0; }
  80% { transform: scale(1.1); opacity: 1; }
  100% { transform: scale(1); }
}
@keyframes shake {
  0%,100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  50% { transform: translateX(5px); }
  75% { transform: translateX(-3px); }
}

/* Gradient bar effect */
.message::before {
  content: '';
  position: absolute;
  top: 0; left: 0;
  height: 3px; width: 100%;
  background: linear-gradient(90deg, var(--primary), var(--success));
  animation: shimmer 3s linear infinite;
}
@keyframes shimmer {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(100%); }
}
</style>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
