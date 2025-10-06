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
<title>Deactivate Card — FinTech CMS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
/* ===== Base & Background ===== */
body {
  font-family: 'Inter', sans-serif;
  background: linear-gradient(135deg, #0f172a, #1e293b);
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
  color: #fff;
  overflow-x: hidden;
  perspective: 1000px;
}

/* Floating shapes for animation */
.shape {
  position: absolute;
  border-radius: 50%;
  opacity: 0.08;
  animation: float 20s infinite ease-in-out;
}
.shape1 { width: 120px; height: 120px; background: linear-gradient(135deg,#ef4444,#f87171); top:10%; left:5%; animation-delay:0s;}
.shape2 { width: 80px; height: 80px; background: linear-gradient(135deg,#facc15,#fbbf24); top:70%; left:80%; animation-delay:3s;}
.shape3 { width: 150px; height: 150px; background: linear-gradient(135deg,#ec4899,#f472b6); top:50%; left:40%; animation-delay:5s;}
@keyframes float { 0%,100% { transform: translateY(0) rotate(0deg);} 50% { transform: translateY(-20px) rotate(180deg);} }

/* Form container */
.form-box {
  background: rgba(255,255,255,0.05);
  backdrop-filter: blur(15px);
  border-radius: 24px;
  padding: 50px 40px;
  max-width: 400px;
  width: 100%;
  text-align: center;
  box-shadow: 0 12px 40px rgba(0,0,0,0.6);
  transform-style: preserve-3d;
  transition: transform 0.5s ease, box-shadow 0.5s ease;
}
.form-box:hover {
  transform: rotateY(8deg) rotateX(5deg);
  box-shadow: 0 25px 60px rgba(0,0,0,0.8);
}

/* Heading */
h2 {
  font-size: 26px;
  margin-bottom: 30px;
  background: linear-gradient(135deg,#ef4444,#f87171,#fbbf24);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: glowText 2.5s ease-in-out infinite alternate;
}
@keyframes glowText {
  0%{filter: drop-shadow(0 0 2px #ef4444);}
  100%{filter: drop-shadow(0 0 10px #fbbf24);}
}

/* Inputs */
input[type=text] {
  width: 100%;
  padding: 14px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.2);
  background: rgba(255,255,255,0.05);
  color: #fff;
  font-size: 16px;
  margin-bottom: 20px;
  outline: none;
  transition: 0.3s;
}
input[type=text]:focus {
  border-color: #f87171;
  box-shadow: 0 4px 12px rgba(248,113,113,0.5);
}

/* Button */
input[type=submit] {
  padding: 14px;
  border-radius: 12px;
  border: none;
  width: 100%;
  font-weight: 700;
  font-size: 16px;
  color: #021024;
  background: linear-gradient(90deg,#ef4444,#f87171);
  cursor: pointer;
  transition: all 0.3s ease;
}
input[type=submit]:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(239,68,68,0.5);
}

/* Back button */
.back-btn {
  display: inline-block;
  margin-top: 20px;
  color: #fbbf24;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}
.back-btn:hover {
  transform: translateY(-2px);
  text-shadow: 0 2px 6px rgba(0,0,0,0.5);
}

/* Media */
@media (max-width: 420px){
  .form-box { width: 90%; padding: 36px 24px; }
}
</style>
</head>
<body>

<div class="shape shape1"></div>
<div class="shape shape2"></div>
<div class="shape shape3"></div>

<div class="form-box">
  <h2>🛑 Deactivate Card</h2>
  <form action="../Imp/Cards/DisActivateCardImp.php" method="POST">
    <input type="text" name="cardNumber" placeholder="Enter Card Number" required>
    <input type="submit" value="Deactivate Card">
  </form>
  <a href='../Dashboard/CardDashboard.php' class='back-btn'>← Back to Dashboard</a>
</div>

</body>
</html>
