<?php
session_start();
if(!isset($_SESSION['dashboard'])){
    echo "<div style='color:red; font-weight:bold;'>Access denied!</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Delete Account — FinTech CMS</title>
<style>
:root{
  --bg:#0a0e1a; --card:#0f1420; --muted:#8b92a8; --accent:#60a5fa;
  --success:#10b981; --danger:#ef4444; --warning:#f59e0b; --glass: rgba(255,255,255,0.03);
  font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
}
*{box-sizing:border-box;}

body{
  margin:0;
  min-height:100vh;
  background:linear-gradient(135deg, #0a0e1a 0%, #1a0f1f 50%, #0f1724 100%);
  color:#e6eef8;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:32px;
  position:relative;
  overflow:hidden;
}

body::before{
  content:'';
  position:absolute;
  width:600px;
  height:600px;
  background:radial-gradient(circle, rgba(239,68,68,0.08) 0%, transparent 70%);
  top:-200px;
  right:-200px;
  animation:float 20s ease-in-out infinite;
}

body::after{
  content:'';
  position:absolute;
  width:500px;
  height:500px;
  background:radial-gradient(circle, rgba(245,158,11,0.06) 0%, transparent 70%);
  bottom:-150px;
  left:-150px;
  animation:float 15s ease-in-out infinite reverse;
}

@keyframes float{
  0%, 100%{transform:translate(0,0) scale(1);}
  50%{transform:translate(30px, 30px) scale(1.05);}
}

.particles{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  pointer-events:none;
  z-index:0;
}

.particle{
  position:absolute;
  width:4px;
  height:4px;
  background:rgba(239,68,68,0.6);
  border-radius:50%;
  animation:rise 8s linear infinite;
}

@keyframes rise{
  0%{transform:translateY(100vh) scale(0); opacity:0;}
  10%{opacity:1;}
  90%{opacity:1;}
  100%{transform:translateY(-100vh) scale(1); opacity:0;}
}

.card{
  width:100%;
  max-width:580px;
  background:linear-gradient(145deg, rgba(21,27,43,0.8), rgba(15,20,32,0.9));
  backdrop-filter:blur(20px);
  border-radius:20px;
  padding:40px;
  box-shadow:0 20px 60px rgba(0,0,0,0.5), 0 0 1px rgba(255,255,255,0.1) inset;
  border:1px solid rgba(239,68,68,0.1);
  position:relative;
  z-index:1;
  animation:slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideUp{
  from{opacity:0; transform:translateY(40px);}
  to{opacity:1; transform:translateY(0);}
}

.card::before{
  content:'';
  position:absolute;
  top:0;
  left:0;
  right:0;
  height:3px;
  background:linear-gradient(90deg, transparent, var(--danger), transparent);
  border-radius:20px 20px 0 0;
  animation:shimmer 3s ease-in-out infinite;
}

@keyframes shimmer{
  0%, 100%{opacity:0.3;}
  50%{opacity:1;}
}

.emoji-header{
  display:flex;
  align-items:center;
  gap:12px;
  margin-bottom:8px;
}

.emoji-icon{
  font-size:32px;
  animation:warningPulse 2s ease-in-out infinite;
}

@keyframes warningPulse{
  0%, 100%{transform:scale(1);}
  50%{transform:scale(1.15); filter:drop-shadow(0 0 10px rgba(239,68,68,0.5));}
}

h1{
  margin:0;
  font-size:28px;
  font-weight:700;
  background:linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  background-clip:text;
  animation:fadeIn 0.8s ease-out 0.2s both;
}

.lead{
  margin:0 0 20px 0;
  color:var(--muted);
  font-size:15px;
  animation:fadeIn 0.8s ease-out 0.3s both;
}

.warning-box{
  background:rgba(239,68,68,0.1);
  border:1.5px solid rgba(239,68,68,0.3);
  border-left:4px solid var(--danger);
  border-radius:12px;
  padding:16px;
  margin-bottom:24px;
  animation:fadeIn 0.8s ease-out 0.4s both;
  position:relative;
  overflow:hidden;
}

.warning-box::before{
  content:'';
  position:absolute;
  top:0;
  left:-100%;
  width:100%;
  height:100%;
  background:linear-gradient(90deg, transparent, rgba(239,68,68,0.1), transparent);
  animation:warningShine 3s ease-in-out infinite;
}

@keyframes warningShine{
  0%{left:-100%;}
  50%{left:100%;}
  100%{left:100%;}
}

.warning-box-header{
  display:flex;
  align-items:center;
  gap:8px;
  font-weight:600;
  color:var(--danger);
  margin-bottom:8px;
  font-size:15px;
}

.warning-emoji{
  font-size:20px;
  animation:shake 1s ease-in-out infinite;
}

@keyframes shake{
  0%, 100%{transform:rotate(0deg);}
  25%{transform:rotate(-5deg);}
  75%{transform:rotate(5deg);}
}

.warning-text{
  color:rgba(239,68,68,0.9);
  font-size:14px;
  line-height:1.5;
}

@keyframes fadeIn{
  from{opacity:0; transform:translateY(10px);}
  to{opacity:1; transform:translateY(0);}
}

form{
  display:grid;
  gap:20px;
  animation:fadeIn 0.8s ease-out 0.5s both;
}

.input-group{
  position:relative;
}

label{
  display:flex;
  align-items:center;
  gap:6px;
  font-size:13px;
  font-weight:500;
  color:var(--muted);
  margin-bottom:8px;
  letter-spacing:0.3px;
  text-transform:uppercase;
}

.label-emoji{
  font-size:16px;
  animation:wiggle 3s ease-in-out infinite;
}

@keyframes wiggle{
  0%, 100%{transform:rotate(0deg);}
  25%{transform:rotate(-10deg);}
  75%{transform:rotate(10deg);}
}

input[type="text"]{
  width:100%;
  padding:14px 18px 14px 50px;
  border-radius:12px;
  border:1.5px solid rgba(239,68,68,0.2);
  background:rgba(239,68,68,0.03);
  color:#e6eef8;
  font-size:15px;
  outline:none;
  transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.input-wrapper{
  position:relative;
}

.input-emoji{
  position:absolute;
  left:16px;
  top:50%;
  transform:translateY(-50%);
  font-size:20px;
  pointer-events:none;
  transition:all 0.3s ease;
  z-index:1;
}

input[type="text"]:focus ~ .input-emoji{
  animation:pulse 0.6s ease-in-out;
}

@keyframes pulse{
  0%, 100%{transform:translateY(-50%) scale(1);}
  50%{transform:translateY(-50%) scale(1.3);}
}

input[type="text"]:focus{
  border-color:var(--danger);
  background:rgba(239,68,68,0.08);
  box-shadow:0 0 0 4px rgba(239,68,68,0.15), 0 8px 24px rgba(0,0,0,0.3);
  transform:translateY(-2px);
}

input[type="text"]::placeholder{
  color:rgba(139,146,168,0.5);
}

.field-error{
  color:var(--danger);
  font-size:13px;
  margin-top:6px;
  padding:8px 12px;
  background:rgba(239,68,68,0.08);
  border-radius:8px;
  border-left:3px solid var(--danger);
  animation:errorShake 0.4s ease-in-out;
  display:flex;
  align-items:center;
  gap:6px;
}

@keyframes errorShake{
  0%, 100%{transform:translateX(0);}
  25%{transform:translateX(-8px);}
  75%{transform:translateX(8px);}
}

.actions{
  display:flex;
  gap:12px;
  align-items:center;
  margin-top:8px;
  flex-wrap:wrap;
}

button, .btn-back{
  padding:12px 20px;
  border-radius:12px;
  font-weight:600;
  font-size:14px;
  cursor:pointer;
  transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border:none;
  position:relative;
  overflow:hidden;
  display:inline-flex;
  align-items:center;
  gap:8px;
}

button::before, .btn-back::before{
  content:'';
  position:absolute;
  top:50%;
  left:50%;
  width:0;
  height:0;
  border-radius:50%;
  background:rgba(255,255,255,0.2);
  transform:translate(-50%, -50%);
  transition:width 0.6s, height 0.6s;
}

button:active::before, .btn-back:active::before{
  width:300px;
  height:300px;
}

button.primary{
  background:linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  color:#fff;
  box-shadow:0 4px 16px rgba(239,68,68,0.3);
  position:relative;
  z-index:1;
}

button.primary:hover{
  transform:translateY(-2px) scale(1.02);
  box-shadow:0 8px 24px rgba(239,68,68,0.5);
}

button.primary:hover .btn-emoji{
  animation:spin 0.5s ease-in-out;
}

@keyframes spin{
  from{transform:rotate(0deg);}
  to{transform:rotate(360deg);}
}

button.primary:active{
  transform:translateY(0) scale(0.98);
}

button.ghost{
  background:rgba(255,255,255,0.03);
  border:1.5px solid rgba(255,255,255,0.08);
  color:var(--muted);
}

button.ghost:hover{
  background:rgba(255,255,255,0.06);
  border-color:rgba(255,255,255,0.12);
  color:#e6eef8;
  transform:translateY(-2px) scale(1.02);
}

button.ghost:hover .btn-emoji{
  animation:rotate360 0.6s ease-in-out;
}

@keyframes rotate360{
  from{transform:rotate(0deg);}
  to{transform:rotate(-360deg);}
}

.btn-back{
  background:linear-gradient(135deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.02) 100%);
  color:#e6eef8;
  text-decoration:none;
  border:1.5px solid rgba(255,255,255,0.08);
}

.btn-back:hover{
  border-color:var(--accent);
  color:var(--accent);
  transform:translateY(-2px) scale(1.02);
  box-shadow:0 6px 20px rgba(96,165,250,0.2);
}

.btn-back:hover .btn-emoji{
  animation:slideLeft 0.6s ease-in-out;
}

@keyframes slideLeft{
  0%, 100%{transform:translateX(0);}
  50%{transform:translateX(-6px);}
}

.message{
  padding:14px 18px;
  border-radius:12px;
  font-size:14px;
  margin-top:20px;
  animation:slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  display:flex;
  align-items:center;
  gap:10px;
}

@keyframes slideIn{
  from{opacity:0; transform:translateX(-20px);}
  to{opacity:1; transform:translateX(0);}
}

.message-emoji{
  font-size:20px;
  animation:popIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

@keyframes popIn{
  0%{transform:scale(0) rotate(-180deg);}
  100%{transform:scale(1) rotate(0deg);}
}

.message.success{
  background:rgba(16,185,129,0.1);
  color:var(--success);
  border:1.5px solid rgba(16,185,129,0.2);
  border-left:4px solid var(--success);
}

.message.error{
  background:rgba(239,68,68,0.08);
  color:var(--danger);
  border:1.5px solid rgba(239,68,68,0.15);
  border-left:4px solid var(--danger);
}

@media (max-width:620px){
  .card{padding:28px 24px;}
  h1{font-size:24px;}
  .actions{flex-direction:column; align-items:stretch;}
  .actions button, .actions .btn-back{width:100%; justify-content:center;}
}

.loading{
  display:inline-block;
  width:16px;
  height:16px;
  border:2px solid rgba(255,255,255,0.3);
  border-top-color:#fff;
  border-radius:50%;
  animation:spinLoader 0.6s linear infinite;
  margin-left:8px;
}

@keyframes spinLoader{
  to{transform:rotate(360deg);}
}
</style>
</head>
<body>

<div class="particles" id="particles"></div>

<div class="card">
<div class="emoji-header">
  <span class="emoji-icon">⚠️</span>
  <h1>Delete Account</h1>
</div>
<p class="lead">Enter Account ID to delete the account permanently. 🗑️</p>

<div class="warning-box">
  <div class="warning-box-header">
    <span class="warning-emoji">⚠️</span>
    <span>DANGER ZONE - PERMANENT ACTION</span>
  </div>
  <div class="warning-text">
    This action <strong>cannot be undone</strong>. Deleting an account will permanently remove all associated data, transactions, and cards. Please proceed with extreme caution! 🚨
  </div>
</div>

<form id="deleteAccountForm" novalidate>
  <div class="input-group">
    <label for="accountId">
      <span class="label-emoji">🆔</span>
      Account ID
    </label>
    <div class="input-wrapper">
      <input id="accountId" name="accountId" type="text" placeholder="e.g. ec22d8e5-51d4-46bc-84d3-eaf68aa991b5" required>
      <span class="input-emoji">🔑</span>
    </div>
    <div id="accountIdError" class="field-error" hidden></div>
  </div>

  <div class="actions">
    <button type="submit" class="primary">
      <span class="btn-emoji">🗑️</span>
      <span id="btnText">Delete Account</span>
    </button>
    <button type="button" class="ghost" id="resetBtn">
      <span class="btn-emoji">🔄</span>
      <span>Reset</span>
    </button>
    <a href="../Dashboard/dashboard.php" class="btn-back">
      <span class="btn-emoji">⬅️</span>
      <span>Back to Dashboard</span>
    </a>
  </div>
</form>

<div id="result"></div>
</div>

<script>
(function(){
  const form = document.getElementById('deleteAccountForm');
  const accountIdInput = document.getElementById('accountId');
  const accountIdError = document.getElementById('accountIdError');
  const result = document.getElementById('result');
  const resetBtn = document.getElementById('resetBtn');
  const btnText = document.getElementById('btnText');

  // Create floating particles
  function createParticles(){
    const container = document.getElementById('particles');
    for(let i = 0; i < 15; i++){
      const particle = document.createElement('div');
      particle.className = 'particle';
      particle.style.left = Math.random() * 100 + '%';
      particle.style.animationDelay = Math.random() * 8 + 's';
      particle.style.animationDuration = (Math.random() * 4 + 6) + 's';
      container.appendChild(particle);
    }
  }
  createParticles();

  function resetMessages(){
    accountIdError.hidden = true;
    accountIdError.textContent = '';
    result.innerHTML = '';
  }

  function validateAccountId(){
    const value = accountIdInput.value.trim();
    if(value === ''){
      accountIdError.innerHTML = '<span>⚠️</span><span>Account ID is required.</span>';
      accountIdError.hidden = false;
      return false;
    }
    return true;
  }

  // Add interactive input effects
  accountIdInput.addEventListener('input', function(){
    if(this.value.length > 0){
      this.style.borderColor = 'rgba(239,68,68,0.4)';
    } else {
      this.style.borderColor = 'rgba(239,68,68,0.2)';
    }
  });

  accountIdInput.addEventListener('focus', function(){
    this.parentElement.style.transform = 'scale(1.01)';
  });
  
  accountIdInput.addEventListener('blur', function(){
    this.parentElement.style.transform = 'scale(1)';
  });

  form.addEventListener('submit', function(e){
    e.preventDefault();
    resetMessages();
    if(!validateAccountId()) return;

    // Confirmation dialog
    const confirmed = confirm('⚠️ Are you ABSOLUTELY SURE you want to delete this account?\n\nThis action CANNOT be undone!\n\nAccount ID: ' + accountIdInput.value);
    if(!confirmed) return;

    const originalText = btnText.innerHTML;
    btnText.innerHTML = 'Deleting<span class="loading"></span>';

    fetch('../Imp/Account/deleteAccountImp.php', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      body: 'accountId=' + encodeURIComponent(accountIdInput.value)
    })
    .then(res => res.json())
    .then(data => {
      btnText.innerHTML = originalText;
      
      if(data.success){
        result.innerHTML = `<div class="message success"><span class="message-emoji">✅</span><span>Account deleted successfully!</span></div>`;
        form.reset();
        accountIdInput.style.borderColor = 'rgba(239,68,68,0.2)';
      } else {
        result.innerHTML = `<div class="message error"><span class="message-emoji">❌</span><span>${data.message}</span></div>`;
      }
    })
    .catch(err => { 
      btnText.innerHTML = originalText;
      result.innerHTML = '<div class="message error"><span class="message-emoji">❌</span><span>'+err+'</span></div>'; 
    });
  });

  resetBtn.addEventListener('click', function(){
    form.reset();
    resetMessages();
    accountIdInput.style.borderColor = 'rgba(239,68,68,0.2)';
    
    // Add fun reset animation
    const card = document.querySelector('.card');
    card.style.animation = 'none';
    setTimeout(() => {
      card.style.animation = 'slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
    }, 10);
  });

  // Add keyboard shortcuts
  document.addEventListener('keydown', function(e){
    if(e.ctrlKey && e.key === 'k'){
      e.preventDefault();
      accountIdInput.focus();
    }
  });
})();
</script>

</body>
</html>