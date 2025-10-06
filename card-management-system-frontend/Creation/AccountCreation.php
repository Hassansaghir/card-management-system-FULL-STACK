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
<title>Create Account — FinTech CMS</title>
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

.floating-shapes{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  pointer-events:none;
  z-index:0;
  overflow:hidden;
}

.shape{
  position:absolute;
  opacity:0.1;
  animation:float 20s infinite ease-in-out;
}

.shape-1{
  width:80px;
  height:80px;
  background:linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
  border-radius:50%;
  top:20%;
  left:10%;
  animation-delay:0s;
}

.shape-2{
  width:60px;
  height:60px;
  background:linear-gradient(135deg, var(--accent-green), var(--accent-blue));
  border-radius:30%;
  top:60%;
  left:80%;
  animation-delay:2s;
}

.shape-3{
  width:100px;
  height:100px;
  background:linear-gradient(135deg, var(--accent-purple), var(--accent-green));
  border-radius:20%;
  top:70%;
  left:15%;
  animation-delay:4s;
}

@keyframes float{
  0%, 100%{
    transform:translateY(0) rotate(0deg);
  }
  50%{
    transform:translateY(-30px) rotate(180deg);
  }
}

.wrapper{
  max-width:600px;
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

.form-card{
  background:var(--card-bg);
  border-radius:28px;
  padding:48px 40px;
  border:1px solid var(--border-color);
  box-shadow:0 12px 40px rgba(0,0,0,0.4);
  animation:fadeInUp 0.8s ease;
  position:relative;
  overflow:hidden;
}

.form-card::before{
  content:'';
  position:absolute;
  top:0;
  left:0;
  right:0;
  height:4px;
  background:linear-gradient(90deg, var(--accent-blue), var(--accent-green), var(--accent-purple));
  animation:shimmer 3s linear infinite;
}

@keyframes shimmer{
  0%{transform:translateX(-100%);}
  100%{transform:translateX(100%);}
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

.form-group{
  margin-bottom:28px;
  position:relative;
}

.form-group label{
  display:block;
  margin-bottom:10px;
  color:var(--text-primary);
  font-weight:600;
  font-size:14px;
  text-transform:uppercase;
  letter-spacing:0.5px;
}

.input-wrapper{
  position:relative;
}

.input-icon{
  position:absolute;
  left:18px;
  top:50%;
  transform:translateY(-50%);
  color:var(--text-secondary);
  font-size:18px;
  pointer-events:none;
  transition:all 0.3s ease;
  z-index:2;
}

.form-group input[type="number"]{
  width:100%;
  padding:18px 18px 18px 54px;
  font-size:18px;
  font-family:'Inter', sans-serif;
  background:rgba(255,255,255,0.04);
  border:2px solid var(--border-color);
  border-radius:16px;
  color:var(--text-primary);
  transition:all 0.3s ease;
  outline:none;
  font-weight:600;
}

.form-group input::placeholder{
  color:var(--text-secondary);
  opacity:0.6;
  font-weight:400;
}

.form-group input:focus{
  border-color:var(--accent-blue);
  background:rgba(59, 130, 246, 0.08);
  box-shadow:0 0 0 4px rgba(59, 130, 246, 0.15);
}

.form-group input:focus ~ .input-icon{
  color:var(--accent-blue);
  transform:translateY(-50%) scale(1.1);
}

.hint{
  margin-top:8px;
  font-size:13px;
  color:var(--text-secondary);
  display:flex;
  align-items:center;
  gap:8px;
}

.hint i{
  color:var(--accent-blue);
  font-size:14px;
}

.hint code{
  background:rgba(255,255,255,0.05);
  padding:2px 6px;
  border-radius:4px;
  font-family:monospace;
  color:var(--accent-green);
}

.field-error{
  color:var(--error);
  font-size:13px;
  margin-top:8px;
  display:flex;
  align-items:center;
  gap:6px;
  font-weight:500;
}

.field-error i{
  font-size:14px;
}

.actions{
  display:flex;
  gap:12px;
  flex-wrap:wrap;
  margin-top:32px;
}

.btn-primary{
  flex:1;
  min-width:180px;
  padding:18px 24px;
  font-size:16px;
  font-weight:700;
  background:linear-gradient(135deg, var(--accent-blue), var(--accent-green));
  color:#fff;
  border:none;
  border-radius:16px;
  cursor:pointer;
  transition:all 0.3s ease;
  text-transform:uppercase;
  letter-spacing:1px;
  box-shadow:0 8px 28px rgba(16, 185, 129, 0.4);
  position:relative;
  overflow:hidden;
}

.btn-primary::before{
  content:'';
  position:absolute;
  top:50%;
  left:50%;
  width:0;
  height:0;
  border-radius:50%;
  background:rgba(255,255,255,0.3);
  transform:translate(-50%, -50%);
  transition:width 0.6s, height 0.6s;
}

.btn-primary:hover::before{
  width:400px;
  height:400px;
}

.btn-primary:hover{
  transform:translateY(-3px);
  box-shadow:0 14px 40px rgba(16, 185, 129, 0.6);
}

.btn-primary span{
  position:relative;
  z-index:1;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:10px;
}

.btn-ghost{
  padding:18px 24px;
  background:rgba(255,255,255,0.04);
  border:2px solid var(--border-color);
  color:var(--text-secondary);
  border-radius:16px;
  font-weight:600;
  cursor:pointer;
  transition:all 0.3s ease;
  font-size:15px;
}

.btn-ghost:hover{
  background:rgba(255,255,255,0.08);
  border-color:var(--accent-blue);
  color:var(--text-primary);
  transform:translateY(-2px);
}

#result{
  margin-top:24px;
}

.message{
  padding:16px 20px;
  border-radius:14px;
  font-weight:500;
  display:flex;
  align-items:center;
  gap:12px;
  animation:slideIn 0.4s ease;
}

@keyframes slideIn{
  from{
    opacity:0;
    transform:translateY(-10px);
  }
  to{
    opacity:1;
    transform:translateY(0);
  }
}

.message.success{
  background:rgba(16, 185, 129, 0.1);
  border:1px solid rgba(16, 185, 129, 0.3);
  color:var(--success);
}

.message.error{
  background:rgba(239, 68, 68, 0.1);
  border:1px solid rgba(239, 68, 68, 0.3);
  color:var(--error);
}

.message i{
  font-size:20px;
}

footer{
  margin-top:32px;
  text-align:center;
  color:var(--text-secondary);
  font-size:13px;
}

footer code{
  background:rgba(255,255,255,0.05);
  padding:2px 6px;
  border-radius:4px;
  font-family:monospace;
  color:var(--accent-blue);
}

@media(max-width:768px){
  .wrapper{
    padding:20px;
  }
  .header h1{
    font-size:30px;
  }
  .form-card{
    padding:32px 24px;
  }
  .actions{
    flex-direction:column;
  }
  .btn-primary{
    min-width:100%;
  }
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
  <a href="../Dashboard/dashboard.php" class="btn-back">
    <i class="fas fa-arrow-left"></i> Back to Dashboard
  </a>

  <div class="header">
    <div class="header-icon">
      <i class="fas fa-user-plus"></i>
    </div>
    <h1>Create Account</h1>
    <p>Set up a new customer account with initial balance</p>
  </div>

  <div class="form-card">
    <form id="createAccountForm" novalidate>
      <div class="form-group">
        <label for="balance">Initial Balance</label>
        <div class="input-wrapper">
          <input id="balance" 
                 name="balance" 
                 type="number" 
                 inputmode="decimal" 
                 step="0.01" 
                 min="0" 
                 placeholder="e.g., 1000.00" 
                 required>
          <i class="fas fa-dollar-sign input-icon"></i>
        </div>
        <div class="hint">
          <i class="fas fa-info-circle"></i>
          <span>Enter a non-negative decimal value. Examples: <code>0.00</code>, <code>150.75</code>, <code>5000.00</code></span>
        </div>
        <div id="balanceError" class="field-error" hidden></div>
      </div>

      <div class="actions">
        <button type="submit" class="btn-primary">
          <span>
            <i class="fas fa-check-circle"></i>
            Create Account
          </span>
        </button>
        <button type="button" class="btn-ghost" id="resetBtn">
          <i class="fas fa-redo"></i>
          Reset
        </button>
      </div>
    </form>

    <div id="result"></div>

    <footer>
      FinTech CMS — Client-side form for <code>CreateAccountRequest</code>
    </footer>
  </div>
</div>

<script>
(function(){
  const form = document.getElementById('createAccountForm');
  const balanceInput = document.getElementById('balance');
  const balanceError = document.getElementById('balanceError');
  const result = document.getElementById('result');
  const resetBtn = document.getElementById('resetBtn');

  function resetMessages(){
    balanceError.hidden = true;
    balanceError.textContent = '';
    result.innerHTML = '';
  }

  function validateBalance(){
    const value = balanceInput.value.trim();
    if(value === ''){
      balanceError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Balance is required.';
      balanceError.hidden = false;
      return false;
    }
    const num = parseFloat(value);
    if(isNaN(num) || num < 0){
      balanceError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Balance must be a non-negative number.';
      balanceError.hidden = false;
      return false;
    }
    return true;
  }

  form.addEventListener('submit', function(e){
    e.preventDefault();
    resetMessages();
    if(!validateBalance()) return;

    // Send data via fetch to PHP backend
    fetch('../Imp/Account/createAccountImp.php', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      body: 'balance=' + encodeURIComponent(balanceInput.value)
    })
    .then(res => res.text())
    .then(html => { result.innerHTML = html; })
    .catch(err => { 
      result.innerHTML = '<div class="message error"><i class="fas fa-times-circle"></i>' + err + '</div>'; 
    });
  });

  resetBtn.addEventListener('click', function(){
    form.reset();
    resetMessages();
  });

})();
</script>

</body>
</html>