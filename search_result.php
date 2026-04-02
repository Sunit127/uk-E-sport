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
    <title>Search Results - E-Sports League</title>
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
                        radial-gradient(circle at 80% 70%, rgba(123, 47, 247, 0.08) 0%, transparent 50%);
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
        .results-container {
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

        /* Results Card */
        .results-card {
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

        /* Header */
        .results-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header-icon-wrapper {
            width: 90px;
            height: 90px;
            background: var(--gradient-1);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: icon-bounce 2s ease-in-out infinite;
            box-shadow: 0 10px 40px rgba(0, 212, 255, 0.5);
        }

        @keyframes icon-bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .header-icon-wrapper i {
            font-size: 3rem;
            color: white;
        }

        .results-header h2 {
            font-size: 2.5rem;
            font-weight: 900;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
        }

        .results-count {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.1rem;
        }

        .results-count strong {
            color: var(--primary);
            font-weight: 700;
        }

        /* Team Stats Card */
        .team-stats-card {
            background: var(--gradient-1);
            border-radius: 20px;
            padding: 35px;
            margin-bottom: 35px;
            box-shadow: 0 15px 40px rgba(0, 212, 255, 0.3);
        }

        .team-name {
            font-size: 2.5rem;
            font-weight: 900;
            color: white;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .team-location {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            margin-bottom: 25px;
        }

        .team-location i {
            margin-right: 8px;
        }

        .stat-box {
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 900;
            color: white;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .stat-label {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.9);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Section Title */
        .section-title {
            font-size: 1.8rem;
            font-weight: 800;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
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

        .badge-kd-positive {
            background: rgba(0, 255, 200, 0.2);
            color: var(--success);
        }

        .badge-kd-neutral {
            background: rgba(255, 184, 0, 0.2);
            color: var(--warning);
        }

        .badge-kd-negative {
            background: rgba(255, 0, 110, 0.2);
            color: var(--accent);
        }

        /* No Results */
        .no-results {
            text-align: center;
            padding: 60px 20px;
        }

        .no-results i {
            font-size: 5rem;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 25px;
            animation: shake 1s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .no-results h3 {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 15px;
            font-size: 2rem;
            font-weight: 800;
        }

        .no-results p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .results-card {
                padding: 25px 20px;
            }
            .results-header h2 {
                font-size: 2rem;
            }
            .header-icon-wrapper {
                width: 75px;
                height: 75px;
            }
            .header-icon-wrapper i {
                font-size: 2.5rem;
            }
            .team-name {
                font-size: 2rem;
            }
            .stat-number {
                font-size: 2.5rem;
            }
            .table-wrapper {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    <div class="grid-overlay"></div>

    <!-- Results Container -->
    <div class="results-container">
        <a href="search_form.php" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Back to Search
        </a>

        <div class="results-card">
            <?php
            include 'dbconnect.php';
        
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Check which form has been posted
                if (isset($_POST['participant']) && $_POST['participant'] == "1") {
                    // Search for a participant
                    $search_term = '%' . trim($_POST['firstname_surname']) . '%';
                    
                    $sql = "SELECT p.*, t.name as team_name, t.location 
                            FROM participant p 
                            LEFT JOIN team t ON p.team_id = t.id 
                            WHERE p.firstname LIKE :search OR p.surname LIKE :search";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':search', $search_term);
                    $stmt->execute();
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo '<div class="results-header">
                            <div class="header-icon-wrapper">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h2>Participant Search Results</h2>
                            <p class="results-count">Found <strong>' . count($results) . '</strong> result(s)</p>
                          </div>';
                    
                    if (count($results) > 0) {
                        echo '<div class="table-wrapper">
                                <table class="table">
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
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        
                        foreach ($results as $row) {
                            $kd_ratio = $row['deaths'] > 0 ? round($row['kills'] / $row['deaths'], 2) : $row['kills'];
                            
                            // Determine badge color
                            if ($kd_ratio > 1) {
                                $badge_class = 'badge-kd-positive';
                            } elseif ($kd_ratio == 1) {
                                $badge_class = 'badge-kd-neutral';
                            } else {
                                $badge_class = 'badge-kd-negative';
                            }
                            
                            echo '<tr>
                                    <td><strong>#' . $row['id'] . '</strong></td>
                                    <td>' . htmlspecialchars($row['firstname']) . '</td>
                                    <td>' . htmlspecialchars($row['surname']) . '</td>
                                    <td>' . htmlspecialchars($row['email']) . '</td>
                                    <td><span class="badge-custom badge-kills"><i class="fas fa-crosshairs me-1"></i>' . $row['kills'] . '</span></td>
                                    <td><span class="badge-custom badge-deaths"><i class="fas fa-skull me-1"></i>' . $row['deaths'] . '</span></td>
                                    <td><span class="badge-custom ' . $badge_class . '">' . $kd_ratio . '</span></td>
                                    <td>' . htmlspecialchars($row['team_name']) . '</td>
                                    <td>' . htmlspecialchars($row['location']) . '</td>
                                  </tr>';
                        }
                        
                        echo '</tbody></table></div>';
                    } else {
                        echo '<div class="no-results">
                                <i class="fas fa-search"></i>
                                <h3>No Results Found</h3>
                                <p>No participants match your search criteria.</p>
                              </div>';
                    }
                    
                } else {
                    // Search for a team
                    $search_term = '%' . trim($_POST['team']) . '%';
                    
                    $sql = "SELECT * FROM team WHERE name LIKE :search";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':search', $search_term);
                    $stmt->execute();
                    $team_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (count($team_results) > 0) {
                        foreach ($team_results as $team) {
                            // Get team members
                            $sql = "SELECT * FROM participant WHERE team_id = :team_id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':team_id', $team['id']);
                            $stmt->execute();
                            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            // Calculate team stats
                            $total_kills = 0;
                            $total_deaths = 0;
                            
                            foreach ($members as $member) {
                                $total_kills += $member['kills'];
                                $total_deaths += $member['deaths'];
                            }
                            
                            $team_kd = $total_deaths > 0 ? round($total_kills / $total_deaths, 2) : $total_kills;
                            
                            echo '<div class="results-header">
                                    <div class="header-icon-wrapper">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                  </div>';
                            
                            // Team stats card
                            echo '<div class="team-stats-card">
                                    <div class="team-name"><i class="fas fa-shield-alt me-3"></i>' . htmlspecialchars($team['name']) . '</div>
                                    <div class="team-location"><i class="fas fa-map-marker-alt"></i>' . htmlspecialchars($team['location']) . '</div>
                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="stat-box">
                                                <div class="stat-number">' . count($members) . '</div>
                                                <div class="stat-label">Players</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="stat-box">
                                                <div class="stat-number">' . $total_kills . '</div>
                                                <div class="stat-label">Total Kills</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="stat-box">
                                                <div class="stat-number">' . $total_deaths . '</div>
                                                <div class="stat-label">Total Deaths</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="stat-box">
                                                <div class="stat-number">' . $team_kd . '</div>
                                                <div class="stat-label">K/D Ratio</div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>';
                            
                            // Team members table
                            echo '<h4 class="section-title"><i class="fas fa-users"></i>Team Members</h4>
                                  <div class="table-wrapper">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>First Name</th>
                                                <th>Surname</th>
                                                <th>Email</th>
                                                <th>Kills</th>
                                                <th>Deaths</th>
                                                <th>K/D Ratio</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                            
                            foreach ($members as $member) {
                                $kd_ratio = $member['deaths'] > 0 ? round($member['kills'] / $member['deaths'], 2) : $member['kills'];
                                
                                if ($kd_ratio > 1) {
                                    $badge_class = 'badge-kd-positive';
                                } elseif ($kd_ratio == 1) {
                                    $badge_class = 'badge-kd-neutral';
                                } else {
                                    $badge_class = 'badge-kd-negative';
                                }
                                
                                echo '<tr>
                                        <td><strong>#' . $member['id'] . '</strong></td>
                                        <td>' . htmlspecialchars($member['firstname']) . '</td>
                                        <td>' . htmlspecialchars($member['surname']) . '</td>
                                        <td>' . htmlspecialchars($member['email']) . '</td>
                                        <td><span class="badge-custom badge-kills"><i class="fas fa-crosshairs me-1"></i>' . $member['kills'] . '</span></td>
                                        <td><span class="badge-custom badge-deaths"><i class="fas fa-skull me-1"></i>' . $member['deaths'] . '</span></td>
                                        <td><span class="badge-custom ' . $badge_class . '">' . $kd_ratio . '</span></td>
                                      </tr>';
                            }
                            
                            echo '</tbody></table></div>';
                        }
                    } else {
                        echo '<div class="results-header">
                                <div class="header-icon-wrapper">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h2>Team Search Results</h2>
                              </div>
                              <div class="no-results">
                                <i class="fas fa-search"></i>
                                <h3>No Results Found</h3>
                                <p>No teams match your search criteria.</p>
                              </div>';
                    }
                }
            }
            catch(PDOException $e) {
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
        // Row hover animation
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.animation = `fadeIn 0.4s ease-out ${index * 0.05}s both`;
        });

        // Add fade in animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateX(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>