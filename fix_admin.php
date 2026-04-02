<?php
include 'dbconnect.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Generate a REAL hash for password123
    $correct_hash = password_hash('password123', PASSWORD_DEFAULT);
    
    echo "<h2>🔧 Fixing Admin Password</h2>";
    echo "<p><strong>New Hash Generated:</strong> " . $correct_hash . "</p>";
    echo "<hr>";
    
    // Update admin user
    $sql = "UPDATE user SET password = :password WHERE username = 'admin'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':password', $correct_hash);
    $stmt->execute();
    
    echo "<p style='color: green; font-size: 20px;'><strong>✓ Admin password updated!</strong></p>";
    
    // Verify it works NOW
    $stmt = $conn->query("SELECT password FROM user WHERE username = 'admin'");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $test_verify = password_verify('password123', $user['password']);
    
    echo "<h3>✅ Verification Test:</h3>";
    echo "<p><strong>Test Password:</strong> password123</p>";
    echo "<p><strong>Result:</strong> " . ($test_verify ? "<span style='color:green; font-size: 18px;'>✓ SUCCESS!</span>" : "<span style='color:red;'>✗ FAILED</span>") . "</p>";
    
    if ($test_verify) {
        echo "<hr>";
        echo "<div style='background: #00ffc8; color: #0a0e27; padding: 20px; border-radius: 10px; margin-top: 20px;'>";
        echo "<h3>🎉 LOGIN IS NOW FIXED!</h3>";
        echo "<p><strong>Username:</strong> admin</p>";
        echo "<p><strong>Password:</strong> password123</p>";
        echo "<p><a href='admin_login.html' style='color: #0a0e27; font-weight: bold;'>→ GO TO LOGIN PAGE</a></p>";
        echo "</div>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>