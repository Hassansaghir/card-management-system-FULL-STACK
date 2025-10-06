<?php
session_start();
if(!isset($_SESSION['dashboard']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo "Access denied!";
    exit;
}

$accountId = $_POST['accountId'] ?? '';
if(empty($accountId)){
    echo "<div class='message error'><span class='message-emoji'>⚠️</span><span>Account ID is required.</span></div>";
    exit;
}

$url = "http://localhost:9090/v1/accounts/$accountId";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json"
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if($error){
    echo "<div class='message error'><span class='message-emoji'>❌</span><span>cURL Error: ".htmlspecialchars($error)."</span></div>";
    exit;
}

$json = json_decode($response, true);

if($httpCode == 200 && isset($json['data'])){
    $acc = $json['data'];
    $statusEmoji = $acc['status'] === 'active' ? '✅' : ($acc['status'] === 'inactive' ? '⏸️' : '🔴');
    $cardsCount = count($acc['cards']);
    $cardsEmoji = $cardsCount > 0 ? '💳' : '📭';
    
    echo "
    <div class='account-card success-animation'>
        <h2>
            <span class='account-header-emoji'>✨</span>
            Account Found
        </h2>
        <ul>
            <li>
                <span class='item-emoji'>🆔</span>
                <div class='item-content'>
                    <strong>ID:</strong> <span class='item-value'>{$acc['id']}</span>
                </div>
            </li>
            <li>
                <span class='item-emoji'>{$statusEmoji}</span>
                <div class='item-content'>
                    <strong>Status:</strong> <span class='item-value status-".strtolower($acc['status'])."'>{$acc['status']}</span>
                </div>
            </li>
            <li>
                <span class='item-emoji'>💰</span>
                <div class='item-content'>
                    <strong>Balance:</strong> <span class='item-value balance'>$".number_format($acc['balance'],2)."</span>
                </div>
            </li>
            <li>
                <span class='item-emoji'>{$cardsEmoji}</span>
                <div class='item-content'>
                    <strong>Cards:</strong> <span class='item-value'>{$cardsCount}</span>
                </div>
            </li>
            <li class='view-cards-item'>
                <span class='item-emoji'>👁️</span>
                <div class='item-content'>
                    <strong>See Cards:</strong>
                    <a href='../../Fetch/Cards/viewCards.php?accountId={$acc['id']}' class='view-cards-btn'>
                        <span class='btn-emoji'>💳</span>
                        <span>View Cards</span>
                        <span class='arrow'>→</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
    
    <style>
    .account-card{
        margin-top:24px;
        padding:24px;
        background:linear-gradient(135deg, rgba(96,165,250,0.08) 0%, rgba(59,130,246,0.06) 100%);
        border:1.5px solid rgba(96,165,250,0.2);
        border-radius:16px;
        box-shadow:0 8px 32px rgba(96,165,250,0.15);
        color:#e6eef8;
        font-size:15px;
        position:relative;
        overflow:hidden;
    }
    
    .account-card::before{
        content:'';
        position:absolute;
        top:-50%;
        right:-50%;
        width:200%;
        height:200%;
        background:radial-gradient(circle, rgba(96,165,250,0.1) 0%, transparent 50%);
        animation:rotate 10s linear infinite;
    }
    
    .account-card::after{
        content:'';
        position:absolute;
        top:0;
        left:-100%;
        width:100%;
        height:100%;
        background:linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        animation:shine 3s ease-in-out infinite;
    }
    
    @keyframes rotate{
        from{transform:rotate(0deg);}
        to{transform:rotate(360deg);}
    }
    
    @keyframes shine{
        0%{left:-100%;}
        50%{left:100%;}
        100%{left:100%;}
    }
    
    .success-animation{
        animation:zoomIn 0.5s cubic-bezier(0.16, 1, 0.3, 1), glow 2s ease-in-out infinite alternate;
    }
    
    @keyframes zoomIn{
        from{opacity:0; transform:scale(0.9) rotateX(10deg);}
        to{opacity:1; transform:scale(1) rotateX(0);}
    }
    
    @keyframes glow{
        from{box-shadow:0 8px 32px rgba(96,165,250,0.15);}
        to{box-shadow:0 8px 32px rgba(96,165,250,0.3), 0 0 60px rgba(96,165,250,0.1);}
    }
    
    .account-card h2{
        margin:0 0 20px 0;
        font-size:22px;
        color:#60a5fa;
        position:relative;
        z-index:1;
        display:flex;
        align-items:center;
        gap:10px;
        padding-bottom:12px;
        border-bottom:2px solid rgba(96,165,250,0.2);
    }
    
    .account-header-emoji{
        font-size:28px;
        animation:spin 2s linear infinite, pulse 1.5s ease-in-out infinite;
    }
    
    @keyframes spin{
        from{transform:rotate(0deg);}
        to{transform:rotate(360deg);}
    }
    
    @keyframes pulse{
        0%, 100%{transform:scale(1);}
        50%{transform:scale(1.2);}
    }
    
    .account-card ul{
        list-style:none;
        padding:0;
        margin:0;
        position:relative;
        z-index:1;
        display:grid;
        gap:10px;
    }
    
    .account-card li{
        padding:14px 16px;
        background:rgba(255,255,255,0.04);
        border-radius:12px;
        border:1px solid rgba(255,255,255,0.06);
        transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display:flex;
        align-items:center;
        gap:12px;
        cursor:pointer;
        position:relative;
        overflow:hidden;
    }
    
    .account-card li::before{
        content:'';
        position:absolute;
        left:0;
        top:0;
        height:100%;
        width:3px;
        background:linear-gradient(180deg, var(--accent), transparent);
        transform:scaleY(0);
        transition:transform 0.3s ease;
    }
    
    .account-card li:hover::before{
        transform:scaleY(1);
    }
    
    .account-card li:nth-child(1){animation:fadeInUp 0.4s ease-out 0.1s both;}
    .account-card li:nth-child(2){animation:fadeInUp 0.4s ease-out 0.15s both;}
    .account-card li:nth-child(3){animation:fadeInUp 0.4s ease-out 0.2s both;}
    .account-card li:nth-child(4){animation:fadeInUp 0.4s ease-out 0.25s both;}
    .account-card li:nth-child(5){animation:fadeInUp 0.4s ease-out 0.3s both;}
    
    @keyframes fadeInUp{
        from{opacity:0; transform:translateY(20px);}
        to{opacity:1; transform:translateY(0);}
    }
    
    .account-card li:hover{
        background:rgba(96,165,250,0.12);
        border-color:rgba(96,165,250,0.4);
        transform:translateX(8px) scale(1.02);
        box-shadow:0 4px 20px rgba(96,165,250,0.25);
    }
    
    .account-card li:hover .item-emoji{
        animation:bounce 0.6s ease-in-out;
    }
    
    @keyframes bounce{
        0%, 100%{transform:translateY(0) scale(1);}
        25%{transform:translateY(-8px) scale(1.1);}
        50%{transform:translateY(0) scale(1.05);}
        75%{transform:translateY(-4px) scale(1.1);}
    }
    
    .item-emoji{
        font-size:22px;
        min-width:28px;
        display:flex;
        align-items:center;
        justify-content:center;
        transition:all 0.3s ease;
    }
    
    .item-content{
        flex:1;
        display:flex;
        align-items:center;
        gap:8px;
        flex-wrap:wrap;
    }
    
    .account-card li strong{
        color:var(--accent);
        font-weight:600;
        font-size:13px;
        text-transform:uppercase;
        letter-spacing:0.5px;
    }
    
    .item-value{
        color:#e6eef8;
        font-weight:500;
        font-family:'Courier New', monospace;
        padding:4px 8px;
        background:rgba(255,255,255,0.05);
        border-radius:6px;
        transition:all 0.3s ease;
    }
    
    .account-card li:hover .item-value{
        background:rgba(96,165,250,0.15);
        transform:scale(1.05);
    }
    
    .item-value.balance{
        color:#10b981;
        font-size:16px;
        font-weight:700;
        text-shadow:0 0 10px rgba(16,185,129,0.3);
    }
    
    .item-value.status-active{
        color:#10b981;
        text-transform:uppercase;
    }
    
    .item-value.status-inactive{
        color:#f59e0b;
        text-transform:uppercase;
    }
    
    .view-cards-item{
        background:rgba(96,165,250,0.08)!important;
        border-color:rgba(96,165,250,0.3)!important;
    }
    
    .view-cards-btn{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:10px 18px;
        background:linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
        color:#0a0e1a;
        border-radius:10px;
        text-decoration:none;
        font-weight:700;
        font-size:13px;
        transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow:0 4px 12px rgba(96,165,250,0.3);
        position:relative;
        overflow:hidden;
    }
    
    .view-cards-btn::before{
        content:'';
        position:absolute;
        top:0;
        left:-100%;
        width:100%;
        height:100%;
        background:linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition:left 0.5s ease;
    }
    
    .view-cards-btn:hover::before{
        left:100%;
    }
    
    .view-cards-btn:hover{
        transform:translateY(-3px) scale(1.05);
        box-shadow:0 8px 24px rgba(96,165,250,0.5);
    }
    
    .view-cards-btn:active{
        transform:translateY(-1px) scale(1.02);
    }
    
    .view-cards-btn .arrow{
        transition:transform 0.3s ease;
        font-size:16px;
    }
    
    .view-cards-btn:hover .arrow{
        transform:translateX(4px);
        animation:arrowBounce 0.6s ease-in-out infinite;
    }
    
    @keyframes arrowBounce{
        0%, 100%{transform:translateX(4px);}
        50%{transform:translateX(8px);}
    }
    
    .view-cards-btn .btn-emoji{
        font-size:16px;
        animation:cardFlip 3s ease-in-out infinite;
    }
    
    @keyframes cardFlip{
        0%, 100%{transform:rotateY(0);}
        50%{transform:rotateY(180deg);}
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
        font-size:22px;
        animation:popIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    @keyframes popIn{
        0%{transform:scale(0) rotate(-180deg);}
        100%{transform:scale(1) rotate(0deg);}
    }
    
    .message.success{
        background:rgba(16,185,129,0.1);
        color:#10b981;
        border:1.5px solid rgba(16,185,129,0.2);
        border-left:4px solid #10b981;
    }
    
    .message.error{
        background:rgba(239,68,68,0.08);
        color:#ef4444;
        border:1.5px solid rgba(239,68,68,0.15);
        border-left:4px solid #ef4444;
        animation:shake 0.5s ease-in-out;
    }
    
    @keyframes shake{
        0%, 100%{transform:translateX(0);}
        25%{transform:translateX(-10px);}
        75%{transform:translateX(10px);}
    }
    
    @media (max-width:620px){
        .account-card{padding:20px;}
        .account-card h2{font-size:18px;}
        .item-content{flex-direction:column; align-items:flex-start; gap:6px;}
        .view-cards-btn{width:100%; justify-content:center;}
    }
    </style>
    ";
}else{
    echo "<div class='message error'><span class='message-emoji'>😢</span><span>Account not found or invalid ID.</span></div>";
}
?>