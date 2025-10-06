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
<title>Create Card — FinTech CMS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ===== THEME ===== */
:root {
  --bg-gradient: linear-gradient(135deg, #0a0e27, #0f172a);
  --card-bg: #1e293b;
  --primary: #3b82f6;
  --success: #10b981;
  --accent: #8b5cf6;
  --text-light: #f1f5f9;
  --text-muted: #94a3b8;
  --border: rgba(255, 255, 255, 0.08);
  --radius: 16px;
}

/* ===== BASE ===== */
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'Inter', sans-serif;
  background: var(--bg-gradient);
  color: var(--text-light);
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 15px;
  position: relative;
  overflow: hidden;
}

/* ===== BACKGROUND ANIMATION ===== */
.floating-shape {
  position: absolute;
  border-radius: 50%;
  opacity: 0.12;
  filter: blur(60px);
  animation: float 10s ease-in-out infinite;
}
.shape-blue {
  background: var(--primary);
  width: 160px; height: 160px;
  top: 10%; left: 15%;
}
.shape-green {
  background: var(--success);
  width: 120px; height: 120px;
  bottom: 10%; right: 20%;
  animation-delay: 3s;
}
.shape-purple {
  background: var(--accent);
  width: 200px; height: 200px;
  top: 50%; left: 70%;
  animation-delay: 6s;
}
@keyframes float {
  0%,100% { transform: translateY(0); }
  50% { transform: translateY(-30px); }
}

/* ===== CARD CONTAINER ===== */
.card-wrapper {
  position: relative;
  z-index: 10;
  background: var(--card-bg);
  padding: 50px 40px;
  border-radius: 24px;
  border: 1px solid var(--border);
  box-shadow: 0 12px 40px rgba(0,0,0,0.4);
  width: 100%;
  max-width: 500px;
  animation: fadeInUp 0.8s ease forwards;
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(40px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ===== HEADER ===== */
.card-header {
  text-align: center;
  margin-bottom: 40px;
}
.card-header h1 {
  font-size: 28px;
  background: linear-gradient(90deg, var(--primary), var(--success));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 10px;
  animation: glow 3s ease-in-out infinite alternate;
}
@keyframes glow {
  from { text-shadow: 0 0 8px rgba(59,130,246,0.6); }
  to { text-shadow: 0 0 18px rgba(16,185,129,0.8); }
}
.card-header i {
  font-size: 48px;
  color: var(--primary);
  margin-bottom: 10px;
  animation: spinIcon 6s linear infinite;
}
@keyframes spinIcon {
  from { transform: rotateY(0deg); }
  to { transform: rotateY(360deg); }
}

/* ===== FORM ===== */
.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 22px;
}
.form-group label {
  font-weight: 600;
  color: var(--text-muted);
  font-size: 15px;
}
.form-group input {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 12px 16px;
  font-size: 15px;
  color: var(--text-light);
  transition: border-color 0.3s, box-shadow 0.3s;
}
.form-group input:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 8px rgba(59,130,246,0.4);
}

/* ===== BUTTON ===== */
.btn-primary {
  width: 100%;
  background: linear-gradient(90deg, var(--primary), var(--success));
  border: none;
  border-radius: var(--radius);
  padding: 14px;
  color: #fff;
  font-weight: 600;
  font-size: 16px;
  cursor: pointer;
  transition: transform 0.3s, box-shadow 0.3s;
}
.btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(16,185,129,0.4);
}

/* ===== MESSAGE BOX ===== */
.message {
  margin-top: 18px;
  border-radius: var(--radius);
  padding: 12px 16px;
  font-size: 14px;
  text-align: center;
}
.message.error {
  background: rgba(239,68,68,0.15);
  color: #f87171;
  border: 1px solid rgba(239,68,68,0.3);
}
.message.success {
  background: rgba(34,197,94,0.15);
  color: #34d399;
  border: 1px solid rgba(34,197,94,0.3);
}

/* ===== BACK LINK ===== */
.back-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: var(--text-muted);
  margin-top: 24px;
  text-decoration: none;
  transition: color 0.3s, transform 0.3s;
  font-weight: 500;
}
.back-link:hover {
  color: var(--primary);
  transform: translateX(-4px);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 480px) {
  .card-wrapper {
    padding: 40px 25px;
  }
  .card-header h1 {
    font-size: 24px;
  }
}
</style>
</head>
<body>

<!-- Background shapes -->
<div class="floating-shape shape-blue"></div>
<div class="floating-shape shape-green"></div>
<div class="floating-shape shape-purple"></div>

<div class="card-wrapper">
  <div class="card-header">
    <i class="fas fa-credit-card"></i>
    <h1>Create Card</h1>
    <p style="color:var(--text-muted);font-size:14px;">Add a new card linked to an existing account</p>
  </div>

  <form id="createCardForm" novalidate>
    <div class="form-group">
      <label for="account_id">Account ID</label>
      <input type="text" id="account_id" name="account_id" placeholder="Enter Account ID" required>
    </div>
    <div class="form-group">
      <label for="expiry">Expiry Date</label>
      <input type="date" id="expiry" name="expiry" required>
    </div>
    <button type="submit" class="btn-primary">Create Card</button>
  </form>

  <div id="result"></div>

  <a href="../Dashboard/CardDashboard.php" class="back-link">
    <i class="fas fa-arrow-left"></i> Back to Dashboard
  </a>
</div>

<script>
const form = document.getElementById('createCardForm');
const result = document.getElementById('result');

form.addEventListener('submit', function(e){
  e.preventDefault();
  result.innerHTML = '';

  const account_id = document.getElementById('account_id').value.trim();
  const expiry = document.getElementById('expiry').value;

  if(!account_id || !expiry){
    result.innerHTML = '<div class="message error">All fields are required.</div>';
    return;
  }

  fetch('../Imp/Cards/createCardImp.php', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body: `account_id=${encodeURIComponent(account_id)}&expiry=${encodeURIComponent(expiry)}`
  })
  .then(res => res.text())
  .then(html => { result.innerHTML = html; })
  .catch(err => { result.innerHTML = '<div class="message error">'+err+'</div>'; });
});
</script>

</body>
</html>
