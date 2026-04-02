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
    <title>Merchandise Registrations - E-Sports League</title>
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
            --gradient-4: linear-gradient(135deg, #ffb800 0%, #ff006e 100%);
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
            background: radial-gradient(circle at 20% 30%, rgba(255, 184, 0, 0.08) 0%, transparent 50%),
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
                linear-gradient(rgba(255, 184, 0, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 184, 0, 0.02) 1px, transparent 1px);
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
            border: 2px solid rgba(255, 184, 0, 0.3);
            color: var(--warning);
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
            background: rgba(255, 184, 0, 0.1);
            border-color: var(--warning);
            color: var(--warning);
            transform: translateX(-5px);
            box-shadow: 0 5px 20px rgba(255, 184, 0, 0.3);
        }

        /* Page Card */
        .page-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 184, 0, 0.2);
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

        .header-icon {
            width: 90px;
            height: 90px;
            background: var(--gradient-4);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: icon-bounce 2s ease-in-out infinite;
            box-shadow: 0 10px 40px rgba(255, 184, 0, 0.5);
        }

        @keyframes icon-bounce {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }

        .header-icon i {
            font-size: 3rem;
            color: white;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 900;
            background: var(--gradient-4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.1rem;
        }

        /* Stats Row */
        .stats-row {
            background: var(--gradient-4);
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 35px;
            box-shadow: 0 15px 40px rgba(255, 184, 0, 0.3);
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
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Search & Export Bar */
        .action-bar {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .search-wrapper {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 184, 0, 0.2);
            border-radius: 15px;
            color: var(--light);
            font-size: 1rem;
            transition: all 0.4s;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--warning);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(255, 184, 0, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--warning);
            font-size: 1.2rem;
        }

        .btn-export {
            background: var(--gradient-4);
            border: none;
            color: white;
            padding: 15px 35px;
            border-radius: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s;
            box-shadow: 0 5px 20px rgba(255, 184, 0, 0.3);
            white-space: nowrap;
        }

        .btn-export:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 184, 0, 0.5);
        }

        /* Table */
        .table-wrapper {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 184, 0, 0.2);
            border-radius: 18px;
            overflow: hidden;
        }

        .table {
            color: var(--light);
            margin: 0;
        }

        .table thead {
            background: var(--gradient-4);
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
            border-bottom: 1px solid rgba(255, 184, 0, 0.1);
            transition: all 0.3s;
        }

        .table tbody tr:hover {
            background: rgba(255, 184, 0, 0.05);
            transform: scale(1.005);
        }

        .table tbody td {
            padding: 18px 20px;
            border: none;
            vertical-align: middle;
        }

        /* Badges */
        .badge-accepted {
            background: rgba(0, 255, 200, 0.2);
            color: var(--success);
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Footer */
        .table-footer {
            margin-top: 30px;
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 15px;
            border: 1px solid rgba(255, 184, 0, 0.1);
        }

        .table-footer p {
            color: rgba(255, 255, 255, 0.6);
            margin: 0;
        }

        /* No Data State */
        .no-data {
            text-align: center;
            padding: 60px 20px;
        }

        .no-data i {
            font-size: 4rem;
            background: var(--gradient-4);
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

        /* Responsive */
        @media (max-width: 768px) {
            .page-card {
                padding: 25px 20px;
            }
            .page-header h1 {
                font-size: 2rem;
            }
            .header-icon {
                width: 75px;
                height: 75px;
            }
            .header-icon i {
                font-size: 2.5rem;
            }
            .stat-number {
                font-size: 2.5rem;
            }
            .action-bar {
                flex-direction: column;
            }
            .btn-export {
                width: 100%;
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

    <!-- Main Container -->
    <div class="main-container">
        <a href="admin_menu.php" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>

        <div class="page-card">
            <div class="page-header">
                <div class="header-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <h1>Merchandise Orders</h1>
                <p>View all merchandise registrations and export data</p>
            </div>

            <?php
            include 'dbconnect.php';
        
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Get total count
                $sql = "SELECT COUNT(*) as total FROM merchandise";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $count = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Get all merchandise registrations
                $sql = "SELECT * FROM merchandise ORDER BY registered_at DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Calculate stats
                $totalRegistrations = $count['total'];
                $thisMonth = 0;
                $thisWeek = 0;
                
                foreach ($results as $row) {
                    $regDate = strtotime($row['registered_at']);
                    if ($regDate >= strtotime('-30 days')) $thisMonth++;
                    if ($regDate >= strtotime('-7 days')) $thisWeek++;
                }
                
                // Display stats
                echo '<div class="stats-row">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stat-box">
                                    <div class="stat-number">' . $totalRegistrations . '</div>
                                    <div class="stat-label">Total Orders</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-box">
                                    <div class="stat-number">' . $thisMonth . '</div>
                                    <div class="stat-label">This Month</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-box">
                                    <div class="stat-number">' . $thisWeek . '</div>
                                    <div class="stat-label">This Week</div>
                                </div>
                            </div>
                        </div>
                      </div>';

                if (count($results) > 0) {
                    echo '<div class="action-bar">
                            <div class="search-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" class="search-input" id="searchInput" placeholder="Search by name or email...">
                            </div>
                            <button onclick="exportToCSV()" class="btn-export">
                                <i class="fas fa-download me-2"></i>Export CSV
                            </button>
                          </div>';
                    
                    echo '<div class="table-wrapper">
                            <table class="table" id="merchandiseTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Surname</th>
                                        <th>Email</th>
                                        <th>Terms</th>
                                        <th>Registration Date</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    
                    foreach ($results as $row) {
                        $registered_date = isset($row['registered_at']) ? date('M d, Y H:i', strtotime($row['registered_at'])) : 'N/A';
                        
                        echo '<tr>
                                <td><strong>#' . $row['id'] . '</strong></td>
                                <td>' . htmlspecialchars($row['firstname']) . '</td>
                                <td>' . htmlspecialchars($row['surname']) . '</td>
                                <td>' . htmlspecialchars($row['email']) . '</td>
                                <td><span class="badge-accepted"><i class="fas fa-check-circle me-1"></i>Accepted</span></td>
                                <td>' . $registered_date . '</td>
                              </tr>';
                    }
                    
                    echo '</tbody></table></div>';
                    
                    echo '<div class="table-footer">
                            <p><i class="fas fa-database me-2"></i>Total Records: <strong>' . count($results) . '</strong></p>
                          </div>';
                } else {
                    echo '<div class="no-data">
                            <i class="fas fa-inbox"></i>
                            <h3>No Orders Yet</h3>
                            <p>No merchandise registrations found in the database.</p>
                          </div>';
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
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('merchandiseTable');

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

        // Export to CSV
        function exportToCSV() {
            const table = document.getElementById('merchandiseTable');
            let csv = [];
            const rows = table.querySelectorAll('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = [], cols = rows[i].querySelectorAll('td, th');
                
                for (let j = 0; j < cols.length; j++) {
                    let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ');
                    data = data.replace(/"/g, '""');
                    row.push('"' + data + '"');
                }
                
                csv.push(row.join(','));
            }
            
            // Download CSV
            const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
            const downloadLink = document.createElement('a');
            downloadLink.download = 'merchandise_orders_' + new Date().toISOString().slice(0,10) + '.csv';
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = 'none';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        // Add animations
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

        // Button ripple effect
        document.querySelector('.btn-export').addEventListener('click', function(e) {
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