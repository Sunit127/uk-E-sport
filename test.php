<?php
// PHP Environment Test Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Environment Test - E-Sports League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00d4ff;
            --secondary: #7b2ff7;
            --success: #00ffc8;
            --danger: #ff006e;
            --dark: #0a0e27;
            --gradient-1: linear-gradient(135deg, #00d4ff 0%, #7b2ff7 100%);
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--dark);
            color: white;
            padding: 40px 20px;
            position: relative;
        }

        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(0, 212, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 212, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 10;
            max-width: 900px;
            margin: 0 auto;
        }

        .test-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 30px;
        }

        .test-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-1);
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 900;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 30px;
            text-align: center;
        }

        h2 {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-success {
            color: var(--success);
            background: rgba(0, 255, 200, 0.1);
            padding: 12px 20px;
            border-radius: 10px;
            border-left: 4px solid var(--success);
            margin-bottom: 15px;
        }

        .status-error {
            color: var(--danger);
            background: rgba(255, 0, 110, 0.1);
            padding: 12px 20px;
            border-radius: 10px;
            border-left: 4px solid var(--danger);
            margin-bottom: 15px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 12px;
            border: 1px solid rgba(0, 212, 255, 0.2);
        }

        .info-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .info-value {
            color: var(--primary);
            font-weight: 600;
            font-size: 1.1rem;
        }

        code {
            background: rgba(0, 0, 0, 0.3);
            padding: 2px 8px;
            border-radius: 4px;
            color: var(--success);
        }
    </style>
</head>
<body>
    <div class="grid-overlay"></div>
    
    <div class="container">
        <h1><i class="fas fa-server me-3"></i>PHP Environment Test</h1>
        
        <!-- PHP Status -->
        <div class="test-card">
            <h2><i class="fas fa-check-circle"></i>PHP Status</h2>
            <?php
            echo '<div class="status-success">
                    <i class="fas<i class="fas fa-check-circle me-2"></i>
                    <strong>PHP is working correctly!</strong>
                  </div>';
            
            echo '<div class="info-grid">';
            echo '<div class="info-item">
                    <div class="info-label">PHP Version</div>
                    <div class="info-value">' . phpversion() . '</div>
                  </div>';
            
            echo '<div class="info-item">
                    <div class="info-label">Server Software</div>
                    <div class="info-value">' . $_SERVER['SERVER_SOFTWARE'] . '</div>
                  </div>';
            
            echo '<div class="info-item">
                    <div class="info-label">Document Root</div>
                    <div class="info-value">' . $_SERVER['DOCUMENT_ROOT'] . '</div>
                  </div>';
            
            echo '<div class="info-item">
                    <div class="info-label">Server Name</div>
                    <div class="info-value">' . $_SERVER['SERVER_NAME'] . '</div>
                  </div>';
            echo '</div>';
            ?>
        </div>

        <!-- Database Connection Test -->
        <div class="test-card">
            <h2><i class="fas fa-database"></i>Database Connection</h2>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "esports_db";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                echo '<div class="status-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Database connection successful!</strong>
                      </div>';
                
                // Get database info
                $stmt = $conn->query("SELECT DATABASE() as db_name");
                $db_info = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Get table count
                $stmt = $conn->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                echo '<div class="info-grid">';
                echo '<div class="info-item">
                        <div class="info-label">Database Name</div>
                        <div class="info-value">' . $db_info['db_name'] . '</div>
                      </div>';
                
                echo '<div class="info-item">
                        <div class="info-label">Total Tables</div>
                        <div class="info-value">' . count($tables) . '</div>
                      </div>';
                
                echo '<div class="info-item">
                        <div class="info-label">Connection Host</div>
                        <div class="info-value">' . $servername . '</div>
                      </div>';
                
                echo '<div class="info-item">
                        <div class="info-label">Database User</div>
                        <div class="info-value">' . $username . '</div>
                      </div>';
                echo '</div>';
                
                // List tables
                echo '<div style="margin-top: 20px;">
                        <div class="info-label" style="margin-bottom: 10px;">Available Tables:</div>';
                foreach ($tables as $table) {
                    echo '<code style="margin-right: 10px; margin-bottom: 5px; display: inline-block;">' . $table . '</code>';
                }
                echo '</div>';
                
            } catch(PDOException $e) {
                echo '<div class="status-error">
                        <i class="fas fa-times-circle me-2"></i>
                        <strong>Database connection failed!</strong><br>
                        <small>Error: ' . $e->getMessage() . '</small>
                      </div>';
            }
            ?>
        </div>

        <!-- PHP Extensions -->
        <div class="test-card">
            <h2><i class="fas fa-puzzle-piece"></i>PHP Extensions</h2>
            <?php
            $required_extensions = ['pdo', 'pdo_mysql', 'mysqli', 'json', 'session'];
            
            echo '<div class="info-grid">';
            foreach ($required_extensions as $ext) {
                $loaded = extension_loaded($ext);
                $status_class = $loaded ? 'status-success' : 'status-error';
                $icon = $loaded ? 'fa-check-circle' : 'fa-times-circle';
                $status_text = $loaded ? 'Loaded' : 'Not Loaded';
                
                echo '<div class="info-item">
                        <div class="info-label">' . strtoupper($ext) . '</div>
                        <div class="info-value" style="color: ' . ($loaded ? 'var(--success)' : 'var(--danger)') . ';">
                            <i class="fas ' . $icon . ' me-2"></i>' . $status_text . '
                        </div>
                      </div>';
            }
            echo '</div>';
            ?>
        </div>

        <!-- System Information -->
        <div class="test-card">
            <h2><i class="fas fa-info-circle"></i>System Information</h2>
            <?php
            echo '<div class="info-grid">';
            
            echo '<div class="info-item">
                    <div class="info-label">Operating System</div>
                    <div class="info-value">' . PHP_OS . '</div>
                  </div>';
            
            echo '<div class="info-item">
                    <div class="info-label">Max Execution Time</div>
                    <div class="info-value">' . ini_get('max_execution_time') . 's</div>
                  </div>';
            
            echo '<div class="info-item">
                    <div class="info-label">Memory Limit</div>
                    <div class="info-value">' . ini_get('memory_limit') . '</div>
                  </div>';
            
            echo '<div class="info-item">
                    <div class="info-label">Upload Max Filesize</div>
                    <div class="info-value">' . ini_get('upload_max_filesize') . '</div>
                  </div>';
            
            echo '<div class="info-item">
                    <div class="info-label">Post Max Size</div>
                    <div class="info-value">' . ini_get('post_max_size') . '</div>
                  </div>';
            
            echo '<div class="info-item">
                    <div class="info-label">Session Status</div>
                    <div class="info-value">' . (session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive') . '</div>
                  </div>';
            
            echo '</div>';
            ?>
        </div>

        <!-- Quick Links -->
        <div class="test-card">
            <h2><i class="fas fa-link"></i>Quick Links</h2>
            <div style="display: grid; gap: 10px;">
                <a href="index.html" style="color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-home"></i> Home Page
                </a>
                <a href="admin_login.html" style="color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-shield-alt"></i> Admin Login
                </a>
                <a href="register_form.html" style="color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-gift"></i> Register Form
                </a>
                <a href="test.html" style="color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-list"></i> All Links
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>