<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $balance = $_POST['balance'] ?? 0;

    $url = "http://localhost:9090/v1/accounts";
    $data = ["balance" => (float)$balance];

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

    $json = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Account Creation Result — FinTech CMS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root{
  --bg-primary:#0a0e27;
  --bg-secondary:#0f172a;
  --card-bg:#1e293b;
  --success-bg:#10b981;
  --error-bg:#ef4444;
  --accent-blue:#3b82f6;
  --text-primary:#f1f5f9;
  --text-secondary:#94a3b8;
  --border-color:rgba(148, 163, 184, 0.1);
}

*{
  box-sizing:border-box;
  margin:0;
  padding:0;
}

body{
  font-family:'Inter', sans-serif;
  background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
  color:var(--text-primary);
  min-height:100vh;
  padding:40px 20px;
  position:relative;
  overflow-x:hidden;
}

body::before{
  content:'';
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background: 
    radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
    radial-gradient(circle at 80% 70%, rgba(16, 185, 129, 0.15) 0%, transparent 50%);
  pointer-events:none;
  z-index:0;
}

.wrapper{
  max-width:700px;
  margin:0 auto;
  position:relative;
  z-index:1;
}

.result-container{
  animation:fadeInUp 0.8s ease;
}

@keyframes fadeInUp{
  from{
    opacity:0;
    transform:translateY(30px);
  }
  to{
    opacity:1;
    transform:translateY(0);
  }
}

.success-header{
  text-align:center;
  margin-bottom:40px;
}

.success-icon{
  width:100px;
  height:100px;
  margin:0 auto 24px;
  background:linear-gradient(135deg, var(--success-bg), #059669);
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  box-shadow:0 8px 32px rgba(16, 185, 129, 0.4);
  animation:scaleIn 0.6s ease;
  position:relative;
}

.success-icon::before{
  content:'';
  position:absolute;
  inset:-8px;
  border-radius:50%;
  border:3px solid rgba(16, 185, 129, 0.3);
  animation:pulse 2s ease-in-out infinite;
}

@keyframes scaleIn{
  from{
    transform:scale(0);
    opacity:0;
  }
  to{
    transform:scale(1);
    opacity:1;
  }
}

@keyframes pulse{
  0%, 100%{
    transform:scale(1);
    opacity:1;
  }
  50%{
    transform:scale(1.1);
    opacity:0.5;
  }
}

.success-icon i{
  font-size:48px;
  color:#fff;
  animation:checkmark 0.8s ease 0.3s backwards;
}

@keyframes checkmark{
  from{
    transform:scale(0) rotate(-45deg);
    opacity:0;
  }
  to{
    transform:scale(1) rotate(0deg);
    opacity:1;
  }
}

.error-icon{
  width:100px;
  height:100px;
  margin:0 auto 24px;
  background:linear-gradient(135deg, var(--error-bg), #dc2626);
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  box-shadow:0 8px 32px rgba(239, 68, 68, 0.4);
  animation:shake 0.6s ease;
}

@keyframes shake{
  0%, 100%{transform:translateX(0);}
  25%{transform:translateX(-10px);}
  75%{transform:translateX(10px);}
}

.error-icon i{
  font-size:48px;
  color:#fff;
}

.success-header h2{
  font-size:32px;
  font-weight:700;
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  background-clip:text;
  margin-bottom:10px;
}

.error-header h2{
  font-size:32px;
  font-weight:700;
  color:var(--error-bg);
  margin-bottom:10px;
}

.success-header p,
.error-header p{
  color:var(--text-secondary);
  font-size:16px;
}

.account-card{
  background:var(--card-bg);
  border-radius:24px;
  padding:40px;
  border:1px solid var(--border-color);
  box-shadow:0 8px 32px rgba(0,0,0,0.3);
  margin-bottom:24px;
}

.info-grid{
  display:grid;
  gap:20px;
}

.info-item{
  background:rgba(255,255,255,0.03);
  padding:20px;
  border-radius:16px;
  border:1px solid var(--border-color);
  transition:all 0.3s ease;
}

.info-item:hover{
  background:rgba(255,255,255,0.05);
  border-color:var(--accent-blue);
  transform:translateX(4px);
}

.info-label{
  display:flex;
  align-items:center;
  gap:10px;
  font-size:12px;
  text-transform:uppercase;
  letter-spacing:1px;
  color:var(--text-secondary);
  font-weight:600;
  margin-bottom:8px;
}

.info-label i{
  color:var(--accent-blue);
  font-size:16px;
}

.info-value{
  font-size:20px;
  font-weight:700;
  color:var(--text-primary);
}

.info-value.balance{
  color:var(--success-bg);
  font-size:28px;
}

.cards-section{
  margin-top:24px;
}

.cards-section h3{
  font-size:18px;
  font-weight:700;
  color:var(--text-primary);
  margin-bottom:16px;
  display:flex;
  align-items:center;
  gap:10px;
}

.cards-section h3 i{
  color:var(--accent-blue);
}

.cards-list{
  list-style:none;
  display:grid;
  gap:12px;
}

.card-item{
  background:rgba(59, 130, 246, 0.05);
  padding:16px;
  border-radius:12px;
  border:1px solid rgba(59, 130, 246, 0.2);
  display:flex;
  flex-wrap:wrap;
  gap:16px;
  align-items:center;
  transition:all 0.3s ease;
}

.card-item:hover{
  background:rgba(59, 130, 246, 0.1);
  transform:translateX(4px);
}

.card-detail{
  display:flex;
  flex-direction:column;
  gap:4px;
}

.card-detail strong{
  font-size:11px;
  text-transform:uppercase;
  letter-spacing:0.5px;
  color:var(--text-secondary);
  font-weight:600;
}

.card-detail span{
  font-size:14px;
  color:var(--text-primary);
  font-weight:600;
}

.no-cards{
  text-align:center;
  padding:24px;
  color:var(--text-secondary);
  font-style:italic;
}

.error-box{
  background:rgba(239, 68, 68, 0.1);
  border:1px solid rgba(239, 68, 68, 0.3);
  border-radius:16px;
  padding:24px;
  margin-bottom:24px;
}

.error-box pre{
  background:rgba(0,0,0,0.3);
  padding:16px;
  border-radius:8px;
  overflow-x:auto;
  font-size:13px;
  color:var(--text-secondary);
  margin-top:12px;
}

.btn-group{
  display:flex;
  gap:16px;
  flex-wrap:wrap;
}

.btn{
  flex:1;
  min-width:200px;
  padding:16px 24px;
  border-radius:14px;
  font-weight:600;
  font-size:15px;
  text-decoration:none;
  text-align:center;
  transition:all 0.3s ease;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:10px;
}

.btn-primary{
  background:linear-gradient(135deg, var(--accent-blue), #2563eb);
  color:#fff;
  border:none;
  box-shadow:0 4px 24px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover{
  transform:translateY(-2px);
  box-shadow:0 8px 32px rgba(59, 130, 246, 0.5);
}

.btn-secondary{
  background:rgba(255,255,255,0.05);
  color:var(--text-primary);
  border:1px solid var(--border-color);
}

.btn-secondary:hover{
  background:rgba(255,255,255,0.1);
  border-color:var(--accent-blue);
  transform:translateY(-2px);
}

@media(max-width:768px){
  .wrapper{
    padding:20px;
  }
  .account-card{
    padding:24px;
  }
  .btn-group{
    flex-direction:column;
  }
  .btn{
    min-width:100%;
  }
}
</style>
</head>
<body>

<div class="wrapper">
  <div class="result-container">
    <?php if($error): ?>
      <div class="error-header">
        <div class="error-icon">
          <i class="fas fa-exclamation-circle"></i>
        </div>
        <h2>Connection Error</h2>
        <p>Unable to connect to the server</p>
      </div>
      <div class="error-box">
        <strong>cURL Error:</strong> <?=htmlspecialchars($error)?>
      </div>
    <?php elseif($httpCode == 200 && isset($json['data'])): ?>
      <?php 
        $account = $json['data'];
        $cardsHTML = '';
        $hasCards = !empty($account['cards']) && is_array($account['cards']);
      ?>
      <div class="success-header">
        <div class="success-icon">
          <i class="fas fa-check"></i>
        </div>
        <h2>Account Created Successfully!</h2>
        <p>Your new account has been set up and is ready to use</p>
      </div>

      <div class="account-card">
        <div class="info-grid">
          <div class="info-item">
            <div class="info-label">
              <i class="fas fa-id-badge"></i>
              <span>Account ID</span>
            </div>
            <div class="info-value"><?=htmlspecialchars($account['id'])?></div>
          </div>

          <div class="info-item">
            <div class="info-label">
              <i class="fas fa-toggle-on"></i>
              <span>Status</span>
            </div>
            <div class="info-value"><?=htmlspecialchars($account['status'])?></div>
          </div>

          <div class="info-item">
            <div class="info-label">
              <i class="fas fa-wallet"></i>
              <span>Balance</span>
            </div>
            <div class="info-value balance">$<?=number_format($account['balance'], 2)?></div>
          </div>
        </div>

        <div class="cards-section">
          <h3>
            <i class="fas fa-credit-card"></i>
            Associated Cards
          </h3>
          <?php if($hasCards): ?>
            <ul class="cards-list">
              <?php foreach($account['cards'] as $card): ?>
                <li class="card-item">
                  <div class="card-detail">
                    <strong>Card Number</strong>
                    <span><?=htmlspecialchars($card['cardNumber'])?></span>
                  </div>
                  <div class="card-detail">
                    <strong>Status</strong>
                    <span><?=htmlspecialchars($card['status'])?></span>
                  </div>
                  <div class="card-detail">
                    <strong>Expiry</strong>
                    <span><?=htmlspecialchars($card['expiry'])?></span>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <div class="no-cards">No cards associated with this account</div>
          <?php endif; ?>
        </div>
      </div>
    <?php else: ?>
      <div class="error-header">
        <div class="error-icon">
          <i class="fas fa-times-circle"></i>
        </div>
        <h2>Unexpected Response</h2>
        <p>The server returned an unexpected response</p>
      </div>
      <div class="error-box">
        <strong>Response Details:</strong>
        <pre><?=htmlspecialchars($response)?></pre>
      </div>
    <?php endif; ?>

    <div class="btn-group">
      <a href="../Creation/AccountCreation.php" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i>
        Create Another Account
      </a>
      <a href="../Dashboard/dashboard.php" class="btn btn-secondary">
        <i class="fas fa-home"></i>
        Back to Dashboard
      </a>
    </div>
  </div>
</div>

</body>
</html>
<?php
} else {
    echo "<div class='message error'>Invalid request.</div>";
}
?>