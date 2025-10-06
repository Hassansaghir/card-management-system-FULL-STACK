<?php
session_start();
if(!isset($_SESSION['dashboard'])){
    echo "Access denied!";
    exit;
}

$accountId = $_GET['accountId'] ?? '';
$cardNumber = $_GET['cardNumber'] ?? '';

if(empty($accountId) || empty($cardNumber)){
    echo "Invalid account or card number.";
    exit;
}

$url = "http://localhost:9090/v1/accounts/$accountId";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

$card = null;
$accountStatus = '';
if(!$error && $httpCode == 200){
    $json = json_decode($response, true);
    if(isset($json['data'])){
        $account = $json['data'];
        $accountStatus = $account['status'] ?? '';
        if(isset($account['cards'])){
            foreach($account['cards'] as $c){
                if($c['cardNumber'] === $cardNumber){
                    $card = $c;
                    break;
                }
            }
        }
    }
}

function maskCardNumber($number){
    $last4 = substr($number, -4);
    return '**** **** **** '.$last4;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Card Details — FinTech CMS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<style>
/* ==== Reuse same design system ==== */
:root{
  --bg-primary: #0a0e1a;
  --bg-secondary: #0f1419;
  --bg-card: #141821;
  --accent-blue: #3b82f6;
  --accent-purple: #8b5cf6;
  --accent-cyan: #06b6d4;
  --text-primary: #f8fafc;
  --text-secondary: #94a3b8;
  --text-muted: #64748b;
  --success: #10b981;
  --danger: #ef4444;
  --border: rgba(148, 163, 184, 0.1);
  --shadow-md: 0 8px 24px rgba(0,0,0,0.4);
}

*{margin:0;padding:0;box-sizing:border-box;}

body {
  font-family: 'Inter', sans-serif;
  background: linear-gradient(135deg, var(--bg-primary), var(--bg-secondary));
  color: var(--text-primary);
  min-height: 100vh;
  padding: 20px;
  position: relative;
}

body::before {
  content: '';
  position: fixed;
  top: -50%; right: -50%;
  width: 200%; height: 200%;
  background: radial-gradient(circle at 30% 50%, rgba(59,130,246,0.08), transparent 50%),
              radial-gradient(circle at 70% 80%, rgba(139,92,246,0.08), transparent 50%);
  animation: gradientShift 20s ease infinite;
  pointer-events: none;
}
@keyframes gradientShift {
  0%,100% {transform:translate(0,0);}
  50% {transform:translate(-10%,-10%) rotate(180deg);}
}

.container {max-width:1200px;margin:auto;position:relative;z-index:1;}

.breadcrumb {
  display:flex;align-items:center;gap:8px;
  font-size:14px;color:var(--text-muted);margin-bottom:16px;flex-wrap:wrap;
}
.breadcrumb a {color:var(--text-secondary);text-decoration:none;}
.breadcrumb a:hover {color:var(--accent-blue);}

h1 {
  font-size:32px;font-weight:800;
  background: linear-gradient(135deg,var(--accent-blue),var(--accent-purple));
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  margin-bottom:24px;
}

.card-detail {
  max-width:420px;margin:auto;
}
.card {
  width:100%;height:230px;border-radius:20px;
  padding:28px;position:relative;
  display:flex;flex-direction:column;justify-content:space-between;
  overflow:hidden;box-shadow:var(--shadow-md);
}
.card::before {
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(59,130,246,0.95),rgba(139,92,246,0.95));
  z-index:0;
}
.card::after {
  content:'';position:absolute;top:-50%;right:-50%;
  width:200%;height:200%;
  background:radial-gradient(circle,rgba(255,255,255,0.15),transparent 60%);
  z-index:1;
}
.card-content {position:relative;z-index:2;height:100%;display:flex;flex-direction:column;}
.card-header {display:flex;justify-content:space-between;align-items:flex-start;}
.card-bank {font-size:13px;font-weight:700;text-transform:uppercase;opacity:0.9;}
.card-status {
  font-size:11px;font-weight:600;text-transform:uppercase;
  background:rgba(255,255,255,0.2);
  padding:4px 10px;border-radius:12px;backdrop-filter:blur(10px);
}
.card-chip {width:50px;height:40px;border-radius:8px;
  background:linear-gradient(135deg,#f4e4c1,#d4c499);
  box-shadow:inset 0 2px 6px rgba(0,0,0,0.3);
  margin:20px 0;
}
.card-chip img{width:100%;height:100%;object-fit:cover;opacity:0.8;}
.card-number {font-size:22px;letter-spacing:3px;font-family:'Courier New',monospace;margin-bottom:20px;}
.card-footer {display:flex;justify-content:space-between;align-items:flex-end;}
.card-expiry-section {display:flex;flex-direction:column;gap:4px;}
.card-label {font-size:9px;text-transform:uppercase;opacity:0.7;}
.card-expiry {font-size:15px;font-weight:500;letter-spacing:1px;font-family:'Courier New',monospace;}
.card-logo {width:65px;filter:drop-shadow(0 3px 6px rgba(0,0,0,0.3));}

.error-state {
  text-align:center;padding:80px 20px;background:var(--bg-card);
  border-radius:20px;border:1px solid var(--border);max-width:600px;margin:auto;
}
.error-state h2 {font-size:24px;color:var(--danger);margin-bottom:12px;}

.nav-actions {display:flex;gap:16px;justify-content:center;margin-top:40px;flex-wrap:wrap;}
.btn {
  padding:12px 24px;border-radius:12px;font-size:15px;font-weight:600;
  text-decoration:none;display:inline-flex;align-items:center;
  transition:all 0.3s;cursor:pointer;
}
.btn-secondary {
  background:var(--bg-card);color:var(--text-primary);border:1px solid var(--border);
}
.btn-secondary:hover {background:rgba(59,130,246,0.1);border-color:var(--accent-blue);}
</style>
</head>
<body>
<div class="container">

  <div class="breadcrumb">
    <a href="../../Dashboard/dashboard.php">Dashboard</a>
    <span>›</span>
    <a href="../Account/fetchAllAccounts.php">Accounts</a>
    <span>›</span>
    <a href="viewCards.php?accountId=<?=urlencode($accountId)?>">Cards</a>
    <span>›</span>
    <span>Details</span>
  </div>

  <h1>Card Details</h1>

  <?php if($error): ?>
    <div class="error-state">
      <h2>Connection Error</h2>
      <p><?=htmlspecialchars($error)?></p>
    </div>
  <?php elseif(!$card): ?>
    <div class="error-state">
      <h2>Card Not Found</h2>
      <p>The requested card could not be found for this account.</p>
    </div>
  <?php else: ?>
    <div class="card-detail">
      <div class="card">
        <div class="card-content">
          <div class="card-header">
            <div class="card-bank">FINTECH</div>
            <div class="card-status"><?=htmlspecialchars($card['status'])?></div>
          </div>

          <div class="card-chip">
            <img src='../../images/OIP-removebg-preview.png' alt='chip'>
          </div>

          <div class="card-number"><?=maskCardNumber($card['cardNumber'])?></div>

          <div class="card-footer">
            <div class="card-expiry-section">
              <span class="card-label">Valid Thru</span>
              <span class="card-expiry"><?=htmlspecialchars($card['expiry'])?></span>
            </div>
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa" class="card-logo">
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <div class="nav-actions">
    <a href="viewCards.php?accountId=<?=urlencode($accountId)?>" class="btn btn-secondary">← Back to Cards</a>
    <a href="../../Dashboard/dashboard.php" class="btn btn-secondary">← Dashboard</a>
  </div>
</div>
</body>
</html>
