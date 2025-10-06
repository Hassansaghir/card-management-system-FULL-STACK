<?php
session_start();
if(!isset($_SESSION['dashboard'])){
    echo "Access denied!";
    exit;
}

$accountId = $_GET['accountId'] ?? '';
if(empty($accountId)){
    echo "Invalid account ID.";
    exit;
}

$url = "http://localhost:9090/v1/accounts/$accountId";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

$cards = [];
$accountStatus = '';
if(!$error && $httpCode == 200){
    $json = json_decode($response, true);
    if(isset($json['data'])){
        $account = $json['data'];
        $cards = $account['cards'] ?? [];
        $accountStatus = $account['status'] ?? '';
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
<title>Card Management — FinTech CMS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
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
  --warning: #f59e0b;
  --danger: #ef4444;
  --border: rgba(148, 163, 184, 0.1);
  --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.3);
  --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.4);
  --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.5);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
  color: var(--text-primary);
  min-height: 100vh;
  padding: 20px;
  position: relative;
  overflow-x: hidden;
}

body::before {
  content: '';
  position: fixed;
  top: -50%;
  right: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle at 30% 50%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
              radial-gradient(circle at 70% 80%, rgba(139, 92, 246, 0.08) 0%, transparent 50%);
  pointer-events: none;
  animation: gradientShift 20s ease infinite;
}

@keyframes gradientShift {
  0%, 100% { transform: translate(0, 0) rotate(0deg); }
  50% { transform: translate(-10%, -10%) rotate(180deg); }
}

.container {
  max-width: 1400px;
  margin: 0 auto;
  position: relative;
  z-index: 1;
}

header {
  margin-bottom: 48px;
}

.breadcrumb {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  color: var(--text-muted);
  margin-bottom: 16px;
  flex-wrap: wrap;
}

.breadcrumb a {
  color: var(--text-secondary);
  text-decoration: none;
  transition: color 0.2s;
}

.breadcrumb a:hover {
  color: var(--accent-blue);
}

.breadcrumb-separator {
  color: var(--text-muted);
  user-select: none;
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  flex-wrap: wrap;
  gap: 24px;
}

.header-left h1 {
  font-size: 36px;
  font-weight: 800;
  background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 12px;
  letter-spacing: -0.5px;
}

.account-info {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
}

.account-id {
  font-size: 14px;
  color: var(--text-secondary);
  background: var(--bg-card);
  padding: 8px 16px;
  border-radius: 8px;
  border: 1px solid var(--border);
  font-family: 'Courier New', monospace;
}

.status-badge {
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.status-badge::before {
  content: '';
  width: 8px;
  height: 8px;
  border-radius: 50%;
  animation: pulse 2s ease-in-out infinite;
}

.status-active {
  background: rgba(16, 185, 129, 0.15);
  color: var(--success);
  border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-active::before {
  background: var(--success);
  box-shadow: 0 0 12px var(--success);
}

.status-inactive {
  background: rgba(239, 68, 68, 0.15);
  color: var(--danger);
  border: 1px solid rgba(239, 68, 68, 0.3);
}

.status-inactive::before {
  background: var(--danger);
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

.header-stats {
  display: flex;
  gap: 24px;
  background: var(--bg-card);
  padding: 20px 28px;
  border-radius: 16px;
  border: 1px solid var(--border);
}

.stat-item {
  text-align: center;
}

.stat-value {
  font-size: 28px;
  font-weight: 700;
  color: var(--text-primary);
  display: block;
  margin-bottom: 4px;
}

.stat-label {
  font-size: 12px;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
  gap: 28px;
  margin-bottom: 48px;
}

.card-wrapper {
  perspective: 1000px;
}

.card {
  width: 100%;
  height: 220px;
  border-radius: 20px;
  padding: 28px;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  text-decoration: none;
  color: #fff;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
  transform-style: preserve-3d;
  cursor: pointer;
}

.card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, 
    rgba(59, 130, 246, 0.95) 0%, 
    rgba(99, 102, 241, 0.95) 50%, 
    rgba(139, 92, 246, 0.95) 100%);
  transition: opacity 0.4s;
  z-index: 0;
}

.card:nth-child(2)::before {
  background: linear-gradient(135deg, 
    rgba(6, 182, 212, 0.95) 0%, 
    rgba(59, 130, 246, 0.95) 100%);
}

.card:nth-child(3)::before {
  background: linear-gradient(135deg, 
    rgba(139, 92, 246, 0.95) 0%, 
    rgba(219, 39, 119, 0.95) 100%);
}

.card:nth-child(4)::before {
  background: linear-gradient(135deg, 
    rgba(16, 185, 129, 0.95) 0%, 
    rgba(6, 182, 212, 0.95) 100%);
}

.card::after {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 60%);
  pointer-events: none;
  z-index: 1;
}

.card:hover {
  transform: translateY(-12px) rotateX(5deg);
  box-shadow: 0 32px 80px rgba(0, 0, 0, 0.6), 
              0 0 60px rgba(59, 130, 246, 0.3);
}

.card:hover::before {
  opacity: 1;
}

.card-content {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: auto;
}

.card-bank {
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  opacity: 0.9;
}

.card-type {
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  background: rgba(255, 255, 255, 0.2);
  padding: 4px 10px;
  border-radius: 12px;
  backdrop-filter: blur(10px);
}

.card-chip {
  width: 50px;
  height: 40px;
  border-radius: 8px;
  background: linear-gradient(135deg, #f4e4c1 0%, #e6d5a8 50%, #d4c499 100%);
  box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.3), 
              0 3px 8px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  position: relative;
  margin-bottom: 20px;
}

.card-chip img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0.8;
}

.card-number {
  font-size: 22px;
  letter-spacing: 3px;
  font-weight: 500;
  font-family: 'Courier New', monospace;
  text-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
  margin-bottom: 16px;
}

.card-footer {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
}

.card-expiry-section {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.card-label {
  font-size: 9px;
  text-transform: uppercase;
  letter-spacing: 1px;
  opacity: 0.7;
  font-weight: 600;
}

.card-expiry {
  font-size: 15px;
  font-weight: 500;
  letter-spacing: 1px;
  font-family: 'Courier New', monospace;
}

.card-logo {
  width: 65px;
  height: auto;
  opacity: 0.95;
  filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.3));
}

.empty-state,
.error-state {
  text-align: center;
  padding: 80px 20px;
  background: var(--bg-card);
  border-radius: 20px;
  border: 1px solid var(--border);
}

.empty-icon,
.error-icon {
  font-size: 64px;
  margin-bottom: 24px;
  opacity: 0.5;
}

.empty-state h2,
.error-state h2 {
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 12px;
  color: var(--text-primary);
}

.empty-state p,
.error-state p {
  font-size: 16px;
  color: var(--text-secondary);
}

.error-state {
  border-color: rgba(239, 68, 68, 0.3);
}

.error-state h2 {
  color: var(--danger);
}

.nav-actions {
  display: flex;
  gap: 16px;
  flex-wrap: wrap;
}

.btn {
  padding: 12px 24px;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
  border: none;
  cursor: pointer;
}

.btn-primary {
  background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
  color: white;
  box-shadow: var(--shadow-sm);
}

.btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 24px rgba(59, 130, 246, 0.4);
}

.btn-secondary {
  background: var(--bg-card);
  color: var(--text-primary);
  border: 1px solid var(--border);
}

.btn-secondary:hover {
  background: rgba(59, 130, 246, 0.1);
  border-color: var(--accent-blue);
  transform: translateY(-3px);
}

@media (max-width: 768px) {
  .header-content {
    flex-direction: column;
  }

  .header-left h1 {
    font-size: 28px;
  }

  .cards-grid {
    grid-template-columns: 1fr;
  }

  .header-stats {
    width: 100%;
    justify-content: space-around;
  }
}

@media (max-width: 480px) {
  body {
    padding: 16px;
  }

  .header-stats {
    flex-direction: column;
    gap: 16px;
    align-items: stretch;
  }

  .stat-item {
    padding: 12px;
    background: rgba(59, 130, 246, 0.05);
    border-radius: 8px;
  }
}
</style>
</head>
<body>

<div class="container">
  <header>
    <div class="breadcrumb">
      <a href="../../Dashboard/dashboard.php">Dashboard</a>
      <span class="breadcrumb-separator">›</span>
      <a href="../Account/fetchAllAccounts.php">Accounts</a>
      <span class="breadcrumb-separator">›</span>
      <span>Cards</span>
    </div>

    <div class="header-content">
      <div class="header-left">
        <h1>Card Management</h1>
        <div class="account-info">
          <div class="account-id"><?=htmlspecialchars($accountId)?></div>
          <div class="status-badge <?=strtolower($accountStatus)=='active'?'status-active':'status-inactive'?>">
            <?=htmlspecialchars($accountStatus)?>
          </div>
        </div>
      </div>

      <?php if(!empty($cards)): ?>
      <div class="header-stats">
        <div class="stat-item">
          <span class="stat-value"><?=count($cards)?></span>
          <span class="stat-label">Total Cards</span>
        </div>
        <div class="stat-item">
          <span class="stat-value"><?=count(array_filter($cards, fn($c) => strtolower($c['status'] ?? '') === 'active'))?></span>
          <span class="stat-label">Active</span>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </header>

  <?php if($error): ?>
    <div class="error-state">
      <div class="error-icon">⚠️</div>
      <h2>Connection Error</h2>
      <p><?=htmlspecialchars($error)?></p>
    </div>
  <?php elseif(empty($cards)): ?>
    <div class="empty-state">
      <div class="empty-icon">💳</div>
      <h2>No Cards Found</h2>
      <p>This account doesn't have any cards associated with it yet.</p>
    </div>
  <?php else: ?>
    <div class="cards-grid">
      <?php foreach($cards as $card): ?>
        <div class="card-wrapper">
          <a href="viewCardDetail.php?accountId=<?=urlencode($accountId)?>&cardNumber=<?=urlencode($card['cardNumber'])?>" class="card">
            <div class="card-content">
              <div class="card-header">
                <div class="card-bank">FINTECH</div>
                <div class="card-type"><?=htmlspecialchars($card['status'])?></div>
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
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" 
                     alt="Visa" class="card-logo">
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="nav-actions">
    <a href="../Account/fetchAllAccounts.php" class="btn btn-secondary">
      ← Back to Accounts
    </a>
    <a href="../../Dashboard/dashboard.php" class="btn btn-secondary">
      ← Dashboard
    </a>
  </div>
</div>

</body>
</html>