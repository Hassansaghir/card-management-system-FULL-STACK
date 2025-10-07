<?php
session_start();
require_once "../db/dbConnection.php";

if (isset($_POST['submit'])) {
    // Get form data
    $username = trim($_POST['username']);
    $lastname = trim($_POST['lastname']);
    $phonenumber = trim($_POST['phonenumber']);
    $email = trim($_POST['email']);
    $birthday = $_POST['birthday'];
    $password = $_POST['password'];

    // Hash password (security stays in PHP)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $conn = DatabaseConnection::getConnection();

        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $check->bindParam(':email', $email);
        $check->execute();

        if ($check->rowCount() > 0) {
            echo "<script>alert('⚠️ Email already registered! Please use another one.'); window.history.back();</script>";
            exit;
        }

        // Insert user
        $sql = "INSERT INTO users (username, lastname, phonenumber, email, birthday, password)
                VALUES (:username, :lastname, :phonenumber, :email, :birthday, :password)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':phonenumber', $phonenumber);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birthday', $birthday);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Account created successfully!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('❌ Failed to create account. Please try again later.');</script>";
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
  <title>Animated Sign Up Form</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(135deg, #667eea, #764ba2);
      overflow: hidden;
    }

    .signup-container {
      position: relative;
      width: 420px;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 20px;
      backdrop-filter: blur(15px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      padding: 40px 35px;
      color: #fff;
      animation: floatUp 0.9s ease;
    }

    @keyframes floatUp {
      0% { transform: translateY(40px); opacity: 0; }
      100% { transform: translateY(0); opacity: 1; }
    }

    .signup-container h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
      letter-spacing: 1px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    .input-group {
      position: relative;
    }

    .input-group input {
      width: 100%;
      padding: 14px 12px;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.3);
      border-radius: 10px;
      color: #fff;
      font-size: 15px;
      outline: none;
      transition: 0.4s;
    }

    .input-group label {
      position: absolute;
      top: 14px;
      left: 14px;
      color: rgba(255,255,255,0.7);
      font-size: 14px;
      pointer-events: none;
      transition: 0.3s ease;
    }

    .input-group input:focus,
    .input-group input:valid {
      border-color: #fff;
      box-shadow: 0 0 8px #fff;
    }

    .input-group input:focus ~ label,
    .input-group input:valid ~ label {
      top: -10px;
      left: 10px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      padding: 0 8px;
      font-size: 12px;
      border-radius: 5px;
      color: #fff;
    }

    .submit-btn {
      margin-top: 10px;
      background: linear-gradient(135deg, #764ba2, #667eea);
      color: #fff;
      border: none;
      padding: 14px;
      font-size: 16px;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.3s;
      font-weight: 500;
      letter-spacing: 0.5px;
    }

    .submit-btn:hover {
      transform: scale(1.03);
      box-shadow: 0 0 10px rgba(255,255,255,0.7);
    }

    @media (max-width: 480px) {
      .signup-container {
        width: 90%;
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <h2>Create Your Account</h2>
    <form action="signUp.php" method="POST" onsubmit="return validateForm()">
      <div class="input-group">
        <input type="text" id="username" name="username" required>
        <label for="username">Username</label>
      </div>
      <div class="input-group">
        <input type="text" id="lastname" name="lastname" required>
        <label for="lastname">Last Name</label>
      </div>
      <div class="input-group">
        <input type="tel" id="phonenumber" name="phonenumber" required>
        <label for="phonenumber">Phone Number</label>
      </div>
      <div class="input-group">
        <input type="email" id="email" name="email" required>
        <label for="email">Email</label>
      </div>
      <div class="input-group">
        <input type="date" id="birthday" name="birthday" required>
        <label for="birthday">Birthday</label>
      </div>
      <div class="input-group">
        <input type="password" id="password" name="password" required>
        <label for="password">Password</label>
      </div>
      <div class="input-group">
        <input type="password" id="confirm-password" name="confirm-password" required>
        <label for="confirm-password">Confirm Password</label>
      </div>
      <button type="submit" class="submit-btn" name="submit">Sign Up</button>
      <p style="text-align:center; margin-top:15px; font-size:14px;">
        Already have an account? 
        <a href="login.php" style="color:#fff; text-decoration:underline;">Login here</a>
      </p>
    </form>
  </div>

<script>
function validateForm() {
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirm-password').value;

  // Email validation
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    alert("❌ Invalid email format!");
    return false;
  }

  // Password strength validation
  const upperCase = /[A-Z]/.test(password);
  const lowerCase = /[a-z]/.test(password);
  const number = /[0-9]/.test(password);
  const specialChar = /[^A-Za-z0-9]/.test(password);

  if (!upperCase || !lowerCase || !number || !specialChar || password.length < 8) {
    alert("❌ Password must be at least 8 characters long and include uppercase, lowercase, number, and special symbol.");
    return false;
  }

  // Confirm password match
  if (password !== confirmPassword) {
    alert("❌ Passwords do not match!");
    return false;
  }

  return true; // ✅ Everything OK
}
</script>
</body>
</html>
