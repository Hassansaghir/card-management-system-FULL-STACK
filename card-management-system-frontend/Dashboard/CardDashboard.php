<?php
session_start();
if(!isset($_SESSION['dashboard'])){
    echo "Access denied!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Card Dashboard — FinTech CMS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root{
  --bg-primary:#0a0e27;
  --bg-secondary:#0f172a;
  --card-bg:#1e293b;
  --accent-blue:#3b82f6;
  --accent-cyan:#06b6d4;
  --accent-green:#10b981;
  --accent-purple:#8b5cf6;
  --accent-red:#ef4444;
  --text-primary:#f1f5f9;
  --text-secondary:#94a3b8;
  --border-color:rgba(148, 163, 184, 0.1);
}

*{box-sizing:border-box; margin:0; padding:0;}

body{
  font-family:'Inter', sans-serif;
  background:linear-gradient(135deg, var(--bg-primary), var(--bg-secondary));
  color:var(--text-primary);
  min-height:100vh;
  padding:40px 20px;
  overflow-x:hidden;
  position:relative;
}

body::before{
  content:'';
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background:
    radial-gradient(circle at 20% 30%, rgba(59,130,246,0.15) 0%, transparent 50%),
    radial-gradient(circle at 80% 70%, rgba(139,92,246,0.15) 0%, transparent 50%);
  pointer-events:none;
  z-index:0;
}

.floating-particles{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  pointer-events:none;
  z-index:0;
  overflow:hidden;
}
.particle{
  position:absolute;
  width:4px;
  height:4px;
  background:rgba(59,130,246,0.3);
  border-radius:50%;
  animation:float 20s infinite ease-in-out;
}
.particle:nth-child(1){left:10%;animation-delay:0s;animation-duration:15s;}
.particle:nth-child(2){left:25%;animation-delay:2s;animation-duration:18s;}
.particle:nth-child(3){left:40%;animation-delay:4s;animation-duration:20s;}
.particle:nth-child(4){left:55%;animation-delay:1s;animation-duration:16s;}
.particle:nth-child(5){left:70%;animation-delay:3s;animation-duration:19s;}
.particle:nth-child(6){left:85%;animation-delay:5s;animation-duration:17s;}
@keyframes float{
  0%,100%{transform:translateY(100vh) scale(0);opacity:0;}
  10%,90%{opacity:1;transform:translateY(10vh) scale(1);}
}

.wrapper{max-width:1400px;margin:0 auto;position:relative;z-index:1;}

.header{text-align:center;margin-bottom:60px;}
.header h1{
  font-size:48px;
  font-weight:700;
  background:linear-gradient(135deg,#3b82f6,#8b5cf6);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  margin-bottom:12px;
  letter-spacing:-1px;
  animation:fadeInDown 0.8s ease;
}
.header p{
  color:var(--text-secondary);
  font-size:18px;
  animation:fadeInUp 0.8s ease;
}
@keyframes fadeInDown{from{opacity:0;transform:translateY(-30px);}to{opacity:1;transform:translateY(0);}}
@keyframes fadeInUp{from{opacity:0;transform:translateY(30px);}to{opacity:1;transform:translateY(0);}}

.btn-back{
  display:inline-flex;
  align-items:center;
  gap:10px;
  padding:14px 28px;
  border-radius:16px;
  background:rgba(59,130,246,0.1);
  color:var(--accent-blue);
  font-weight:600;
  text-decoration:none;
  border:1px solid rgba(59,130,246,0.2);
  box-shadow:0 4px 24px rgba(0,0,0,0.2);
  transition:all 0.3s ease;
  margin-bottom:40px;
}
.btn-back:hover{
  background:var(--accent-blue);
  color:#fff;
  transform:translateY(-2px);
  box-shadow:0 8px 32px rgba(59,130,246,0.4);
}
.btn-back i{transition:transform 0.3s ease;}
.btn-back:hover i{transform:translateX(-4px);}

.container{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
  gap:32px;
}

.card{
  background:var(--card-bg);
  border-radius:24px;
  padding:36px 28px;
  text-decoration:none;
  border:1px solid var(--border-color);
  box-shadow:0 8px 32px rgba(0,0,0,0.3);
  transition:all 0.4s ease;
  position:relative;
  overflow:hidden;
  animation:fadeIn 0.6s ease forwards;
  opacity:0;
}
.card:nth-child(1){animation-delay:0.1s;--card-accent:var(--accent-blue);}
.card:nth-child(2){animation-delay:0.2s;--card-accent:var(--accent-cyan);}
.card:nth-child(3){animation-delay:0.3s;--card-accent:var(--accent-green);}
.card:nth-child(4){animation-delay:0.4s;--card-accent:var(--accent-purple);}
.card:nth-child(5){animation-delay:0.5s;--card-accent:var(--accent-red);}
@keyframes fadeIn{from{opacity:0;transform:translateY(30px);}to{opacity:1;transform:translateY(0);}}

.card:hover{transform:translateY(-8px);box-shadow:0 20px 60px rgba(0,0,0,0.5);border-color:var(--card-accent);}
.card::before{
  content:'';position:absolute;top:0;left:0;width:100%;height:4px;
  background:linear-gradient(90deg,transparent,var(--card-accent),transparent);
  opacity:0;transition:opacity 0.4s;
}
.card:hover::before{opacity:1;}

.card-icon{
  width:64px;height:64px;border-radius:18px;display:flex;
  align-items:center;justify-content:center;margin-bottom:24px;
  background:var(--card-accent);
  box-shadow:0 8px 24px rgba(0,0,0,0.3);
  transition:transform 0.4s ease;
}
.card:hover .card-icon{transform:scale(1.1) rotate(5deg);}
.card-icon i{color:#fff;font-size:28px;}

.card h2{font-size:24px;margin-bottom:10px;color:var(--text-primary);}
.card:hover h2{color:var(--card-accent);}
.card p{color:var(--text-secondary);font-size:15px;line-height:1.6;}

.card-arrow{
  position:absolute;bottom:24px;right:24px;width:40px;height:40px;
  border-radius:50%;background:rgba(255,255,255,0.05);
  display:flex;align-items:center;justify-content:center;
  opacity:0;transform:translateX(-10px);
  transition:all 0.3s ease;border:2px solid transparent;
}
.card:hover .card-arrow{opacity:1;transform:translateX(0);background:var(--card-accent);}
.card-arrow i{color:#fff;font-size:16px;}
.card-badge{
  position:absolute;top:20px;right:20px;
  padding:6px 12px;border-radius:20px;
  background:rgba(255,255,255,0.1);font-size:11px;
  font-weight:600;text-transform:uppercase;opacity:0;
  transform:translateY(-10px);transition:all 0.3s ease;
}
.card:hover .card-badge{opacity:1;transform:translateY(0);}
.stats-counter{
  display:flex;align-items:center;gap:8px;margin-top:16px;
  padding:12px;background:rgba(255,255,255,0.03);
  border-radius:12px;opacity:0;transform:translateY(10px);
  transition:all 0.3s ease;
}
.card:hover .stats-counter{opacity:1;transform:translateY(0);}
.stats-counter i{color:var(--card-accent);}
.stats-counter span{color:var(--text-secondary);font-size:13px;}

@media(max-width:768px){
  .header h1{font-size:36px;}
  .header p{font-size:16px;}
  .container{grid-template-columns:1fr;gap:20px;}
  .card{padding:28px 20px;}
}
</style>
</head>
<body>

<div class="floating-particles">
  <div class="particle"></div><div class="particle"></div><div class="particle"></div>
  <div class="particle"></div><div class="particle"></div><div class="particle"></div>
</div>

<div class="wrapper">
  <a href="../Dashboard/MainDashboard.php" class="btn-back">
    <i class="fas fa-arrow-left"></i> Back to Main Dashboard
  </a>

  <div class="header">
    <h1>Card Management</h1>
    <p>Manage creation, activation, and viewing of customer cards</p>
  </div>

  <div class="container">

    <a href="../Creation/CreateCard.php" class="card">
      <div class="card-icon"><i class="fas fa-credit-card"></i></div>
      <h2>Create Card</h2>
      <p>Create a new card for an account</p>
      <div class="card-badge">New</div>
      <div class="stats-counter"><i class="fas fa-clock"></i><span>Quick Setup</span></div>
      <div class="card-arrow"><i class="fas fa-arrow-right"></i></div>
    </a>

    <a href="../Fetch/Cards/viewAllCards.php" class="card">
      <div class="card-icon"><i class="fas fa-list"></i></div>
      <h2>Fetch All Cards</h2>
      <p>View all cards in the system</p>
      <div class="card-badge">Popular</div>
      <div class="stats-counter"><i class="fas fa-database"></i><span>Live Data</span></div>
      <div class="card-arrow"><i class="fas fa-arrow-right"></i></div>
    </a>

    <a href="../Fetch/Cards/getCardById.php" class="card">
      <div class="card-icon"><i class="fas fa-search"></i></div>
      <h2>Get Card By ID</h2>
      <p>Find specific card details quickly</p>
      <div class="card-badge">Fast</div>
      <div class="stats-counter"><i class="fas fa-bolt"></i><span>Instant Lookup</span></div>
      <div class="card-arrow"><i class="fas fa-arrow-right"></i></div>
    </a>

    <a href="../Update/ActiveCard.php" class="card">
      <div class="card-icon"><i class="fas fa-check-circle"></i></div>
      <h2>Activate Card</h2>
      <p>Set a card as active and ready for use</p>
      <div class="card-badge">Secure</div>
      <div class="stats-counter"><i class="fas fa-lock"></i><span>Authorized Only</span></div>
      <div class="card-arrow"><i class="fas fa-arrow-right"></i></div>
    </a>

    <a href="../Update/DisActiveCard.php" class="card">
      <div class="card-icon"><i class="fas fa-ban"></i></div>
      <h2>Deactivate Card</h2>
      <p>Disable a card temporarily or permanently</p>
      <div class="card-badge">Caution</div>
      <div class="stats-counter"><i class="fas fa-exclamation-triangle"></i><span>Restricted Use</span></div>
      <div class="card-arrow"><i class="fas fa-arrow-right"></i></div>
    </a>

  </div>
</div>

</body>
</html>
