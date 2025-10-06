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
<title>Create Transaction — FinTech CMS</title>
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
  --accent-red:#ef4444;
  --text-primary:#f1f5f9;
  --text-secondary:#94a3b8;
  --border-color:rgba(148, 163, 184, 0.1);
  --error:#ef4444;
  --success:#10b981;
}

*{box-sizing:border-box;margin:0;padding:0;}
body{
  font-family:'Inter',sans-serif;
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
    radial-gradient(circle at 80% 70%, rgba(239,68,68,0.15) 0%, transparent 50%);
  pointer-events:none;
  z-index:0;
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
  transition:all 0.3s ease;
  margin-bottom:40px;
}
.btn-back:hover{
  background:var(--accent-blue);
  color:#fff;
  transform:translateY(-2px);
  box-shadow:0 8px 32px rgba(59, 130, 246, 0.4);
}
.btn-back i{font-size:16px;transition:transform 0.3s ease;}
.btn-back:hover i{transform:translateX(-4px);}

.header{text-align:center;margin-bottom:48px;}
.header-icon{
  width:90px;height:90px;margin:0 auto 24px;
  background:linear-gradient(135deg, var(--accent-blue), var(--accent-red));
  border-radius:24px;
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 12px 40px rgba(59, 130, 246, 0.4);
  position:relative;animation:pulse 2s ease-in-out infinite;
}
@keyframes pulse{0%,100%{transform:scale(1);}50%{transform:scale(1.05);}}
.header-icon i{font-size:42px;color:#fff;}
.header h1{
  font-size:38px;font-weight:700;
  background: linear-gradient(135deg, #3b82f6 0%, #ef4444 100%);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  margin-bottom:12px;letter-spacing:-0.5px;
}
.header p{color:var(--text-secondary);font-size:17px;font-weight:500;}

.form-card{
  background:var(--card-bg);
  border-radius:28px;
  padding:48px 40px;
  border:1px solid var(--border-color);
  box-shadow:0 12px 40px rgba(0,0,0,0.4);
  position:relative;overflow:hidden;
}
.form-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:4px;
  background:linear-gradient(90deg, var(--accent-blue), var(--accent-red));
  animation:shimmer 3s linear infinite;
}
@keyframes shimmer{0%{transform:translateX(-100%);}100%{transform:translateX(100%);}}

.form-group{margin-bottom:28px;position:relative;}
.form-group label{
  display:block;margin-bottom:10px;color:var(--text-primary);
  font-weight:600;font-size:14px;text-transform:uppercase;letter-spacing:0.5px;
}
.input-wrapper{position:relative;}
.input-icon{
  position:absolute;left:18px;top:50%;transform:translateY(-50%);
  color:var(--text-secondary);font-size:18px;pointer-events:none;z-index:2;
}

.form-group input, .form-group select{
  width:100%;padding:18px 18px 18px 54px;
  font-size:18px;background:rgba(255,255,255,0.04);
  border:2px solid var(--border-color);border-radius:16px;color:var(--text-primary);
  transition:all 0.3s ease;font-weight:600;outline:none;
}
.form-group input:focus, .form-group select:focus{
  border-color:var(--accent-blue);background:rgba(59, 130, 246, 0.08);
  box-shadow:0 0 0 4px rgba(59,130,246,0.15);
}
.form-group input::placeholder{color:var(--text-secondary);opacity:0.6;font-weight:400;}

.hint{margin-top:8px;font-size:13px;color:var(--text-secondary);display:flex;align-items:center;gap:8px;}
.hint i{color:var(--accent-blue);font-size:14px;}
.field-error{color:var(--error);font-size:13px;margin-top:8px;display:flex;align-items:center;gap:6px;font-weight:500;}
.field-error i{font-size:14px;}

.actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:32px;}
.btn-primary{
  flex:1;min-width:180px;padding:18px 24px;font-size:16px;font-weight:700;
  background:linear-gradient(135deg, var(--accent-blue), var(--accent-red));
  color:#fff;border:none;border-radius:16px;cursor:pointer;transition:all 0.3s ease;
  text-transform:uppercase;letter-spacing:1px;box-shadow:0 8px 28px rgba(16,185,129,0.4);position:relative;overflow:hidden;
}
.btn-primary::before{
  content:'';position:absolute;top:50%;left:50%;width:0;height:0;border-radius:50%;
  background:rgba(255,255,255,0.3);transform:translate(-50%,-50%);
  transition:width 0.6s,height 0.6s;
}
.btn-primary:hover::before{width:400px;height:400px;}
.btn-primary:hover{transform:translateY(-3px);box-shadow:0 14px 40px rgba(16,185,129,0.6);}
.btn-primary span{position:relative;z-index:1;display:flex;align-items:center;justify-content:center;gap:10px;}

.btn-ghost{
  padding:18px 24px;background:rgba(255,255,255,0.04);border:2px solid var(--border-color);
  color:var(--text-secondary);border-radius:16px;font-weight:600;cursor:pointer;transition:all 0.3s ease;font-size:15px;
}
.btn-ghost:hover{background:rgba(255,255,255,0.08);border-color:var(--accent-blue);color:var(--text-primary);transform:translateY(-2px);}

#result{margin-top:24px;}
</style>
</head>
<body>

<div class="wrapper">
  <a href="../Dashboard/TransactionDashboard.php" class="btn-back">
    <i class="fas fa-arrow-left"></i> Back to Transaction Dashboard
  </a>

  <div class="header">
    <div class="header-icon">
      <i class="fas fa-money-bill-wave"></i>
    </div>
    <h1>Create Transaction</h1>
    <p>Add a new debit or credit transaction</p>
  </div>

  <div class="form-card">
    <form id="createTransactionForm" novalidate>
      <div class="form-group">
        <label for="amount">Transaction Amount</label>
        <div class="input-wrapper">
          <input type="number" id="amount" name="transactionAmount" step="0.01" min="0" placeholder="e.g., 100.50" required>
          <i class="fas fa-dollar-sign input-icon"></i>
        </div>
      </div>

      <div class="form-group">
        <label for="type">Transaction Type</label>
        <div class="input-wrapper">
          <select id="type" name="transactionType" required>
            <option value="">Select Type</option>
            <option value="D">Debit</option>
            <option value="C">Credit</option>
          </select>
          <i class="fas fa-exchange-alt input-icon"></i>
        </div>
      </div>

      <div class="form-group">
        <label for="card">Card Number</label>
        <div class="input-wrapper">
          <input type="text" id="card" name="cardNumber" placeholder="Enter Card Number" required>
          <i class="fas fa-credit-card input-icon"></i>
        </div>
      </div>

      <div class="actions">
        <button type="submit" class="btn-primary">
          <span><i class="fas fa-check-circle"></i> Create Transaction</span>
        </button>
        <button type="button" class="btn-ghost" id="resetBtn">
          <i class="fas fa-redo"></i> Reset
        </button>
      </div>
    </form>

    <div id="result"></div>
  </div>
</div>

<script>
(function(){
  const form = document.getElementById('createTransactionForm');
  const amountInput = document.getElementById('amount');
  const typeSelect = document.getElementById('type');
  const cardInput = document.getElementById('card');
  const result = document.getElementById('result');
  const resetBtn = document.getElementById('resetBtn');

  function resetMessages(){ result.innerHTML=''; }

  function validate(){
    if(amountInput.value.trim()==='' || parseFloat(amountInput.value)<0){
      result.innerHTML='<div style="color:#ef4444;font-weight:600;">Amount must be non-negative</div>';
      return false;
    }
    if(typeSelect.value===''){ result.innerHTML='<div style="color:#ef4444;font-weight:600;">Select transaction type</div>'; return false; }
    if(cardInput.value.trim()===''){ result.innerHTML='<div style="color:#ef4444;font-weight:600;">Card number is required</div>'; return false; }
    return true;
  }

  form.addEventListener('submit', function(e){
    e.preventDefault();
    resetMessages();
    if(!validate()) return;

    fetch('../Imp/Transaction/CreateTransactionImp.php',{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body: new URLSearchParams({
        transactionAmount:amountInput.value,
        transactionType:typeSelect.value,
        cardNumber:cardInput.value
      })
    })
    .then(res=>res.text())
    .then(html=>{ result.innerHTML = html; })
    .catch(err=>{ result.innerHTML='<div style="color:#ef4444;font-weight:600;">'+err+'</div>'; });
  });

  resetBtn.addEventListener('click', ()=>{ form.reset(); resetMessages(); });
})();
</script>

</body>
</html>
