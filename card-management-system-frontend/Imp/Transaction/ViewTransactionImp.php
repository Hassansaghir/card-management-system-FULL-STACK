<?php
session_start();
if(!isset($_SESSION['dashboard'])){
    echo "<div class='message error'>Access denied!</div>";
    exit;
}

$transactionId = $_GET['transactionId'] ?? '';

if(empty($transactionId)){
    echo "<div class='error'>Transaction ID is required.</div>";
    exit;
}

// Spring Boot API endpoint
$url = "http://localhost:9090/v1/transactions/$transactionId";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Transaction Details — FinTech CMS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root{
  --bg-primary:#0a0e27;
  --bg-secondary:#0f172a;
  --card-bg:#1e293b;
  --accent-blue:#3b82f6;
  --accent-green:#10b981;
  --accent-red:#ef4444;
  --text-primary:#f1f5f9;
  --text-secondary:#94a3b8;
}

*{box-sizing:border-box;margin:0;padding:0;}
body{
  font-family:'Inter',sans-serif;
  background: linear-gradient(135deg, var(--bg-primary), var(--bg-secondary));
  color: var(--text-primary);
  min-height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  padding:20px;
}

.wrapper{
  max-width:500px;
  width:100%;
  background: var(--card-bg);
  border-radius:28px;
  padding:40px;
  box-shadow:0 12px 40px rgba(0,0,0,0.4);
  text-align:center;
}

.header-icon{
  width:80px;
  height:80px;
  margin:0 auto 20px;
  background:linear-gradient(135deg, var(--accent-blue), var(--accent-green));
  border-radius:24px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:36px;
  color:#fff;
  box-shadow:0 12px 40px rgba(59,130,246,0.4);
}

h1{
  font-size:28px;
  font-weight:700;
  margin-bottom:25px;
  background: linear-gradient(135deg, var(--accent-blue), var(--accent-green));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.card{
  background: var(--card-bg);
  border-radius:24px;
  padding:25px 30px;
  border:1px solid rgba(148,163,184,0.1);
  box-shadow:0 6px 25px rgba(0,0,0,0.3);
  text-align:left;
  margin-bottom:20px;
}

.field{
  margin-bottom:12px;
}

.field span{
  font-weight:600;
  color: var(--accent-blue);
}

.error{
  color: var(--accent-red);
  font-weight:700;
  margin-bottom:20px;
}

.back-btn{
  display:inline-flex;
  align-items:center;
  gap:8px;
  margin-top:15px;
  padding:12px 24px;
  border-radius:16px;
  font-weight:600;
  text-decoration:none;
  background: var(--accent-green);
  color:#fff;
  transition: all 0.3s ease;
}

.back-btn:hover{
  background:#059669;
  transform:translateY(-2px);
}
</style>
</head>
<body>
<div class="wrapper">
  <div class="header-icon"><i class="fas fa-receipt"></i></div>
  <h1>Transaction Details</h1>

  <?php
  if($error){
      echo "<div class='error'><i class='fas fa-times-circle'></i> cURL Error: ".htmlspecialchars($error)."</div>";
  } elseif($httpCode == 200){
      $tx = json_decode($response, true);
      if(isset($tx['id'])){
          echo "<div class='card'>
                  <div class='field'><span>ID:</span> ".htmlspecialchars($tx['id'])."</div>
                  <div class='field'><span>Amount:</span> $".number_format($tx['transactionAmount'],2)."</div>
                  <div class='field'><span>Type:</span> ".htmlspecialchars($tx['transactionType'])."</div>
                  <div class='field'><span>Card Number:</span> ".htmlspecialchars($tx['cardNumber'])."</div>
                  <div class='field'><span>Created At:</span> ".htmlspecialchars($tx['createdAt'])."</div>
                  <div class='field'><span>Balance:</span> $".number_format($tx['balance'],2)."</div>
                </div>";
      } else {
          echo "<div class='error'><i class='fas fa-exclamation-circle'></i> Transaction not found.</div>";
      }
  } else {
      echo "<div class='error'><i class='fas fa-exclamation-triangle'></i> Failed to load transaction. Response: ".htmlspecialchars($response)."</div>";
  }
  ?>

  <a href='../../Fetch/Transaction/viewTransactionById.php' class='back-btn'><i class="fas fa-arrow-left"></i> Search Again</a>
</div>
</body>
</html>
