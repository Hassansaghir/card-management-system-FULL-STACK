
<?php
session_start();
require_once "../db/dbConnection.php";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $conn = DatabaseConnection::getConnection();
        if (!$conn) {
            die("❌ Cannot connect to database!");
        }

        // Fetch user by email
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                echo "<script>alert('✅ Login successful!'); window.location.href='../Dashboard/MainDashboard.php';</script>";
                exit;
            } else {
                echo "<script>alert('❌ Incorrect password!'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('❌ Email not found!'); window.history.back();</script>";
            exit;
        }

    } catch (PDOException $e) {
        echo "<script>alert('❌ Database Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
    body{display:flex;justify-content:center;align-items:center;height:100vh;background:linear-gradient(135deg,#667eea,#764ba2);}
    
    .login-container{
      width:420px;
      background:rgba(255,255,255,0.15);
      border-radius:20px;
      backdrop-filter:blur(15px);
      padding:40px 35px;
      color:#fff;
      box-shadow:0 10px 30px rgba(0,0,0,0.2);
      animation:floatUp 0.9s ease;
    }

    @keyframes floatUp {
      0% { transform: translateY(40px); opacity:0; }
      100% { transform: translateY(0); opacity:1; }
    }

    .login-container h2{text-align:center;margin-bottom:25px;font-weight:600;letter-spacing:1px;}

    form{display:flex;flex-direction:column;gap:18px;}

    .input-group{position:relative;}
    .input-group input{
      width:100%;
      padding:14px 12px;
      background:rgba(255,255,255,0.1);
      border:1px solid rgba(255,255,255,0.3);
      border-radius:10px;
      color:#fff;
      font-size:15px;
      outline:none;
      transition:0.4s;
    }
    .input-group label{
      position:absolute;
      top:14px;
      left:14px;
      color:rgba(255,255,255,0.7);
      font-size:14px;
      pointer-events:none;
      transition:0.3s;
    }
    .input-group input:focus,.input-group input:valid{border-color:#fff;box-shadow:0 0 8px #fff;}
    .input-group input:focus ~ label,.input-group input:valid ~ label{
      top:-10px; left:10px;
      background:linear-gradient(135deg,#667eea,#764ba2);
      padding:0 8px; font-size:12px; border-radius:5px; color:#fff;
    }

    .submit-btn{
      margin-top:10px;
      background:linear-gradient(135deg,#764ba2,#667eea);
      color:#fff;
      border:none;
      padding:14px;
      font-size:16px;
      border-radius:10px;
      cursor:pointer;
      transition:0.3s;
      font-weight:500;
      letter-spacing:0.5px;
    }
    .submit-btn:hover{transform:scale(1.03);box-shadow:0 0 10px rgba(255,255,255,0.7);}

    p{ text-align:center; margin-top:15px; font-size:14px; }
    p a{ color:#fff; text-decoration:underline; }

    @media(max-width:480px){.login-container{width:90%;padding:30px 20px;}}
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form action="login.php" method="POST" onsubmit="return validateForm()">
      <div class="input-group">
        <input type="email" id="email" name="email" required>
        <label for="email">Email</label>
      </div>
      <div class="input-group">
        <input type="password" id="password" name="password" required>
        <label for="password">Password</label>
      </div>
      <button type="submit" class="submit-btn" name="login">Login</button>

      <!-- Link to Sign Up -->
      <p>Don't have an account? <a href="signUp.php">Sign Up</a></p>
    </form>
  </div>

<script>
function validateForm() {
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value;

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    alert("❌ Invalid email format!");
    return false;
  }
  if (password.length < 6) {
    alert("❌ Password must be at least 6 characters!");
    return false;
  }
  return true;
}
</script>
</body>
</html>
