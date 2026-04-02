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
    <title>Admin Dashboard - E-Sports League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00d4ff;
            --secondary: #7b2ff7;
            --accent: #ff006e;
            --success: #00ffc8;
            --warning: #ffb800;
            --dark: #0a0e27;
            --light: #ffffff;
            --gradient-1: linear-gradient(135deg, #00d4ff 0%, #7b2ff7 100%);
            --gradient-2: linear-gradient(135deg, #ff006e 0%, #7b2ff7 100%);
            --gradient-3: linear-gradient(135deg, #00ffc8 0%, #00d4ff 100%);
            --gradient-4: linear-gradient(135deg, #ffb800 0%, #ff006e 100%);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.2);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--dark);
            color: var(--light);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: radial-gradient(circle at 20% 30%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(255, 0, 110, 0.1) 0%, transparent 50%);
            animation: bg-pulse 15s ease infinite;
            pointer-events: none;
        }

        @keyframes bg-pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
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
            pointer-events: none;
        }

        /* Navigation Bar */
        .navbar-custom {
            background: rgba(10, 14, 39, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 212, 255, 0.2);
            padding: 1.5rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 5px 30px rgba(0, 212, 255, 0.1);
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 900;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-icon {
            width: 45px;
            height: 45px;
            background: var(--gradient-1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: icon-pulse 2s ease-in-out infinite;
        }

        @keyframes icon-pulse {
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
            }
            50% { 
                transform: scale(1.1);
                box-shadow: 0 0 30px rgba(0, 212, 255, 0.6);
            }
        }

        .user-badge {
            background: var(--gradient-1);
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 5px 20px rgba(0, 212, 255, 0.4);
            transition: all 0.3s ease;
        }

        .user-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.6);
        }

        /* Main Container */
        .main-container {
            position: relative;
            z-index: 10;
            padding: 40px 20px;
        }

        /* Welcome Section */
        .welcome-section {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-1);
            opacity: 0.05;
            z-index: 0;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            font-weight: 900;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .welcome-section p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
        }

        /* Stats Overview Section */
        .stats-overview {
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: cardFadeIn 0.6s ease-out both;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-1);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .stat-card:hover::before {
            opacity: 0.1;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 20px 50px rgba(0, 212, 255, 0.3);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 2rem;
            position: relative;
            z-index: 1;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: var(--gradient-1);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: var(--gradient-3);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: var(--gradient-4);
        }

        .stat-card:nth-child(4) .stat-icon {
            background: var(--gradient-2);
        }

        .stat-value {
            font-size: 3rem;
            font-weight: 900;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
            font-weight: 600;
        }

        .stat-change {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            z-index: 1;
        }

        .stat-change.positive {
            background: rgba(0, 255, 200, 0.2);
            color: var(--success);
        }

        .stat-change.negative {
            background: rgba(255, 0, 110, 0.2);
            color: var(--accent);
        }

        /* Menu Cards */
        .menu-cards-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .menu-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 24px;
            padding: 40px 30px;
            position: relative;
            overflow: hidden;
            text-align: center;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: menuCardFloat 0.8s ease-out both;
        }

        .menu-card:nth-child(1) { animation-delay: 0.1s; }
        .menu-card:nth-child(2) { animation-delay: 0.2s; }
        .menu-card:nth-child(3) { animation-delay: 0.3s; }
        .menu-card:nth-child(4) { animation-delay: 0.4s; }
        .menu-card:nth-child(5) { animation-delay: 0.5s; }

        @keyframes menuCardFloat {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-1);
            opacity: 0;
            transition: opacity 0.5s;
        }

        .menu-card:hover::before {
            opacity: 0.1;
        }

        .menu-card:hover {
            transform: translateY(-15px) scale(1.02);
            border-color: var(--primary);
            box-shadow: 0 25px 60px rgba(0, 212, 255, 0.3);
        }

        .menu-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            position: relative;
            z-index: 1;
            transition: all 0.5s;
        }

        .menu-card:nth-child(1) .menu-icon {
            background: var(--gradient-1);
        }

        .menu-card:nth-child(2) .menu-icon {
            background: var(--gradient-3);
        }

        .menu-card:nth-child(3) .menu-icon {
            background: var(--gradient-4);
        }

        .menu-card:nth-child(4) .menu-icon {
            background: var(--gradient-2);
        }

        .menu-card:nth-child(5) .menu-icon {
            background: var(--gradient-2);
        }

        .menu-card:hover .menu-icon {
            transform: rotateY(360deg) scale(1.1);
        }

        .menu-card h4 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
        }

        .menu-card p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
            line-height: 1.6;
        }

        .menu-btn {
            background: var(--gradient-1);
            border: none;
            color: white;
            padding: 14px 30px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .menu-btn::before {
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

        .menu-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .menu-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.5);
            color: white;
        }

        .menu-btn span {
            position: relative;
            z-index: 1;
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--dark);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeOut 0.8s ease-out 1s forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                visibility: hidden;
            }
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(0, 212, 255, 0.2);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Alert Notifications */
        .alert-notification {
            position: fixed;
            top: 100px;
            right: 20px;
            background: rgba(0, 255, 200, 0.1);
            border: 2px solid var(--success);
            border-radius: 15px;
            padding: 15px 20px;
            color: var(--success);
            z-index: 10000;
            animation: slideInRight 0.5s ease-out;
            display: none;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }

            .welcome-section h1 {
                font-size: 2rem;
            }

            .menu-cards-row {
                grid-template-columns: 1fr;
            }

            .stat-value {
                font-size: 2.5rem;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gradient-1);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    <div class="grid-overlay"></div>

    <!-- Loading Overlay -->
    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Alert Notification -->
    <div class="alert-notification" id="alertNotification">
        <i class="fas fa-check-circle me-2"></i>
        <span id="alertMessage">Welcome back!</span>
    </div>

    <!-- Navigation -->
    <nav class="navbar-custom">
        <div class="container">
            <div class="navbar-content">
                <span class="navbar-brand">
                    <div class="brand-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    E-SPORTS ADMIN
                </span>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <div class="container">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h1><i class="fas fa-tachometer-alt me-3"></i>Admin Dashboard</h1>
                <p>Complete control over tournaments, teams, and player management</p>
            </div>

            <!-- Stats Overview -->
            <div class="stats-overview">
                <div class="row g-4 mb-4">
                    <?php
                    include 'dbconnect.php';
                    
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        // Get total participants
                        $stmt = $conn->query("SELECT COUNT(*) as total FROM participant");
                        $participants = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                        
                        // Get total teams
                        $stmt = $conn->query("SELECT COUNT(*) as total FROM team");
                        $teams = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                        
                        // Get total merchandise registrations
                        $stmt = $conn->query("SELECT COUNT(*) as total FROM merchandise");
                        $merch = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                        
                        // Get total kills
                        $stmt = $conn->query("SELECT SUM(kills) as total FROM participant");
                        $kills = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
                        
                        echo '
                        <div class="col-lg-3 col-md-6">
                            <div class="stat-card">
                                <span class="stat-change positive"><i class="fas fa-arrow-up me-1"></i>12%</span>
                                <div class="stat-icon"><i class="fas fa-users"></i></div>
                                <div class="stat-value">' . $participants . '</div>
                                <div class="stat-label">Total Players</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="stat-card">
                                <span class="stat-change positive"><i class="fas fa-arrow-up me-1"></i>8%</span>
                                <div class="stat-icon"><i class="fas fa-shield-alt"></i></div>
                                <div class="stat-value">' . $teams . '</div>
                                <div class="stat-label">Active Teams</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="stat-card">
                                <span class="stat-change positive"><i class="fas fa-arrow-up me-1"></i>25%</span>
                                <div class="stat-icon"><i class="fas fa-gift"></i></div>
                                <div class="stat-value">' . $merch . '</div>
                                <div class="stat-label">Merch Orders</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="stat-card">
                                <span class="stat-change negative"><i class="fas fa-arrow-down me-1"></i>3%</span>
                                <div class="stat-icon"><i class="fas fa-crosshairs"></i></div>
                                <div class="stat-value">' . number_format($kills) . '</div>
                                <div class="stat-label">Total Kills</div>
                            </div>
                        </div>';
                    } catch(PDOException $e) {
                        echo '<div class="col-12"><div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Error loading statistics. Please refresh the page.
                              </div></div>';
                    }
                    ?>
                </div>
            </div>

            <!-- Menu Cards -->
            <div class="menu-cards-row">
                <div class="menu-card">
                    <div class="menu-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>Search</h4>
                    <p>Search for teams or participants in the tournament database</p>
                    <a href="search_form.php" class="menu-btn">
                        <span><i class="fas fa-arrow-right me-2"></i>Search Now</span>
                    </a>
                </div>

                <div class="menu-card">
                    <div class="menu-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>View Participants</h4>
                    <p>View all participants to edit or delete their records</p>
                    <a href="view_participants_edit_delete.php" class="menu-btn">
                        <span><i class="fas fa-arrow-right me-2"></i>View All</span>
                    </a>
                </div>

                <div class="menu-card">
                    <div class="menu-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h4>Merchandise List</h4>
                    <p>View all merchandise registrations and export data</p>
                    <a href="view_merchandise.php" class="menu-btn">
                        <span><i class="fas fa-arrow-right me-2"></i>View List</span>
                    </a>
                </div>

                <div class="menu-card">
                    <div class="menu-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>Analytics</h4>
                    <p>View detailed analytics and performance metrics</p>
                    <a href="#" class="menu-btn" onclick="showComingSoon(); return false;">
                        <span><i class="fas fa-arrow-right me-2"></i>View Stats</span>
                    </a>
                </div>

                <div class="menu-card">
                    <div class="menu-icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <h4>Logout</h4>
                    <p>Sign out of your admin account securely</p>
                    <a href="logout.php" class="menu-btn">
                        <span><i class="fas fa-sign-out-alt me-2"></i>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show welcome notification
        window.addEventListener('load', function() {
            setTimeout(() => {
                const notification = document.getElementById('alertNotification');
                notification.style.display = 'block';
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 3000);
            }, 1500);
        });

        // Animated counter for stats
        document.querySelectorAll('.stat-value').forEach(counter => {
            const target = parseInt(counter.textContent.replace(/,/g, ''));
            let count = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                count += increment;
                if (count >= target) {
                    counter.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(count).toLocaleString();
                }
            }, 30);
        });

        // Card ripple effect
        document.querySelectorAll('.menu-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple-effect');
                
                this.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Coming soon notification
        function showComingSoon() {
            const notification = document.getElementById('alertNotification');
            const message = document.getElementById('alertMessage');
            message.textContent = 'Analytics feature coming soon!';
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
                message.textContent = 'Welcome back!';
            }, 3000);
        }

        // Add ripple animation style
        const style = document.createElement('style');
        style.textContent = `
            .ripple-effect {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            }
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Smooth scroll for any anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>