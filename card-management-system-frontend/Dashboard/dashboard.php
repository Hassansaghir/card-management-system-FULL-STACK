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
<title>FinTech CMS Dashboard</title>
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
    radial-gradient(circle at 80% 70%, rgba(139, 92, 246, 0.15) 0%, transparent 50%);
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
  background:rgba(59, 130, 246, 0.3);
  border-radius:50%;
  animation:float 20s infinite ease-in-out;
}

.particle:nth-child(1){left:10%; animation-delay:0s; animation-duration:15s;}
.particle:nth-child(2){left:20%; animation-delay:2s; animation-duration:18s;}
.particle:nth-child(3){left:30%; animation-delay:4s; animation-duration:20s;}
.particle:nth-child(4){left:40%; animation-delay:1s; animation-duration:16s;}
.particle:nth-child(5){left:50%; animation-delay:3s; animation-duration:19s;}
.particle:nth-child(6){left:60%; animation-delay:5s; animation-duration:17s;}
.particle:nth-child(7){left:70%; animation-delay:2.5s; animation-duration:21s;}
.particle:nth-child(8){left:80%; animation-delay:4.5s; animation-duration:15s;}
.particle:nth-child(9){left:90%; animation-delay:1.5s; animation-duration:18s;}

@keyframes float{
  0%, 100%{
    transform:translateY(100vh) scale(0);
    opacity:0;
  }
  10%{
    opacity:1;
    transform:translateY(90vh) scale(1);
  }
  90%{
    opacity:1;
    transform:translateY(10vh) scale(1);
  }
  100%{
    transform:translateY(0) scale(0);
    opacity:0;
  }
}

.wrapper{
  max-width:1400px;
  margin:0 auto;
  position:relative;
  z-index:1;
}

.header{
  text-align:center;
  margin-bottom:60px;
}

.header h1{
  font-size:48px;
  font-weight:700;
  background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  background-clip:text;
  margin-bottom:12px;
  letter-spacing:-1px;
  animation:fadeInDown 0.8s ease;
}

.header p{
  color:var(--text-secondary);
  font-size:18px;
  font-weight:500;
  animation:fadeInUp 0.8s ease;
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

.container{
  display:grid;
  grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));
  gap:32px;
}

.card{
  background:var(--card-bg);
  border-radius:24px;
  padding:36px 28px;
  cursor:pointer;
  border:1px solid var(--border-color);
  box-shadow:0 8px 32px rgba(0,0,0,0.3);
  transition:all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position:relative;
  overflow:hidden;
  text-decoration:none;
  display:block;
  animation:fadeIn 0.6s ease forwards;
  opacity:0;
}

.card:nth-child(1){animation-delay:0.1s;}
.card:nth-child(2){animation-delay:0.2s;}
.card:nth-child(3){animation-delay:0.3s;}
.card:nth-child(4){animation-delay:0.4s;}
.card:nth-child(5){animation-delay:0.5s;}

@keyframes fadeIn{
  from{
    opacity:0;
    transform:translateY(30px);
  }
  to{
    opacity:1;
    transform:translateY(0);
  }
}

.card::before{
  content:'';
  position:absolute;
  top:0;
  left:0;
  width:100%;
  height:4px;
  background:linear-gradient(90deg, transparent, var(--card-accent), transparent);
  opacity:0;
  transition:opacity 0.4s ease;
}

.card:hover::before{
  opacity:1;
}

.card::after{
  content:'';
  position:absolute;
  bottom:-100%;
  right:-100%;
  width:300px;
  height:300px;
  background:radial-gradient(circle, var(--card-accent) 0%, transparent 70%);
  opacity:0.1;
  transition:all 0.6s ease;
}

.card:hover::after{
  bottom:-50%;
  right:-50%;
}

.card:hover{
  transform:translateY(-8px);
  box-shadow:0 20px 60px rgba(0,0,0,0.5);
  border-color:var(--card-accent);
}

.card-icon{
  width:64px;
  height:64px;
  border-radius:18px;
  display:flex;
  align-items:center;
  justify-content:center;
  margin-bottom:24px;
  background:var(--card-accent);
  box-shadow:0 8px 24px rgba(0,0,0,0.3);
  transition:all 0.4s ease;
  position:relative;
}

.card-icon::before{
  content:'';
  position:absolute;
  inset:-2px;
  border-radius:18px;
  background:linear-gradient(45deg, var(--card-accent), transparent);
  opacity:0;
  transition:opacity 0.4s ease;
  animation:rotate 3s linear infinite;
}

@keyframes rotate{
  from{transform:rotate(0deg);}
  to{transform:rotate(360deg);}
}

.card:hover .card-icon::before{
  opacity:0.5;
}

.card:hover .card-icon{
  transform:scale(1.1) rotate(5deg);
  box-shadow:0 12px 32px rgba(0,0,0,0.4);
}

.card-icon i{
  font-size:28px;
  color:#fff;
  z-index:1;
  position:relative;
}

.card h2{
  font-size:24px;
  font-weight:700;
  color:var(--text-primary);
  margin-bottom:10px;
  transition:color 0.3s ease;
}

.card:hover h2{
  color:var(--card-accent);
}

.card p{
  color:var(--text-secondary);
  font-size:15px;
  line-height:1.6;
  font-weight:500;
}

.card-arrow{
  position:absolute;
  bottom:24px;
  right:24px;
  width:40px;
  height:40px;
  border-radius:50%;
  background:rgba(255,255,255,0.05);
  display:flex;
  align-items:center;
  justify-content:center;
  opacity:0;
  transform:translateX(-10px);
  transition:all 0.3s ease;
  border:2px solid transparent;
}

.card:hover .card-arrow{
  opacity:1;
  transform:translateX(0);
  background:var(--card-accent);
  border-color:rgba(255,255,255,0.2);
}

.card-arrow i{
  font-size:16px;
  color:var(--text-secondary);
  transition:color 0.3s ease;
}

.card:hover .card-arrow i{
  color:#fff;
}

.card-badge{
  position:absolute;
  top:20px;
  right:20px;
  padding:6px 12px;
  border-radius:20px;
  background:rgba(255,255,255,0.1);
  backdrop-filter:blur(10px);
  font-size:11px;
  font-weight:600;
  text-transform:uppercase;
  letter-spacing:1px;
  opacity:0;
  transform:translateY(-10px);
  transition:all 0.3s ease;
}

.card:hover .card-badge{
  opacity:1;
  transform:translateY(0);
}

.stats-counter{
  display:flex;
  align-items:center;
  gap:8px;
  margin-top:16px;
  padding:12px;
  background:rgba(255,255,255,0.03);
  border-radius:12px;
  opacity:0;
  transform:translateY(10px);
  transition:all 0.3s ease;
}

.card:hover .stats-counter{
  opacity:1;
  transform:translateY(0);
}

.stats-counter i{
  color:var(--card-accent);
  font-size:16px;
}

.stats-counter span{
  color:var(--text-secondary);
  font-size:13px;
  font-weight:500;
}

.card:nth-child(1){--card-accent:var(--accent-blue);}
.card:nth-child(2){--card-accent:var(--accent-cyan);}
.card:nth-child(3){--card-accent:var(--accent-green);}
.card:nth-child(4){--card-accent:var(--accent-purple);}
.card:nth-child(5){--card-accent:var(--accent-red);}

@media(max-width:768px){
  .header h1{font-size:36px;}
  .header p{font-size:16px;}
  .container{
    grid-template-columns:1fr;
    gap:20px;
  }
  .card{padding:28px 20px;}
}
</style>
</head>
<body>

<div class="floating-particles">
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
  <div class="particle"></div>
</div>

<div class="wrapper">
  <a href="../Dashboard/MainDashboard.php" class="btn-back">
    <i class="fas fa-arrow-left"></i> Back to Main Dashboard
  </a>

  <div class="header">
    <h1>Account Management</h1>
    <p>Manage customer accounts and financial operations</p>
  </div>

  <div class="container">
    <a href="../Creation/AccountCreation.php" class="card">
      <div class="card-icon">
        <i class="fas fa-user-plus"></i>
      </div>
      <h2>Create Account</h2>
      <p>Add a new customer account with initial balance and details</p>
      <div class="card-badge">New</div>
      <div class="stats-counter">
        <i class="fas fa-clock"></i>
        <span>Quick Setup</span>
      </div>
      <div class="card-arrow">
        <i class="fas fa-arrow-right"></i>
      </div>
    </a>

    <a href="../Fetch/Account/fetchAllAccounts.php" class="card">
      <div class="card-icon">
        <i class="fas fa-users"></i>
      </div>
      <h2>All Accounts</h2>
      <p>View and manage all customer accounts in the system</p>
      <div class="card-badge">Popular</div>
      <div class="stats-counter">
        <i class="fas fa-chart-line"></i>
        <span>Live Data</span>
      </div>
      <div class="card-arrow">
        <i class="fas fa-arrow-right"></i>
      </div>
    </a>

    <a href="../Fetch/Account/GetAccountById.php" class="card">
      <div class="card-icon">
        <i class="fas fa-search"></i>
      </div>
      <h2>Find Account</h2>
      <p>Search and view specific account details by ID</p>
      <div class="card-badge">Fast</div>
      <div class="stats-counter">
        <i class="fas fa-bolt"></i>
        <span>Instant Results</span>
      </div>
      <div class="card-arrow">
        <i class="fas fa-arrow-right"></i>
      </div>
    </a>

    <a href="../Update/updateAccount.php" class="card">
      <div class="card-icon">
        <i class="fas fa-edit"></i>
      </div>
      <h2>Update Account</h2>
      <p>Modify account balance and update information</p>
      <div class="card-badge">Secure</div>
      <div class="stats-counter">
        <i class="fas fa-shield-alt"></i>
        <span>Protected</span>
      </div>
      <div class="card-arrow">
        <i class="fas fa-arrow-right"></i>
      </div>
    </a>

    <a href="../Delete/AccountDelete.php" class="card">
      <div class="card-icon">
        <i class="fas fa-trash-alt"></i>
      </div>
      <h2>Delete Account</h2>
      <p>Permanently remove an account from the system</p>
      <div class="card-badge">Caution</div>
      <div class="stats-counter">
        <i class="fas fa-exclamation-triangle"></i>
        <span>Permanent Action</span>
      </div>
      <div class="card-arrow">
        <i class="fas fa-arrow-right"></i>
      </div>
    </a>
  </div>
</div>

</body>
</html>