<?php
session_start();
if(!isset($_SESSION['dashboard']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo "<div class='message error'>Access denied!</div>";
    exit;
}

$cardNumber = $_POST['cardNumber'] ?? '';
if(empty($cardNumber)){
    echo "<div class='message error'>Card number is required.</div>";
    exit;
}

// API endpoint to deactivate card
$url = "http://localhost:9090/v1/cards/deactivate/".urlencode($cardNumber);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // PUT request
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json"]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deactivate Card Result — FinTech CMS</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
/* ===== Base & Background ===== */
body {
  font-family: 'Inter', sans-serif;
  background: linear-gradient(135deg, #1a1a2e, #0f172a);
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
  color: #fff;
  overflow-x: hidden;
  perspective: 1000px;
}

/* Floating shapes */
.shape {
  position: absolute;
  border-radius: 50%;
  opacity: 0.06;
  animation: float 20s infinite ease-in-out;
}
.shape1 { width: 120px; height: 120px; background: linear-gradient(135deg,#fca5a5,#f87171); top:10%; left:5%; animation-delay:0s;}
.shape2 { width: 80px; height: 80px; background: linear-gradient(135deg,#fcd34d,#fbbf24); top:70%; left:80%; animation-delay:3s;}
.shape3 { width: 150px; height: 150px; background: linear-gradient(135deg,#fb7185,#f472b6); top:50%; left:40%; animation-delay:5s;}
@keyframes float { 0%,100% { transform: translateY(0) rotate(0deg);} 50% { transform: translateY(-20px) rotate(180deg);} }

/* Card container */
.card-container {
  background: rgba(255,255,255,0.04);
  backdrop-filter: blur(12px);
  border-radius: 24px;
  padding: 50px 40px;
  max-width: 450px;
  width: 100%;
  text-align: center;
  box-shadow: 0 12px 40px rgba(0,0,0,0.6);
  transform-style: preserve-3d;
  transition: transform 0.5s ease, box-shadow 0.5s ease;
}
.card-container:hover {
  transform: rotateY(8deg) rotateX(4deg);
  box-shadow: 0 25px 60px rgba(0,0,0,0.7);
}

/* Heading */
.card-container h2 {
  font-size: 28px;
  margin-bottom: 30px;
  background: linear-gradient(135deg,#f87171,#fb7185,#fca5a5);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: glowText 2s ease-in-out infinite alternate;
}
@keyframes glowText {
  0%{filter: drop-shadow(0 0 2px #f87171);}
  100%{filter: drop-shadow(0 0 8px #fca5a5);}
}

/* Message Box */
.message {
  padding: 24px 20px;
  border-radius: 18px;
  font-size: 16px;
  margin-bottom: 20px;
  transform: translateY(-20px);
  opacity: 0;
  animation: fadeInUp 0.8s forwards;
}
.message.success {
  background: rgba(251,146,146,0.15);
  border: 1px solid #f87171;
  color: #f87171;
}
.message.error {
  background: rgba(251,147,147,0.12);
  border: 1px solid #fb7185;
  color: #fb7185;
}
@keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }

/* Card Info */
.card-info {
  font-size: 18px;
  margin: 12px 0;
  font-weight: 600;
  letter-spacing: 2px;
  background: linear-gradient(135deg,#f87171,#fb7185,#fca5a5);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: neonPulse 2s infinite alternate;
}
@keyframes neonPulse {
  0% { text-shadow: 0 0 4px #fca5a5, 0 0 8px #fb7185; color: #fb7185; }
  50% { text-shadow: 0 0 6px #f87171, 0 0 12px #fb7185; color: #f87171; }
  100% { text-shadow: 0 0 4px #fca5a5, 0 0 8px #fb7185; color: #fb7185; }
}

/* Buttons */
.back-btn {
  display: inline-block;
  margin: 12px 8px 0;
  padding: 12px 24px;
  border-radius: 12px;
  background: linear-gradient(90deg,#fb7185,#f87171);
  color: #fff;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 6px 20px rgba(0,0,0,0.4);
}
.back-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 28px rgba(0,0,0,0.7);
}

/* Card number */
.card-number {
  font-size: 20px;
  letter-spacing: 3px;
  font-weight: 700;
  margin-top: 12px;
}

</style>
</head>
<body>

<div class="shape shape1"></div>
<div class="shape shape2"></div>
<div class="shape shape3"></div>

<div class="card-container">
  <h2>🛑 Deactivate Card Result</h2>

<?php
if($error){
    echo "<div class='message error'>cURL Error: ".htmlspecialchars($error)."</div>";
} elseif($httpCode == 200){
    $json = json_decode($response,true);
    if(isset($json['data'])){
        $card = $json['data'];
        echo "<div class='message success'>Card Deactivated Successfully!</div>";
        echo "<div class='card-info'>Card Number: <span class='card-number'>".chunk_split(htmlspecialchars($cardNumber),4,' ')."</span></div>";
        echo "<div class='card-info'>Status: ".htmlspecialchars($card['status'])."</div>";
    } else {
        echo "<div class='message error'>Unexpected response: ".htmlspecialchars($response)."</div>";
    }
} else {
    echo "<div class='message error'>Failed to deactivate card. Response: ".htmlspecialchars($response)."</div>";
}
?>

<a href='../../Update/DisActiveCard.php' class='back-btn'>← Deactivate Another Card</a>
<a href='../../Dashboard/CardDashboard.php' class='back-btn'>← Back to Dashboard</a>
</div>

</body>
</html>
