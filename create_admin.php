<?php
include 'dbconnect.php';

// The password you want to use
$plain_password = 'password123';

// Generate a proper hash
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

echo "<h2>Password Hash Generator</h2>";
echo "<p><strong>Plain Password:</strong> " . $plain_password . "</p>";
echo "<p><strong>Generated Hash:</strong> " . $hashed_password . "</p>";
echo "<hr>";

try {
    // Connect to database
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Update the admin password
    $sql = "UPDATE user SET password = :password WHERE username = 'admin'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();
    
    echo "<p style='color: green;'><strong>✓ Admin password updated successfully!</strong></p>";
    echo "<p>You can now login with:</p>";
    echo "<ul>";
    echo "<li><strong>Username:</strong> admin</li>";
    echo "<li><strong>Password:</strong> password123</li>";
    echo "</ul>";
    
    // Verify it works
    $stmt = $conn->query("SELECT password FROM user WHERE username = 'admin'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<hr>";
    echo "<h3>Verification Test:</h3>";
    $verify = password_verify($plain_password, $result['password']);
    echo "<p>Password verification: " . ($verify ? "<span style='color:green;'>✓ SUCCESS</span>" : "<span style='color:red;'>✗ FAILED</span>") . "</p>";
    
    if ($verify) {
        echo "<p style='color: green; font-weight: bold;'>✓ Login should work now! Go to <a href='admin_login.html'>admin_login.html</a></p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>