<?php
session_start();
if(!isset($_SESSION['dashboard'])){
    echo "<div style='color:red; font-weight:bold; text-align:center;'>Access denied!</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Get Card By ID — FinTech CMS</title>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
*{
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body{
  font-family: 'Poppins', sans-serif;
  height: 100vh;
  background: radial-gradient(circle at 20% 20%, #0f172a, #1e293b 70%);
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  color: #fff;
}

/* Floating glowing particles background */
body::before {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: url('https://www.transparenttextures.com/patterns/dark-mosaic.png');
  opacity: 0.05;
  animation: moveBG 60s linear infinite;
}
@keyframes moveBG {
  from { background-position: 0 0; }
  to { background-position: 1000px 1000px; }
}

/* Animated Card Container */
.form-box{
  position: relative;
  background: rgba(255,255,255,0.08);
  backdrop-filter: blur(18px);
  padding: 40px 36px;
  width: 400px;
  border-radius: 18px;
  box-shadow: 0 12px 40px rgba(0,0,0,0.6);
  text-align: center;
  overflow: hidden;
  animation: floatBox 3s ease-in-out infinite alternate;
  transition: transform 0.3s ease;
}
@keyframes floatBox {
  0% { transform: translateY(0px); }
  100% { transform: translateY(-8px); }
}

.form-box::before {
  content: '';
  position: absolute;
  width: 200%;
  height: 200%;
  top: -50%;
  left: -50%;
  background: conic-gradient(from 180deg, rgba(96,165,250,0.2), transparent, rgba(59,130,246,0.2), transparent);
  animation: rotate 6s linear infinite;
  z-index: 0;
}
@keyframes rotate {
  to { transform: rotate(360deg); }
}
.form-box > * {
  position: relative;
  z-index: 1;
}

h2{
  font-size: 26px;
  color: #60a5fa;
  margin-bottom: 24px;
  letter-spacing: 1px;
  text-shadow: 0 0 8px rgba(96,165,250,0.6);
}

/* Floating Label Input Field */
.input-group{
  position: relative;
  margin-bottom: 28px;
  text-align: left;
}

.input-group input{
  width: 100%;
  padding: 14px 12px;
  border: 1px solid rgba(255,255,255,0.25);
  border-radius: 10px;
  background: rgba(255,255,255,0.05);
  color: #fff;
  font-size: 15px;
  outline: none;
  transition: 0.3s ease;
}

.input-group label{
  position: absolute;
  left: 14px;
  top: 14px;
  color: #94a3b8;
  font-size: 14px;
  pointer-events: none;
  transition: 0.3s ease;
}

.input-group input:focus,
.input-group input:not(:placeholder-shown){
  border-color: #60a5fa;
  box-shadow: 0 0 12px rgba(96,165,250,0.4);
}

.input-group input:focus + label,
.input-group input:not(:placeholder-shown) + label{
  top: -10px;
  left: 10px;
  font-size: 12px;
  background: rgba(15,23,42,0.8);
  padding: 0 6px;
  color: #60a5fa;
}

/* Fancy Button */
button{
  width: 100%;
  padding: 14px;
  border-radius: 12px;
  border: none;
  font-weight: 700;
  font-size: 16px;
  color: #021024;
  background: linear-gradient(90deg, #60a5fa, #3b82f6);
  cursor: pointer;
  transition: all 0.25s ease;
  box-shadow: 0 0 12px rgba(96,165,250,0.4);
}

button:hover{
  transform: translateY(-3px);
  box-shadow: 0 0 20px rgba(96,165,250,0.8);
}

/* Back Button */
.back-btn{
  display: inline-block;
  margin-top: 18px;
  color: #93c5fd;
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s ease;
}
.back-btn:hover{
  color: #fff;
  text-shadow: 0 0 10px rgba(147,197,253,0.6);
  transform: translateY(-2px);
}

@media (max-width: 420px){
  .form-box{
    width: 90%;
    padding: 30px 24px;
  }
}
</style>
</head>
<body>

<div class="form-box">
  <h2>💳 Get Card by ID</h2>
  <form action="../../Imp/Cards/getCardByIdImp.php" method="POST">
    <div class="input-group">
      <input type="text" name="cardNumber" id="cardNumber" placeholder=" " required>
      <label for="cardNumber">Card Number</label>
    </div>
    <button type="submit">Fetch Card</button>
  </form>
  <a href="../../Dashboard/CardDashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

</body>
</html>
