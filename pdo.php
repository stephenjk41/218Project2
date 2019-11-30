<?php
echo "<h1>Pdo demo</h1>";
$username = 'sjk28';
$password = '8XOSLw8u';
$hostname = 'sql1.njit.edu';
$dsn = "mysql:host=$hostname;dbname=$username";
try {
    $db = new PDO($dsn, $username, $password);
    echo "Connected successfully<br>";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
