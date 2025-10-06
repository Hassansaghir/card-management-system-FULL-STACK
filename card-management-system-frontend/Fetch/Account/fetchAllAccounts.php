<?php
session_start();
if(!isset($_SESSION['dashboard'])){
    echo "Access denied!";
    exit;
}

// API URL
$url = "http://localhost:9090/v1/accounts";

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

$accounts = [];
if(!$error && $httpCode == 200){
    $json = json_decode($response, true);
    if(isset($json['data'])){
        $accounts = $json['data'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Accounts — FinTech CMS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root{
  --bg-primary:#0a0e27;
  --bg-secondary:#0f172a;
  --card-bg:#1e293b;
  --accent-blue:#3b82f6;
  --accent-green:#10b981;
  --accent-purple:#8b5cf6;
  --text-primary:#f1f5f9;
  --text-secondary:#94a3b8;
  --border-color:rgba(148, 163, 184, 0.1);
  --error:#ef4444;
  --success:#10b981;
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

.container{
  max-width:1400px;
  margin:0 auto;
  position:relative;
  z-index:1;
}

.btn-back{
  display:inline-flex;
  align-items:center;
  gap:10px;
  padding:14px 28px;
  border-radius:16px;
  background:rgba(59, 130, 246, 0.1);
  backdrop-filter:blur(20px);
  color:var(--accent-blue);
  font-weight:600;
  font-size:15px;
  text-decoration:none;
  border:1px solid rgba(59, 130, 246, 0.2);
  box-shadow:0 4px 24px rgba(0,0,0,0.2);
  transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  margin-bottom:40px;
  animation:slideInLeft 0.6s ease;
}

@keyframes slideInLeft{
  from{
    opacity:0;
    transform:translateX(-50px);
  }
  to{
    opacity:1;
    transform:translateX(0);
  }
}

.btn-back:hover{
  background:var(--accent-blue);
  color:#fff;
  transform:translateY(-2px);
  box-shadow:0 8px 32px rgba(59, 130, 246, 0.4);
}

.btn-back i{
  font-size:16px;
  transition:transform 0.3s ease;
}

.btn-back:hover i{
  transform:translateX(-4px);
}

.header{
  text-align:center;
  margin-bottom:48px;
  animation:fadeInDown 0.8s ease;
}

@keyframes fadeInDown{
  from{
    opacity:0;
    transform:translateY(-30px);
  }
  to{
    opacity:1;
    transform:translateY(0);
  }
}

.header-icon{
  width:90px;
  height:90px;
  margin:0 auto 24px;
  background:linear-gradient(135deg, var(--accent-blue), var(--accent-green));
  border-radius:24px;
  display:flex;
  align-items:center;
  justify-content:center;
  box-shadow:0 12px 40px rgba(59, 130, 246, 0.4);
  position:relative;
  animation:pulse 2s ease-in-out infinite;
}

@keyframes pulse{
  0%, 100%{
    transform:scale(1);
    box-shadow:0 12px 40px rgba(59, 130, 246, 0.4);
  }
  50%{
    transform:scale(1.05);
    box-shadow:0 16px 48px rgba(59, 130, 246, 0.6);
  }
}

.header-icon::before{
  content:'';
  position:absolute;
  inset:-4px;
  border-radius:24px;
  background:linear-gradient(45deg, var(--accent-blue), var(--accent-green), var(--accent-purple));
  opacity:0.3;
  z-index:-1;
  animation:rotate 3s linear infinite;
}

@keyframes rotate{
  from{transform:rotate(0deg);}
  to{transform:rotate(360deg);}
}

.header-icon i{
  font-size:42px;
  color:#fff;
}

.header h1{
  font-size:38px;
  font-weight:700;
  background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  background-clip:text;
  margin-bottom:12px;
  letter-spacing:-0.5px;
}

.header p{
  color:var(--text-secondary);
  font-size:17px;
  font-weight:500;
}

.stats-row{
  display:grid;
  grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
  gap:20px;
  margin-bottom:32px;
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

.stat-card{
  background:var(--card-bg);
  border-radius:20px;
  padding:24px;
  border:1px solid var(--border-color);
  display:flex;
  align-items:center;
  gap:16px;
  transition:all 0.3s ease;
}

.stat-card:hover{
  transform:translateY(-4px);
  box-shadow:0 12px 32px rgba(0,0,0,0.4);
}

.stat-icon{
  width:56px;
  height:56px;
  border-radius:16px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:24px;
}

.stat-icon.blue{background:rgba(59, 130, 246, 0.2); color:var(--accent-blue);}
.stat-icon.green{background:rgba(16, 185, 129, 0.2); color:var(--accent-green);}
.stat-icon.purple{background:rgba(139, 92, 246, 0.2); color:var(--accent-purple);}

.stat-info h3{
  font-size:28px;
  font-weight:700;
  margin-bottom:4px;
}

.stat-info p{
  font-size:13px;
  color:var(--text-secondary);
  text-transform:uppercase;
  letter-spacing:0.5px;
  font-weight:600;
}

.table-card{
  background:var(--card-bg);
  border-radius:24px;
  padding:32px;
  border:1px solid var(--border-color);
  box-shadow:0 12px 40px rgba(0,0,0,0.4);
  animation:fadeInUp 0.8s ease 0.2s backwards;
  overflow:hidden;
}

.table-wrapper{
  overflow-x:auto;
}

table{
  width:100%;
  border-collapse:collapse;
}

thead{
  background:rgba(59, 130, 246, 0.1);
  border-radius:12px;
}

th{
  padding:16px 20px;
  text-align:left;
  font-size:13px;
  text-transform:uppercase;
  letter-spacing:1px;
  color:var(--accent-blue);
  font-weight:700;
  border-bottom:2px solid rgba(59, 130, 246, 0.3);
}

td{
  padding:20px;
  border-bottom:1px solid var(--border-color);
  font-size:15px;
  font-weight:500;
}

tbody tr{
  transition:all 0.3s ease;
}

tbody tr:hover{
  background:rgba(59, 130, 246, 0.05);
}

tbody tr:last-child td{
  border-bottom:none;
}

.status-active{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:6px 12px;
  border-radius:20px;
  background:rgba(16, 185, 129, 0.15);
  color:var(--success);
  font-weight:600;
  font-size:13px;
}

.status-active::before{
  content:'';
  width:8px;
  height:8px;
  border-radius:50%;
  background:var(--success);
  animation:blink 2s ease-in-out infinite;
}

@keyframes blink{
  0%, 100%{opacity:1;}
  50%{opacity:0.3;}
}

.status-inactive{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:6px 12px;
  border-radius:20px;
  background:rgba(239, 68, 68, 0.15);
  color:var(--error);
  font-weight:600;
  font-size:13px;
}

.status-inactive::before{
  content:'';
  width:8px;
  height:8px;
  border-radius:50%;
  background:var(--error);
}

.balance{
  font-weight:700;
  color:var(--accent-green);
  font-size:16px;
}

.card-count{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:6px 12px;
  border-radius:12px;
  background:rgba(139, 92, 246, 0.15);
  color:var(--accent-purple);
  font-weight:600;
  font-size:14px;
}

.card-count i{
  font-size:14px;
}

.view-btn{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:10px 18px;
  border-radius:12px;
  background:linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
  color:#fff;
  text-decoration:none;
  font-weight:600;
  font-size:14px;
  transition:all 0.3s ease;
  border:none;
}

.view-btn:hover{
  transform:translateY(-2px);
  box-shadow:0 8px 24px rgba(59, 130, 246, 0.4);
}

.view-btn.disabled{
  background:rgba(148, 163, 184, 0.2);
  color:var(--text-secondary);
  cursor:not-allowed;
  opacity:0.5;
}

.view-btn.disabled:hover{
  transform:none;
  box-shadow:none;
}

.message{
  padding:20px;
  border-radius:16px;
  text-align:center;
  font-weight:600;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:12px;
  margin:40px 0;
  animation:fadeInUp 0.8s ease;
}

.message.error{
  background:rgba(239, 68, 68, 0.1);
  border:1px solid rgba(239, 68, 68, 0.3);
  color:var(--error);
}

.message i{
  font-size:24px;
}

@media(max-width:768px){
  .header h1{
    font-size:28px;
  }
  .table-card{
    padding:20px;
  }
  th, td{
    padding:12px;
    font-size:13px;
  }
  .stat-card{
    padding:16px;
  }
}
</style>
</head>
<body>

<div class="container">
  <a href="../../Dashboard/dashboard.php" class="btn-back">
    <i class="fas fa-arrow-left"></i> Back to Dashboard
  </a>

  <div class="header">
    <div class="header-icon">
      <i class="fas fa-users"></i>
    </div>
    <h1>All Accounts</h1>
    <p>View and manage all customer accounts</p>
  </div>

  <?php if($error): ?>
      <div class="message error">
        <i class="fas fa-exclamation-circle"></i>
        <span>cURL Error: <?=htmlspecialchars($error)?></span>
      </div>
  <?php elseif(empty($accounts)): ?>
      <div class="message error">
        <i class="fas fa-inbox"></i>
        <span>No accounts found.</span>
      </div>
  <?php else: ?>
      <?php 
        $totalAccounts = count($accounts);
        $activeAccounts = count(array_filter($accounts, fn($a) => strtolower($a['status']) === 'active'));
        $totalBalance = array_sum(array_column($accounts, 'balance'));
      ?>
      
      <div class="stats-row">
        <div class="stat-card">
          <div class="stat-icon blue">
            <i class="fas fa-users"></i>
          </div>
          <div class="stat-info">
            <h3><?=$totalAccounts?></h3>
            <p>Total Accounts</p>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon green">
            <i class="fas fa-check-circle"></i>
          </div>
          <div class="stat-info">
            <h3><?=$activeAccounts?></h3>
            <p>Active Accounts</p>
          </div>
        </div>
        
        <div class="stat-card">
          <div class="stat-icon purple">
            <i class="fas fa-wallet"></i>
          </div>
          <div class="stat-info">
            <h3>$<?=number_format($totalBalance, 2)?></h3>
            <p>Total Balance</p>
          </div>
        </div>
      </div>

      <div class="table-card">
        <div class="table-wrapper">
          <table>
            <thead>
              <tr>
                <th><i class="fas fa-id-badge"></i> ID</th>
                <th><i class="fas fa-toggle-on"></i> Status</th>
                <th><i class="fas fa-dollar-sign"></i> Balance</th>
                <th><i class="fas fa-credit-card"></i> Cards</th>
                <th><i class="fas fa-cog"></i> Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($accounts as $acc): ?>
              <tr>
                <td><?=htmlspecialchars($acc['id'])?></td>
                <td>
                  <span class="<?=strtolower($acc['status'])=='active'?'status-active':'status-inactive'?>">
                    <?=htmlspecialchars($acc['status'])?>
                  </span>
                </td>
                <td class="balance">$<?=number_format($acc['balance'],2)?></td>
                <td>
                  <span class="card-count">
                    <i class="fas fa-credit-card"></i>
                    <?=count($acc['cards'])?>
                  </span>
                </td>
                <td>
                  <?php if(count($acc['cards']) > 0): ?>
                    <a href="../Cards/viewCards.php?accountId=<?=urlencode($acc['id'])?>" class="view-btn">
                      <i class="fas fa-eye"></i>
                      View Cards
                    </a>
                  <?php else: ?>
                    <span class="view-btn disabled">
                      <i class="fas fa-ban"></i>
                      No Cards
                    </span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
  <?php endif; ?>
</div>

</body>
</html>