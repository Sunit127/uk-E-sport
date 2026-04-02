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
    <title>View Participants - E-Sports League</title>
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
            position: relative;
            padding: 20px;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: radial-gradient(circle at 20% 30%, rgba(0, 212, 255, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(255, 0, 110, 0.08) 0%, transparent 50%);
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

        /* Main Container */
        .main-container {
            position: relative;
            z-index: 10;
            max-width: 1400px;
            margin: 0 auto;
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
            box-shadow: 0 5px 20px rgba(0, 212, 255, 0.3);
        }

        /* Page Card */
        .page-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 900;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.1rem;
        }

        /* Search Box */
        .search-box {
            margin-bottom: 30px;
        }

        .search-input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(0, 212, 255, 0.2);
            border-radius: 15px;
            color: var(--light);
            font-size: 1rem;
            transition: all 0.4s;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(0, 212, 255, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* Table */
        .table-wrapper {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 18px;
            overflow: hidden;
        }

        .table {
            color: var(--light);
            margin: 0;
        }

        .table thead {
            background: var(--gradient-1);
        }

        .table thead th {
            border: none;
            padding: 18px 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .table tbody tr {
            border-bottom: 1px solid rgba(0, 212, 255, 0.1);
            transition: all 0.3s;
        }

        .table tbody tr:hover {
            background: rgba(0, 212, 255, 0.05);
            transform: scale(1.005);
        }

        .table tbody td {
            padding: 18px 20px;
            border: none;
            vertical-align: middle;
        }

        /* Badges */
        .badge-custom {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-kills {
            background: rgba(0, 255, 200, 0.2);
            color: var(--success);
        }

        .badge-deaths {
            background: rgba(255, 0, 110, 0.2);
            color: var(--accent);
        }

        .badge-kd {
            background: rgba(0, 212, 255, 0.2);
            color: var(--primary);
        }

        /* Action Buttons */
        .btn-edit {
            background: var(--gradient-3);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            margin-right: 8px;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 255, 200, 0.4);
            color: white;
        }

        .btn-delete {
            background: var(--gradient-2);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 0, 110, 0.4);
            color: white;
        }

        /* Stats Footer */
        .stats-footer {
            margin-top: 30px;
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 15px;
            border: 1px solid rgba(0, 212, 255, 0.1);
        }

        .stats-footer p {
            color: rgba(255, 255, 255, 0.6);
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-card {
                padding: 25px 20px;}
            .page-header h1 {
                font-size: 2rem;
            }
            .table-wrapper {
                overflow-x: auto;
            }
            .table {
                font-size: 0.85rem;
            }
            .btn-edit, .btn-delete {
                padding: 6px 16px;
                font-size: 0.8rem;
            }
        }

        /* Loading Skeleton */
        .skeleton {
            animation: skeleton-loading 1s linear infinite alternate;
        }

        @keyframes skeleton-loading {
            0% {
                background-color: rgba(255, 255, 255, 0.05);
            }
            100% {
                background-color: rgba(255, 255, 255, 0.1);
            }
        }

        /* No data state */
        .no-data {
            text-align: center;
            padding: 60px 20px;
        }

        .no-data i {
            font-size: 4rem;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
        }

        .no-data h3 {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 10px;
        }

        .no-data p {
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    <div class="grid-overlay"></div>

    <!-- Main Container -->
    <div class="main-container">
        <a href="admin_menu.php" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>

        <div class="page-card">
            <div class="page-header">
                <h1><i class="fas fa-users me-3"></i>All Participants</h1>
                <p>Manage and view all tournament participants</p>
            </div>

            <!-- Search Box -->
            <div class="search-box position-relative">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="Search by name, email, or team...">
            </div>

            <?php
            include 'dbconnect.php';
        
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $sql = "SELECT p.*, t.name as team_name 
                        FROM participant p 
                        LEFT JOIN team t ON p.team_id = t.id 
                        ORDER BY p.id ASC";
                
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($results) > 0) {
                    echo '<div class="table-wrapper">
                            <table class="table" id="participantsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Surname</th>
                                        <th>Email</th>
                                        <th>Kills</th>
                                        <th>Deaths</th>
                                        <th>K/D Ratio</th>
                                        <th>Team</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    
                    foreach ($results as $row) {
                        $kd_ratio = $row['deaths'] > 0 ? round($row['kills'] / $row['deaths'], 2) : $row['kills'];
                        
                        echo '<tr>
                                <td><strong>#' . $row['id'] . '</strong></td>
                                <td>' . htmlspecialchars($row['firstname']) . '</td>
                                <td>' . htmlspecialchars($row['surname']) . '</td>
                                <td>' . htmlspecialchars($row['email']) . '</td>
                                <td><span class="badge-custom badge-kills"><i class="fas fa-crosshairs me-1"></i>' . $row['kills'] . '</span></td>
                                <td><span class="badge-custom badge-deaths"><i class="fas fa-skull me-1"></i>' . $row['deaths'] . '</span></td>
                                <td><span class="badge-custom badge-kd">' . $kd_ratio . '</span></td>
                                <td>' . htmlspecialchars($row['team_name']) . '</td>
                                <td>
                                    <a href="edit_participant.php?id=' . $row['id'] . '" class="btn-edit">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="delete.php?id=' . $row['id'] . '" class="btn-delete" onclick="return confirm(\'Are you sure you want to delete this participant?\')">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </a>
                                </td>
                              </tr>';
                    }
                    
                    echo '</tbody></table></div>';
                    
                    echo '<div class="stats-footer">
                            <p><i class="fas fa-database me-2"></i>Total Participants: <strong>' . count($results) . '</strong></p>
                          </div>';
                } else {
                    echo '<div class="no-data">
                            <i class="fas fa-users-slash"></i>
                            <h3>No Participants Found</h3>
                            <p>No participants are currently registered in the database.</p>
                          </div>';
                }
            }
            catch(PDOException $e) {
                echo '<div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Database Error: ' . $e->getMessage() . '
                      </div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('participantsTable');

        if (searchInput && table) {
            searchInput.addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
                
                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    const text = row.textContent.toLowerCase();
                    
                    if (text.includes(searchValue)) {
                        row.style.display = '';
                        row.style.animation = 'fadeIn 0.3s';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }

        // Add fade in animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);

        // Row hover effect
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.01)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Button ripple effect
        document.querySelectorAll('.btn-edit, .btn-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Are you sure?') && this.classList.contains('btn-delete')) {
                    e.preventDefault();
                    return;
                }
                
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
                ripple.style.background = 'rgba(255, 255, 255, 0.5)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s ease-out';
                ripple.style.pointerEvents = 'none';
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add ripple animation
        const rippleStyle = document.createElement('style');
        rippleStyle.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(rippleStyle);
    </script>
</body>
</html>