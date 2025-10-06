<?php
session_start();
if(!isset($_SESSION['dashboard']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo "<div class='message error'>Access denied!</div>";
    exit;
}

// Match the form input names exactly
$cardNumber = $_POST['cardNumber'] ?? '';
$amount = $_POST['transactionAmount'] ?? '';
$cardType = $_POST['transactionType'] ?? '';

if(empty($cardNumber) || empty($amount) || empty($cardType)){
    echo "<div class='message error'>All fields are required.</div>";
    exit;
}

// Spring Boot API endpoint
$url = "http://localhost:9090/v1/transactions/$cardNumber";

$data = json_encode([
    'cardNumber' => $cardNumber,
    'transactionAmount' => (float)$amount,
    'transactionType' => $cardType
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

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
<title>Transaction Result — FinTech CMS</title>
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

.floating-shapes{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  pointer-events:none;
  overflow:hidden;
  z-index:0;
}
.shape{
  position:absolute;
  border-radius:50%;
  opacity:0.1;
  animation:float 20s infinite ease-in-out;
}
.shape-1{width:100px;height:100px;background:linear-gradient(135deg,var(--accent-blue),var(--accent-green));top:20%;left:10%;animation-delay:0s;}
.shape-2{width:80px;height:80px;background:linear-gradient(135deg,var(--accent-green),var(--accent-blue));top:60%;left:80%;animation-delay:2s;}
.shape-3{width:120px;height:120px;background:linear-gradient(135deg,var(--accent-red),var(--accent-blue));top:70%;left:15%;animation-delay:4s;}
@keyframes float{0%,100%{transform:translateY(0) rotate(0deg);}50%{transform:translateY(-30px) rotate(180deg);}}

.wrapper{
  max-width:700px;
  width:100%;
  background:var(--card-bg);
  border-radius:28px;
  padding:40px;
  box-shadow:0 12px 40px rgba(0,0,0,0.4);
  text-align:center;
  position:relative;
  z-index:1;
}

.header-icon{
  width:90px;
  height:90px;
  margin:0 auto 20px;
  background:linear-gradient(135deg, var(--accent-blue), var(--accent-red));
  border-radius:24px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:42px;
  color:#fff;
  animation:pulse 2s ease-in-out infinite;
}
@keyframes pulse{0%,100%{transform:scale(1);}50%{transform:scale(1.05);}}

h1{
  font-size:32px;
  font-weight:700;
  margin-bottom:30px;
  background: linear-gradient(135deg, var(--accent-blue), var(--accent-green));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.response-card{
  text-align:left;
  border-radius:20px;
  padding:25px 30px;
  margin-bottom:30px;
  font-size:15px;
  line-height:1.5;
  overflow-wrap:break-word;
  animation:fadeInUp 0.8s ease;
}
.success-card{
  background:linear-gradient(135deg, rgba(16,185,129,0.15), rgba(16,185,129,0.05));
  border:1px solid var(--accent-green);
  color: var(--accent-green);
}
.error-card{
  background:linear-gradient(135deg, rgba(239,68,68,0.15), rgba(239,68,68,0.05));
  border:1px solid var(--accent-red);
  color: var(--accent-red);
}

@keyframes fadeInUp{from{opacity:0;transform:translateY(30px);}to{opacity:1;transform:translateY(0);}}

.btn-group{
  display:flex;
  justify-content:center;
  gap:15px;
  flex-wrap:wrap;
}

a.back-btn{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:14px 28px;
  border-radius:16px;
  font-weight:600;
  text-decoration:none;
  transition:all 0.3s ease;
  box-shadow:0 6px 20px rgba(0,0,0,0.3);
}
a.back-btn.primary{
  background: var(--accent-green);
  color:#fff;
}
a.back-btn.primary:hover{ background:#059669; transform:translateY(-2px); }
a.back-btn.secondary{
  background: var(--accent-blue);
  color:#fff;
}
a.back-btn.secondary:hover{ background:#2563eb; transform:translateY(-2px); }

footer{
  margin-top:20px;
  font-size:13px;
  color: var(--text-secondary);
  text-align:center;
}
</style>
</head>
<body>

<div class="floating-shapes">
  <div class="shape shape-1"></div>
  <div class="shape shape-2"></div>
  <div class="shape shape-3"></div>
</div>

<div class="wrapper">
  <div class="header-icon"><i class="fas fa-money-bill-wave"></i></div>
  <h1>Transaction Result</h1>

  <?php
  if($error){
      echo "<div class='response-card error-card'><i class='fas fa-times-circle'></i> cURL Error:\n".htmlspecialchars($error)."</div>";
  } elseif($httpCode==200 || $httpCode==201){
      $json = json_decode($response,true);
      echo "<div class='response-card success-card'><i class='fas fa-check-circle'></i> Transaction Created Successfully!\n\n"
         . htmlspecialchars(json_encode($json, JSON_PRETTY_PRINT))
         . "</div>";
  } else{
      echo "<div class='response-card error-card'><i class='fas fa-exclamation-circle'></i> Failed to create transaction.\n\n"
         . htmlspecialchars($response)
         . "</div>";
  }
  ?>

  <div class="btn-group">
      <a href='../Creation/CreateTransaction.php' class='back-btn primary'><i class="fas fa-plus-circle"></i> Create Another</a>
      <a href='../Dashboard/TransactionDashboard.php' class='back-btn secondary'><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
  </div>

  <footer>FinTech CMS — Transaction Response Viewer</footer>
</div>

</body>
</html>
