$username = 'root';
$host = 'localhost';
$mdp = '';
$dbname = 'evote_db.sql';
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $mdp);
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $mdp);
    // Configurations PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}




