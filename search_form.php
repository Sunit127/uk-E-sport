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
    <title>Search Portal - E-Sports League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00d4ff;
            --secondary: #7b2ff7;
            --accent: #ff006e;
            --dark: #0a0e27;
            --light: #ffffff;
            --gradient-1: linear-gradient(135deg, #00d4ff 0%, #7b2ff7 100%);
            --gradient-2: linear-gradient(135deg, #ff006e 0%, #7b2ff7 100%);
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
                        radial-gradient(circle at 70% 60%, rgba(123, 47, 247, 0.1) 0%, transparent 50%);
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

        /* Search Container */
        .search-container {
            position: relative;
            z-index: 10;
            max-width: 700px;
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

        /* Search Card */
        .search-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 28px;
            padding: 45px 40px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .search-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-1);
        }

        /* Header */
        .search-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .search-icon-main {
            width: 90px;
            height: 90px;
            background: var(--gradient-1);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: icon-pulse 3s ease-in-out infinite;
            box-shadow: 0 10px 40px rgba(0, 212, 255, 0.5);
        }

        @keyframes icon-pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 40px rgba(0, 212, 255, 0.5);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 15px 50px rgba(0, 212, 255, 0.8);
            }
        }

        .search-icon-main i {
            font-size: 3rem;
            color: white;
        }

        .search-header h2 {
            font-size: 2.2rem;
            font-weight: 900;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
        }

        .search-header p {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Search Type Badge */
        .search-type-badge {
            background: var(--gradient-1);
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 212, 255, 0.3);
        }

        .search-type-badge.participant {
            background: var(--gradient-1);
        }

        .search-type-badge.team {
            background: var(--gradient-2);
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
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(0, 212, 255, 0.2);
            border-radius: 15px;
            color: var(--light);
            font-size: 1rem;
            transition: all 0.4s;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(0, 212, 255, 0.1),
                        0 5px 20px rgba(0, 212, 255, 0.3);
        }

        /* Search Button */
        .btn-search {
            width: 100%;
            padding: 18px;background: var(--gradient-1);
            border: none;
            border-radius: 15px;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.4s;
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.4);
            margin-bottom: 20px;
        }

        .btn-search::before {
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

        .btn-search:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-search:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 212, 255, 0.6);
        }

        .btn-search span {
            position: relative;
            z-index: 1;
        }

        .btn-search.team-btn {
            background: var(--gradient-2);
            box-shadow: 0 10px 30px rgba(255, 0, 110, 0.4);
        }

        .btn-search.team-btn:hover {
            box-shadow: 0 15px 40px rgba(255, 0, 110, 0.6);
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(0, 212, 255, 0.3), transparent);
        }

        .divider span {
            background: var(--dark);
            padding: 0 20px;
            position: relative;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* Search Section */
        .search-section {
            animation: fadeIn 0.6s ease-out both;
        }

        .search-section:nth-child(1) {
            animation-delay: 0.2s;
        }

        .search-section:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .search-card {
                padding: 35px 28px;
            }
            .search-icon-main {
                width: 75px;
                height: 75px;
            }
            .search-icon-main i {
                font-size: 2.5rem;
            }
            .search-header h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    <div class="grid-overlay"></div>

    <!-- Search Container -->
    <div class="search-container">
        <a href="admin_menu.php" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>

        <div class="search-card">
            <div class="search-header">
                <div class="search-icon-main">
                    <i class="fas fa-search"></i>
                </div>
                <h2>Search Portal</h2>
                <p>Find participants or teams in the database</p>
            </div>

            <!-- Search for Participant -->
            <div class="search-section">
                <span class="search-type-badge participant">
                    <i class="fas fa-user me-2"></i>Participant Search
                </span>
                <form action="search_result.php" method="POST">
                    <div class="form-group">
                        <label for="firstname_surname" class="form-label">
                            <i class="fas fa-user-circle"></i>
                            First Name or Surname
                        </label>
                        <input type="text" class="form-control" id="firstname_surname" name="firstname_surname" placeholder="Enter name to search..." required>
                    </div>
                    <input type="hidden" name="participant" value="1">
                    <button type="submit" class="btn-search">
                        <span><i class="fas fa-search me-2"></i>Search Participant</span>
                    </button>
                </form>
            </div>

            <div class="divider">
                <span>OR</span>
            </div>

            <!-- Search for Team -->
            <div class="search-section">
                <span class="search-type-badge team">
                    <i class="fas fa-users me-2"></i>Team Search
                </span>
                <form action="search_result.php" method="POST">
                    <div class="form-group">
                        <label for="team" class="form-label">
                            <i class="fas fa-shield-alt"></i>
                            Team Name
                        </label>
                        <input type="text" class="form-control" id="team" name="team" placeholder="Enter team name to search..." required>
                    </div>
                    <button type="submit" class="btn-search team-btn">
                        <span><i class="fas fa-search me-2"></i>Search Team</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Button ripple effect
        document.querySelectorAll('.btn-search').forEach(btn => {
            btn.addEventListener('click', function(e) {
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
        });

        // Input animations
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.style.transform = 'scale(1)';
            });
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

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                window.location.href = 'admin_menu.php';
            }
        });
    </script>
</body>
</html>