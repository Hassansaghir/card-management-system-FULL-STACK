<?php 
session_start();
$_SESSION['dashboard'] = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FinTech CMS Dashboard</title>
  <style>
    :root {
      --bg: #0f1724;
      --card: #131b2e;
      --accent: #3b82f6;
      --muted: #9aa4b2;
      --glass: rgba(255, 255, 255, 0.04);
      --radius: 16px;
      font-family: "Inter", sans-serif;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: linear-gradient(180deg, var(--bg), #071022);
      min-height: 100vh;
      color: #e6eef8;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      padding: 40px 20px;
    }

    h1 {
      font-size: 28px;
      margin-bottom: 40px;
      color: var(--accent);
      text-align: center;
    }

    .dashboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 24px;
      width: 100%;
      max-width: 1000px;
    }

    .card {
      background: var(--card);
      border-radius: var(--radius);
      padding: 28px;
      text-align: center;
      border: 1px solid var(--glass);
      box-shadow: 0 6px 20px rgba(2, 6, 23, 0.6);
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 30px rgba(2, 6, 23, 0.9);
    }

    .icon {
      font-size: 40px;
      margin-bottom: 14px;
      color: var(--accent);
    }

    .card h2 {
      font-size: 20px;
      margin-bottom: 10px;
      color: var(--accent);
    }

    .card p {
      font-size: 14px;
      color: var(--muted);
      margin-bottom: 18px;
    }

    .btn {
      display: inline-block;
      background: linear-gradient(90deg, var(--accent), #60a5fa);
      color: #021024;
      padding: 10px 18px;
      border-radius: 10px;
      font-weight: 600;
      text-decoration: none;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    }
  </style>
</head>
<body>

  <h1>Card Management System Dashboard</h1>

  <div class="dashboard">
    <div class="card" onclick="navigate('dashboard.php')">
      <div class="icon">👤</div>
      <h2>Accounts</h2>
      <p>Manage all user accounts including creation, updates, and deletion.</p>
      <a href="dashboard.php" class="btn">Go to Accounts</a>
    </div>

    <div class="card" onclick="navigate('CardDashboard.php')">
      <div class="icon">💳</div>
      <h2>Cards</h2>
      <p>View and manage all debit/credit cards linked to accounts.</p>
      <a href="CardDashboard.php" class="btn">Go to Cards</a>
    </div>

    <div class="card" onclick="navigate('../Dashboard/TransactionDashboard.php')">
      <div class="icon">📑</div>
      <h2>Transactions</h2>
      <p>Monitor all account transactions with details and history.</p>
      <a href="TransactionDashboard.php" class="btn">Go to Transactions</a>
    </div>
  </div>

  <script>
    function navigate(url) {
      window.location.href = url;
    }
  </script>
</body>
</html>
