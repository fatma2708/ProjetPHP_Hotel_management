<?php
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'hotel_management';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password, role_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        $role_id = $row['role_id'];

        if (password_verify($password, $hashed_password)) {
            // Login successful, redirect to dashboard based on role
            session_start();
            $_SESSION['email'] = $email;
        
            if ($role_id == 1) {
                $_SESSION['role'] = 'admin';
                header("Location: admin_dashboard.php");
            } elseif ($role_id == 2) {
                $_SESSION['role'] = 'client';
                header("Location: client_dashboard.php");
            } elseif ($role_id == 3) {
                $_SESSION['role'] = 'receptionniste';
                header("Location: receptionniste_dashboard.php");
            }
            exit;
        
        } else {
            // Login failed, display error message
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }
}

$conn->close();
?>

<html>
<head>
<style>
  body {
      font-family: "Lato", sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-image: url(assets/img/hero_2.jpg);
  }

  @keyframes animateBG {
      0% {
          background-position: 0% 50%;
      }
      50% {
          background-position: 100% 50%;
      }
      100% {
          background-position: 0% 50%;
      }
  }

  .login-container {
      background-color: rgb(255, 255, 255);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2);
      width: 300px;
      max-width: 100%;
      text-align: center;
  }

  h2.card-title {
      color: rgb(30, 1, 32);
      font-size: 28px;
      margin-bottom: 20px;
      font-weight: bold;
  }

  input[type="text"],
  input[type="password"],
  input[type="email"] {
      width: calc(100% - 40px);
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      border: 1px solid #ccc;
      box-sizing: border-box;
  }

  button {
      background-color: rgb(57, 5, 57);
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 5px;
      cursor: pointer;
      width: calc(100% - 40px);
      transition: background-color 0.3s ease;
  }

  button:hover {
      background-color: #999;
  }

  .signup-link {
      font-size: 14px;
      color: #333;
      text-decoration: none;
  }

  .signup-link:hover {
      text-decoration: underline;
  }
</style>
</head>

<body>
<div class="login-container">
  <h2 class="card-title">Se connecter</h2>
  <form method="post">
    <div class="form-group">
      <input type="email" name="email" placeholder="Email" required>
    </div>
    <div class="form-group">
      <input type="password" name="password" placeholder="Mot de passe" required>
    </div>
    <button type="submit">Se connecter</button>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
  </form>
</div>
</body>
</html>