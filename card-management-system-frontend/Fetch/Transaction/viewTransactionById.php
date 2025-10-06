<?php
session_start();
if(!isset($_SESSION['dashboard'])){
    echo "<div class='message error'>Access denied!</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Find Transaction By ID — FinTech CMS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root{
  --bg-primary:#0a0e27;
  --bg-secondary:#0f172a;
  --card-bg:#1e293b;
  --accent-blue:#3b82f6;
  --accent-green:#10b981;
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
  position:relative;
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

.form-card{
  background:var(--card-bg);
  border-radius:24px;
  padding:30px;
  border:1px solid rgba(148,163,184,0.1);
  box-shadow:0 6px 25px rgba(0,0,0,0.3);
}

.form-group{
  margin-bottom:20px;
  text-align:left;
}

.form-group label{
  display:block;
  font-weight:600;
  margin-bottom:8px;
  color: var(--text-primary);
}

input[type="text"]{
  width:100%;
  padding:14px 18px;
  font-size:16px;
  border-radius:12px;
  border:2px solid rgba(148,163,184,0.2);
  background: rgba(255,255,255,0.04);
  color: var(--text-primary);
  outline:none;
  transition: all 0.3s ease;
}

input[type="text"]:focus{
  border-color: var(--accent-blue);
  box-shadow:0 0 0 4px rgba(59,130,246,0.15);
}

input[type="submit"]{
  padding:14px 24px;
  font-size:16px;
  font-weight:700;
  background:linear-gradient(135deg, var(--accent-blue), var(--accent-green));
  color:#fff;
  border:none;
  border-radius:16px;
  cursor:pointer;
  transition: all 0.3s ease;
}

input[type="submit"]:hover{
  transform:translateY(-2px);
  box-shadow:0 10px 30px rgba(16,185,129,0.4);
}

.back-btn{
  display:inline-flex;
  align-items:center;
  gap:8px;
  margin-top:25px;
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
  <div class="header-icon"><i class="fas fa-search"></i></div>
  <h1>Find Transaction By ID</h1>

  <div class="form-card">
    <form action="../../Imp/Transaction/ViewTransactionImp.php" method="GET">
      <div class="form-group">
        <label for="transactionId">Transaction ID</label>
        <input type="text" name="transactionId" id="transactionId" placeholder="Enter Transaction ID" required>
      </div>
      <input type="submit" value="Search">
    </form>
  </div>

  <a href="../../Dashboard/TransactionDashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
</div>
</body>
</html>
