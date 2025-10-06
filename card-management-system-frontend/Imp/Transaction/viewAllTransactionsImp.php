<?php
// Spring Boot API endpoint
$url = "http://localhost:9090/v1/transactions"; 

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
    echo "<div class='message error'><i class='fas fa-times-circle'></i> cURL Error: ".htmlspecialchars($error)."</div>";
} elseif($httpCode == 200){
    $transactions = json_decode($response, true);

    if(is_array($transactions) && count($transactions) > 0){
        echo "<table class='transactions-table'>";
        echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Card Number</th>
                    <th>Created At</th>
                    <th>Updated Balance</th>
                    <th>Main Balance</th>
                </tr>
              </thead>";
        echo "<tbody>";
        foreach($transactions as $tx){
            $typeBadge = $tx['transactionType'] === 'C' 
                         ? "<span class='badge credit'>Credit</span>" 
                         : "<span class='badge debit'>Debit</span>";
            echo "<tr>
                    <td>".htmlspecialchars($tx['id'])."</td>
                    <td>$".number_format($tx['transactionAmount'], 2)."</td>
                    <td>$typeBadge</td>
                    <td>".htmlspecialchars($tx['cardNumber'])."</td>
                    <td>".htmlspecialchars($tx['createdAt'])."</td>
                    <td>$".number_format($tx['balance'], 2)."</td>
                     <td>$".number_format($tx['oldBalance'], 2)."</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='message warning'><i class='fas fa-exclamation-circle'></i> No transactions found.</div>";
    }
} else {
    echo "<div class='message error'><i class='fas fa-times-circle'></i> Failed to load transactions. Response: ".htmlspecialchars($response)."</div>";
}
?>

<style>
.transactions-table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
.transactions-table th, .transactions-table td{
    padding:12px 15px;
    border-bottom:1px solid rgba(255,255,255,0.1);
    text-align:left;
    font-size:15px;
}
.transactions-table th{
    background: rgba(15,23,42,0.8);
    color: #3b82f6;
    font-weight:600;
    position: sticky;
    top:0;
    z-index:1;
}
.transactions-table tr:hover{
    background: rgba(59,130,246,0.1);
    transition:0.3s;
}
.transactions-table td{
    color:#f1f5f9;
}
.badge{
    padding:4px 10px;
    border-radius:12px;
    font-size:13px;
    font-weight:600;
    color:#fff;
    display:inline-block;
    text-align:center;
}
.credit{
    background:#10b981;
}
.debit{
    background:#3b82f6;
}
.message{
    padding:16px 20px;
    border-radius:14px;
    font-weight:500;
    display:flex;
    align-items:center;
    gap:12px;
    margin-top:20px;
}
.message i{
    font-size:18px;
}
.message.error{
    background: rgba(239,68,68,0.1);
    border:1px solid #ef4444;
    color:#ef4444;
}
.message.warning{
    background: rgba(250,204,21,0.1);
    border:1px solid #facc15;
    color:#facc15;
}
</style>
