<!-- filepath: /c:/xampp/htdocs/Robocart/suggestions.php -->
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "robocart";

try {
    // Create connection using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get the search query
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Fetch product suggestions matching the search query
$sql = "SELECT name FROM products WHERE name LIKE :searchTerm LIMIT 5";
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $query . '%';
$stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$stmt->execute();
$suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($suggestions) > 0) {
    foreach ($suggestions as $suggestion) {
        echo '<div class="suggestion-item">' . htmlspecialchars($suggestion['name']) . '</div>';
    }
} else {
    echo '<div class="suggestion-item">No suggestions found</div>';
}

// Close connection
$conn = null;
?>