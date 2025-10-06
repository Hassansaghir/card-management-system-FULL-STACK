<?php
session_start();
if(!isset($_SESSION['dashboard']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo "<div style='color:red; font-weight:bold; text-align:center;'>Access denied!</div>";
    exit;
}

$cardNumber = $_POST['cardNumber'] ?? '';

if(empty($cardNumber)){
    echo "<div style='color:red; font-weight:bold; text-align:center;'>Card number is required.</div>";
    exit;
}

// API endpoint
$url = "http://localhost:9090/v1/cards/$cardNumber";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if($error){
    echo "<div style='color:red; font-weight:bold; text-align:center;'>cURL Error: ".htmlspecialchars($error)."</div>";
    exit;
}

$json = json_decode($response,true);

if($httpCode == 200 && isset($json['data'])){
    $card = $json['data'];
    echo "
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    body {
      margin:0;
      font-family:'Inter',sans-serif;
      background: #0f172a;
      color: #fff;
      display:flex;
      flex-direction:column;
      align-items:center;
      justify-content:center;
      min-height:100vh;
      padding:20px;
    }

    .card-wrapper {
      perspective: 1200px;
    }

    .card-container {
      width: 360px;
      height: 220px;
      border-radius: 22px;
      padding: 25px;
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      color:#fff;
      box-shadow: 0 12px 40px rgba(0,0,0,0.6);
      position: relative;
      overflow: hidden;
      transition: transform 0.5s ease, box-shadow 0.3s ease;
    }

    .card-container:hover {
      transform: rotateY(8deg) rotateX(3deg) scale(1.03);
      box-shadow: 0 18px 50px rgba(0,0,0,0.8);
    }

    .card-chip img {
      width: 60px;
      margin-bottom: 18px;
    }

    .card-number {
      font-size: 24px;
      letter-spacing: 4px;
      font-weight: 700;
      margin-bottom: 12px;
    }

    .account-id {
      font-size: 14px;
      opacity: 0.85;
      margin-bottom: 18px;
    }

    .card-footer {
      display: flex;
      justify-content: space-between;
      font-size: 15px;
      font-weight: 600;
    }

    .card-footer span {
      display: inline-block;
    }

    .status-active {
      color: #10b981;
    }

    .status-inactive {
      color: #ef4444;
    }

    .card-logo {
      position: absolute;
      bottom: 20px;
      right: 20px;
      width: 75px;
      opacity: 0.95;
    }

    .back-btns {
      margin-top: 40px;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .back-btns a {
      text-decoration: none;
      padding: 12px 20px;
      border-radius: 10px;
      background: linear-gradient(90deg, #60a5fa, #3b82f6);
      color: #021024;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .back-btns a:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.5);
    }

    </style>

    <div class='card-wrapper'>
      <div class='card-container'>
        <div class='card-chip'>
          <img src='../../images/OIP-removebg-preview.png' alt='chip'>
        </div>
         <span class='".(strtolower($card['status'])=='active'?'status-active':'status-inactive')."'>".htmlspecialchars($card['status'])."</span>
        <div class='card-number'>".chunk_split(htmlspecialchars($card['cardNumber']),4,' ')."</div>
        <div class='account-id'>Account ID: ".htmlspecialchars($card['account_id'])."</div>
        <div class='card-footer'>
          <span>EXP: ".htmlspecialchars($card['expiry'])."</span>
         
        </div>
        <img src='https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg' alt='logo' class='card-logo'>
      </div>
    </div>

    <div class='back-btns'>
      <a href='../../Fetch/Cards/getCardById.php'>← Search Another</a>
      <a href='../../Dashboard/Carddashboard.php'>← Back to Dashboard</a>
    </div>
    ";
} else {
    echo "<div style='text-align:center;color:#ef4444;font-weight:bold;margin-top:50px;'>Card not found. Response: ".htmlspecialchars($response)."</div>";
}
?>
