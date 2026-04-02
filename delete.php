<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: admin_login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Participant - E-Sports League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00d4ff;
            --secondary: #7b2ff7;
            --accent: #ff006e;
            --success: #00ffc8;
            --dark: #0a0e27;
            --light: #ffffff;
            --gradient-2: linear-gradient(135deg, #ff006e 0%, #7b2ff7 100%);
            --gradient-3: linear-gradient(135deg, #00ffc8 0%, #00d4ff 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--dark);
            color: var(--light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: radial-gradient(circle at 30% 40%, rgba(255, 0, 110, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 70% 60%, rgba(123, 47, 247, 0.15) 0%, transparent 50%);
            animation: bg-pulse 15s ease infinite;
        }

        @keyframes bg-pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
        }

        /* Grid Pattern */
        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255, 0, 110, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 0, 110, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 0;
        }

        /* Delete Container */
        .delete-container {
            position: relative;
            z-index: 10;
            max-width: 500px;
            width: 100%;
            padding: 0 20px;
            animation: zoomIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Delete Card */
        .delete-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 0, 110, 0.3);
            border-radius: 30px;
            padding: 50px 40px;
            text-align: center;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .delete-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-2);
        }

        /* Success/Error Icons */
        .status-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            position: relative;
            animation: iconPop 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes iconPop {
            0% {
                transform: scale(0) rotate(-180deg);
                opacity: 0;
            }
            60% {
                transform: scale(1.2) rotate(10deg);
            }
            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        .status-icon.success {
            background: var(--gradient-3);
            box-shadow: 0 10px 40px rgba(0, 255, 200, 0.5);
        }

        .status-icon.error {
            background: var(--gradient-2);
            box-shadow: 0 10px 40px rgba(255, 0, 110, 0.5);
        }

        .status-icon::before {
            content: '';
            position: absolute;
            width: 120%;
            height: 120%;
            border-radius: 50%;
            border: 3px solid;
            animation: ring-pulse 2s ease-out infinite;
        }

        .status-icon.success::before {
            border-color: rgba(0, 255, 200, 0.3);
        }

        .status-icon.error::before {
            border-color: rgba(255, 0, 110, 0.3);
        }

        @keyframes ring-pulse {
            0% {
                transform: scale(0.9);
                opacity: 1;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .status-icon i {
            font-size: 3.5rem;
            color: white;
            animation: iconAppear 0.6s ease-out 0.3s both;
        }

        @keyframes iconAppear {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Content */
        .delete-content {
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px}
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delete-content h2 {
            font-size: 2.2rem;
            font-weight: 900;
            margin-bottom: 15px;
        }

        .delete-content h2.success-title {
            background: var(--gradient-3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .delete-content h2.error-title {
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .delete-content p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .participant-info {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 15px;
            margin: 20px 0;
        }

        .participant-info strong {
            color: var(--primary);
        }

        .participant-id {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            margin-top: 8px;
        }

        /* Back Button */
        .btn-back {
            background: var(--gradient-3);
            border: none;
            color: white;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.4s;
            box-shadow: 0 10px 30px rgba(0, 255, 200, 0.4);
            position: relative;
            overflow: hidden;
            margin-top: 25px;
        }

        .btn-back.error-btn {
            background: var(--gradient-2);
            box-shadow: 0 10px 30px rgba(255, 0, 110, 0.4);
        }

        .btn-back::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-back:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-back:hover {
            transform: translateY(-3px);
            color: white;
        }

        .btn-back.error-btn:hover {
            box-shadow: 0 15px 40px rgba(255, 0, 110, 0.6);
        }

        .btn-back:not(.error-btn):hover {
            box-shadow: 0 15px 40px rgba(0, 255, 200, 0.6);
        }

        .btn-back span {
            position: relative;
            z-index: 1;
        }

        /* Countdown */
        .countdown {
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            animation: fadeIn 1s ease-out 0.8s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .delete-card {
                padding: 40px 30px;
            }
            .status-icon {
                width: 80px;
                height: 80px;
            }
            .status-icon i {
                font-size: 3rem;
            }
            .delete-content h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    <div class="grid-overlay"></div>

    <!-- Delete Container -->
    <div class="delete-container">
        <div class="delete-card">
            <?php
            include 'dbconnect.php';

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Get participant ID from URL
                if (!isset($_GET['id'])) {
                    throw new Exception("No participant ID provided.");
                }
                
                $id = intval($_GET['id']);
                
                // First, fetch participant details
                $sql = "SELECT firstname, surname FROM participant WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $participant = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$participant) {
                    throw new Exception("Participant not found.");
                }
                
                // Delete the participant
                $sql = "DELETE FROM participant WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    echo '<div class="status-icon success">
                            <i class="fas fa-check-circle"></i>
                          </div>
                          <div class="delete-content">
                            <h2 class="success-title">Successfully Deleted</h2>
                            <p>Participant has been removed from the database</p>
                            <div class="participant-info">
                                <strong>' . htmlspecialchars($participant['firstname'] . ' ' . $participant['surname']) . '</strong>
                                <div class="participant-id">ID: #' . $id . '</div>
                            </div>
                            <a href="view_participants_edit_delete.php" class="btn-back">
                                <span><i class="fas fa-arrow-left me-2"></i>Back to Participants</span>
                            </a>
                            <div class="countdown">
                                Redirecting in <span id="countdown">3</span> seconds...
                            </div>
                          </div>';
                } else {
                    throw new Exception("Failed to delete participant.");
                }
            }
            catch(PDOException $e) {
                echo '<div class="status-icon error">
                        <i class="fas fa-times-circle"></i>
                      </div>
                      <div class="delete-content">
                        <h2 class="error-title">Database Error</h2>
                        <p>An error occurred while deleting</p>
                        <div class="participant-info">
                            <strong>Error:</strong> ' . $e->getMessage() . '
                        </div>
                        <a href="view_participants_edit_delete.php" class="btn-back error-btn">
                            <span><i class="fas fa-arrow-left me-2"></i>Go Back</span>
                        </a>
                      </div>';
            }
            catch(Exception $e) {
                echo '<div class="status-icon error">
                        <i class="fas fa-exclamation-triangle"></i>
                      </div>
                      <div class="delete-content">
                        <h2 class="error-title">Error</h2>
                        <p>' . $e->getMessage() . '</p>
                        <a href="view_participants_edit_delete.php" class="btn-back error-btn">
                            <span><i class="fas fa-arrow-left me-2"></i>Go Back</span>
                        </a>
                      </div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto redirect after 3 seconds (only on success)
        const countdownEl = document.getElementById('countdown');
        if (countdownEl) {
            let count = 3;
            const timer = setInterval(() => {
                count--;
                countdownEl.textContent = count;
                
                if (count <= 0) {
                    clearInterval(timer);
                    window.location.href = 'view_participants_edit_delete.php';
                }
            }, 1000);
        }

        // Button ripple effect
        document.querySelector('.btn-back').addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(255, 255, 255, 0.6)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s ease-out';
            ripple.style.pointerEvents = 'none';
            
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });

        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>