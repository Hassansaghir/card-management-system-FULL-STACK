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
<title>View All Transactions — FinTech CMS</title>
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
}

*{box-sizing:border-box;margin:0;padding:0;}
body{
  font-family:'Inter',sans-serif;
  background: linear-gradient(135deg, var(--bg-primary), var(--bg-secondary));
  color: var(--text-primary);
  min-height:100vh;
  padding:40px 20px;
  position:relative;
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
  animation:float 25s infinite ease-in-out;
}
.shape-1{width:120px;height:120px;background:linear-gradient(135deg,var(--accent-blue),var(--accent-purple));top:10%;left:5%;animation-delay:0s;}
.shape-2{width:100px;height:100px;background:linear-gradient(135deg,var(--accent-green),var(--accent-blue));top:60%;left:85%;animation-delay:3s;}
.shape-3{width:140px;height:140px;background:linear-gradient(135deg,var(--accent-purple),var(--accent-green));top:75%;left:20%;animation-delay:6s;}
@keyframes float{0%,100%{transform:translateY(0) rotate(0deg);}50%{transform:translateY(-30px) rotate(180deg);}}

.wrapper{
  max-width:1100px;
  margin:0 auto;
  position:relative;
  z-index:1;
}

.header{
  text-align:center;
  margin-bottom:30px;
}
.header h1{
  font-size:36px;
  font-weight:700;
  background: linear-gradient(135deg, var(--accent-blue), var(--accent-green));
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  margin-bottom:10px;
}
.header p{
  color: var(--text-secondary);
  font-size:16px;
}

.table-card{
  background: var(--card-bg);
  border-radius:24px;
  padding:30px;
  box-shadow:0 12px 40px rgba(0,0,0,0.4);
  overflow-x:auto;
  animation:fadeInUp 0.8s ease;
}

table{
  width:100%;
  border-collapse:collapse;
}
table th, table td{
  padding:14px 16px;
  text-align:left;
  border-bottom:1px solid rgba(255,255,255,0.05);
  font-size:15px;
}
table th{
  background: rgba(15,23,42,0.8);
  color: var(--accent-blue);
  font-weight:600;
  position: sticky;
  top:0;
}
table tr:hover{
  background: rgba(59,130,246,0.1);
  transition:0.3s;
}
table td{
  color: var(--text-primary);
}

.back-btn{
  display:inline-flex;
  align-items:center;
  gap:10px;
  padding:14px 28px;
  border-radius:16px;
  font-weight:600;
  text-decoration:none;
  background: var(--accent-blue);
  color:#fff;
  margin-top:25px;
  transition:all 0.3s ease;
  box-shadow:0 6px 20px rgba(0,0,0,0.3);
}
.back-btn:hover{
  background:#2563eb;
  transform:translateY(-2px);
}

@keyframes fadeInUp{from{opacity:0;transform:translateY(30px);}to{opacity:1;transform:translateY(0);}}

@media(max-width:768px){
  .header h1{font-size:28px;}
  table th, table td{padding:10px;}
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
  <div class="header">
    <h1>All Transactions</h1>
    <p>View all transaction records with details.</p>
  </div>

  <div class="table-card">
    <?php include "../../Imp/Transaction/viewAllTransactionsImp.php"; ?>
  </div>

  <div style="text-align:center;">
    <a href="../../Dashboard/TransactionDashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
  </div>
</div>

</body>
</html>
