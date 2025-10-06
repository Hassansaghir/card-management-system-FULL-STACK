<?php
session_start();
if(!isset($_SESSION['dashboard'])){
    echo "<div class='message error'>Access denied!</div>";
    exit;
}

$url = "http://localhost:9090/v1/cards";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

$json = json_decode($response,true);

echo "
<style>
body{
  margin:0;
  font-family:'Segoe UI', sans-serif;
  background:#0f172a;
  color:#fff;
}
.cards-container{
  display:grid;
  grid-template-columns: repeat(3, 1fr); /* exactly 3 cards per row */
  gap:24px;
  padding:40px;
  justify-items:center; /* center each card inside its grid cell */
}
.card{
  position:relative;
  width:340px;
  height:200px;
  border-radius:18px;
  background:linear-gradient(135deg,#1e3c72,#2a5298);
  color:#fff;
  padding:24px;
  box-shadow:0 8px 24px rgba(0,0,0,0.4);
  overflow:hidden;
  transition:transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover{
  transform:translateY(-6px);
  box-shadow:0 12px 28px rgba(0,0,0,0.6);
}
.card:before{
  content:'';
  position:absolute;
  top:-30%;
  left:-30%;
  width:160%;
  height:160%;
  background:radial-gradient(circle at top left,rgba(255,255,255,0.15),transparent 70%);
  transform:rotate(25deg);
}
.card-chip img{
  width:55px;
  margin-bottom:15px;
}
.card-number{
  font-size:22px;
  letter-spacing:3px;
  margin:15px 0;
  font-weight:bold;
}
.account-id{
  font-size:12px;
  opacity:0.85;
  margin-bottom:10px;
}
.card-footer{
  display:flex;
  justify-content:space-between;
  font-size:14px;
  font-weight:500;
}
.card-logo{
  position:absolute;
  bottom:15px;
  right:20px;
  width:50px;
  height:40px;
  opacity:0.9;
}
.status-active{ color:#10b981; font-weight:bold; }
.status-inactive{ color:#ef4444; font-weight:bold; }
.message.error{
  text-align:center;
  color:#ef4444;
  padding:20px;
}
</style>
";


if($httpCode == 200 && isset($json['data']) && count($json['data']) > 0){
    echo "<div class='cards-container'>";
    foreach($json['data'] as $card){
        $statusClass = strtolower($card['status']) == 'active' ? 'status-active' : 'status-inactive';
        echo "
        <div class='card'>
          <div class='card-chip'>
            <img src='../../images/OIP-removebg-preview.png' alt='chip'>
          </div>
          <span class='$statusClass'>".htmlspecialchars($card['status'])."</span>
          <div class='card-number'>".chunk_split(htmlspecialchars($card['cardNumber']),4,' ')."</div>
          <div class='account-id'>Account ID: ".htmlspecialchars($card['account_id'])."</div>
          <div class='card-footer'>
            <span>EXP: ".htmlspecialchars($card['expiry'])."</span>
          </div>
          <img src='https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg' alt='Logo' class='card-logo'>
        </div>
        ";
    }
    echo "</div>";
}else{
    echo "<div class='message error'>No cards found.</div>";
}
?>
