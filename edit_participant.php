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
    <title>Edit Participant - E-Sports League</title>
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
            --gradient-1: linear-gradient(135deg, #00d4ff 0%, #7b2ff7 100%);
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
            padding: 40px 20px;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: radial-gradient(circle at 30% 40%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 60%, rgba(0, 255, 200, 0.1) 0%, transparent 50%);
        }

        /* Grid Overlay */
        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(0, 212, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 212, 255, 0.02) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 0;
        }

        /* Edit Container */
        .edit-container {
            position: relative;
            z-index: 10;
            max-width: 650px;
            width: 100%;
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Back Button */
        .btn-back {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(0, 212, 255, 0.3);
            color: var(--primary);
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.4s;
            margin-bottom: 25px;
        }

        .btn-back:hover {
            background: rgba(0, 212, 255, 0.1);
            border-color: var(--primary);
            color: var(--primary);
            transform: translateX(-5px);
        }

        /* Edit Card */
        .edit-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 28px;
            padding: 45px 40px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .edit-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-3);
        }

        /* Header */
        .edit-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .edit-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-3);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: icon-pulse 2s ease-in-out infinite;
            box-shadow: 0 10px 35px rgba(0, 255, 200, 0.5);
        }

        @keyframes icon-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .edit-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .edit-header h2 {
            font-size: 2rem;
            font-weight: 900;
            background: var(--gradient-3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .edit-header p {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Success Message */
        .success-message {
            background: rgba(0, 255, 200, 0.1);
            border: 2px solid var(--success);
            border-radius: 14px;
            padding: 15px 20px;
            margin-bottom: 25px;
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Info Section */
        .info-section {
            background: rgba(0, 212, 255, 0.05);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .info-section h5 {
            color: var(--primary);
            margin-bottom: 15px;
            font-weight: 700;
        }

        .info-section p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: var(--primary);
        }

        .form-control {
            width: 100%;
            padding: 15px 18px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(0, 212, 255, 0.2);
            border-radius: 14px;
            color: var(--light);
            font-size: 1rem;
            transition: all 0.4s;
        }

        .form-control:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(0, 212, 255, 0.1);
        }

        .form-text {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
            margin-top: 8px;
            display: block;
        }

        /* Update Button */
        .btn-update {
            width: 100%;
            padding: 18px;
            background: var(--gradient-3);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.4s;
            box-shadow: 0 10px 30px rgba(0, 255, 200, 0.4);
        }

        .btn-update::before {
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

        .btn-update:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-update:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 255, 200, 0.6);
        }

        .btn-update span {
            position: relative;
            z-index: 1;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .edit-card {
                padding: 35px 28px;
            }
            .edit-icon {
                width: 70px;
                height: 70px;
            }
            .edit-icon i {
                font-size: 2.2rem;
            }
            .edit-header h2 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    <div class="grid-overlay"></div>

    <!-- Edit Container -->
    <div class="edit-container">
        <a href="view_participants_edit_delete.php" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Back to Participants
        </a>

        <div class="edit-card">
            <?php
            include 'dbconnect.php';

            try {
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // UPDATE section
                    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $id = intval($_POST['id']);
                    $kills = floatval($_POST['kills']);
                    $deaths = floatval($_POST['deaths']);
                    
                    if ($kills < 0 || $deaths < 0) {
                        throw new Exception("Kills and deaths must be non-negative numbers.");
                    }
                    
                    if ($kills > 999999 || $deaths > 999999) {
                        throw new Exception("Kills and deaths cannot exceed 999,999.");
                    }
                    
                    $sql = "UPDATE participant SET kills = :kills, deaths = :deaths WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':kills', $kills);
                    $stmt->bindParam(':deaths', $deaths);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    
                    echo '<div class="success-message">
                            <i class="fas fa-check-circle"></i>
                            <div><strong>Success!</strong> Participant scores updated successfully.</div>
                          </div>';
                    
                    $sql = "SELECT * FROM participant WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $participant = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                } else {
                    // SELECT section
                    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    if (!isset($_GET['id'])) {
                        throw new Exception("No participant ID provided.");
                    }
                    
                    $id = intval($_GET['id']);
                    
                    $sql = "SELECT * FROM participant WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $participant = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if (!$participant) {
                        throw new Exception("Participant not found.");
                    }
                }
                
                $firstname = $participant['firstname'];
                $surname = $participant['surname'];
                $kills = $participant['kills'];
                $deaths = $participant['deaths'];
                $id = $participant['id'];
                ?>
                
                <div class="edit-header">
                    <div class="edit-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <h2>Edit Player Scores</h2>
                    <p>Update kills and deaths for participant</p>
                </div>

                <div class="info-section">
                    <h5><i class="fas fa-info-circle me-2"></i>Participant Information</h5>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($firstname . ' ' . $surname); ?></p>
                    <p class="mb-0"><strong>ID:</strong> #<?php echo $id; ?></p>
                </div>

                <form action="edit_participant.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname" class="form-label">
                                    <i class="fas fa-user"></i>
                                    First Name
                                </label>
                                <input type="text" class="form-control" id="firstname" value="<?php echo htmlspecialchars($firstname); ?>" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="surname" class="form-label">
                                    <i class="fas fa-user"></i>
                                    Surname
                                </label>
                                <input type="text" class="form-control" id="surname" value="<?php echo htmlspecialchars($surname); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kills" class="form-label">
                                    <i class="fas fa-crosshairs"></i>
                                    Kills
                                </label>
                                <input type="number" class="form-control" id="kills" name="kills" value="<?php echo $kills; ?>" step="0.01" min="0" max="999999" required>
                                <small class="form-text">Max: 999,999</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deaths" class="form-label">
                                    <i class="fas fa-skull"></i>
                                    Deaths
                                </label>
                                <input type="number" class="form-control" id="deaths" name="deaths" value="<?php echo $deaths; ?>" step="0.01" min="0" max="999999" required>
                                <small class="form-text">Max: 999,999</small>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <button type="submit" class="btn-update">
                        <span><i class="fas fa-save me-2"></i>Update Player Scores</span>
                    </button>
                </form>

                <?php
            }
            catch(PDOException $e) {
                echo '<div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Database Error: ' . $e->getMessage() . '
                      </div>';
            }
            catch(Exception $e) {
                echo '<div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Error: ' . $e->getMessage() . '
                      </div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Input validation
        const inputs = document.querySelectorAll('input[type="number"]');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value < 0) {
                    this.value = 0;
                }
                if (this.value > 999999) {
                    this.value = 999999;
                }
            });

            input.addEventListener('focus', function() {
                this.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Button ripple effect
        document.querySelector('.btn-update').addEventListener('click', function(e) {
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