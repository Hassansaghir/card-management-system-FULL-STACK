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
<title>All Cards — FinTech CMS</title>
<style>
:root{
  --bg:#0f1724; --accent:#60a5fa; --muted:#9aa4b2; --success:#10b981; --danger:#ef4444;
  font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
}
body{
  margin:0;min-height:100vh;background:linear-gradient(180deg,var(--bg),#071022);
  color:#e6eef8;font-family:inherit;padding:24px;
}
.container{max-width:1200px;margin:0 auto;}
h1{text-align:center;color:var(--accent);}
.cards-wrapper{
  margin-top:30px;
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
  gap:20px;
}
.card{
  background:linear-gradient(135deg,#3b82f6,#06b6d4);
  border-radius:18px;
  padding:20px;
  box-shadow:0 8px 20px rgba(0,0,0,0.5);
  color:#fff;
  position:relative;
  height:200px;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  transition:transform 0.2s;
}
.card:hover{transform:translateY(-6px);}
.card-chip{width:50px;height:35px;}
.card-chip img{width:100%;height:100%;object-fit:contain;}
.card-number{font-size:20px;letter-spacing:2px;font-weight:600;margin-top:10px;}
.card-footer{display:flex;justify-content:space-between;font-size:14px;opacity:0.9;}
.card-logo{
  width:60px;height:60px;position:absolute;bottom:15px;right:15px;
}
.message.error{color:var(--danger);text-align:center;margin-top:20px;}
.back-btn{
  margin-top:24px;display:inline-block;padding:10px 16px;border-radius:10px;
  background:var(--accent);color:#021024;text-decoration:none;font-weight:600;
}
.back-btn:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(0,0,0,0.4);}
</style>
</head>
<body>

<div class="container">
  <h1>All Cards</h1>
  <div id="cardsContainer" class="cards-wrapper"></div>
  <a href="../../Dashboard/CardDashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
  fetch("../../Imp/Cards/viewAllCardsImp.php")
    .then(res => res.text())
    .then(html => {
      document.getElementById("cardsContainer").innerHTML = html;
    })
    .catch(err => {
      document.getElementById("cardsContainer").innerHTML = "<div class='message error'>"+err+"</div>";
    });
});
</script>

</body>
</html>
