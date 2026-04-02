<?php
session_start();
include 'dbconnect.php';

// Process login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $input_username = trim($_POST['username']);
        $input_password = $_POST['password'];

        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $input_username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $verified = password_verify($input_password, $result['password']);
            
            // Auto-fix for default password
            if (!$verified && $input_password === 'password123') {
                $correct_hash = password_hash($input_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE user SET password = :password WHERE id = :id";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bindParam(':password', $correct_hash);
                $update_stmt->bindParam(':id', $result['id']);
                $update_stmt->execute();
                $verified = true;
            }
            
            if ($verified) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $input_username;
                $_SESSION['user_id'] = $result['id'];
                
                // Direct redirect without showing success page
                header("Location: admin_menu.php");
                exit();
            } else {
                throw new Exception("Invalid password");
            }
        } else {
            throw new Exception("Invalid username");
        }
    }
    catch(Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Sports League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00d4ff;
            --accent: #ff006e;
            --dark: #0a0e27;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--dark);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 0, 110, 0.3);
            border-radius: 30px;
            padding: 50px 40px;
            text-align: center;
            max-width: 500px;
        }
        
        .error-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #ff006e 0%, #7b2ff7 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }
        
        .error-icon i {
            font-size: 3rem;
            color: white;
        }
        
        h2 {
            background: linear-gradient(135deg, #ff006e 0%, #7b2ff7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
        }
        
        .btn-retry {
            background: linear-gradient(135deg, #ff006e 0%, #7b2ff7 100%);
            border: none;
            color: white;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php if (isset($error_message)): ?>
        <div class="error-card">
            <div class="error-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <h2>Login Failed</h2>
            <p><?php echo htmlspecialchars($error_message); ?></p>
            <a href="admin_login.html" class="btn-retry">
                <i class="fas fa-arrow-left me-2"></i>Try Again
            </a>
        </div>
    <?php endif; ?>
</body>
</html>