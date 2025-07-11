<?php
session_start();

include 'config.php';

if (!isset($_SESSION['login_user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$username = $_SESSION['login_user'];
$post = $_SESSION['login_post'];

// Get the search query
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Fetch products matching the search query
$sql = "SELECT * FROM products WHERE name LIKE :searchTerm";
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $query . '%';
$stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .suggestions {
            border: 1px solid #ccc;
            border-top: none;
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            width: 100%;
            z-index: 1000;
            background-color: #fff;
        }
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }
        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <h2 class="text-center">Search Products</h2>
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <input type="text" id="search-input" class="form-control" placeholder="Search for products...">
                <div id="suggestions" class="suggestions"></div>
            </div>
        </div>
        <h2 class="text-center">Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4" id="search-results">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                <!-- Removed price and discount -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No products found matching your search query.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search-input').on('input', function() {
                var query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: 'suggestions.php',
                        method: 'GET',
                        data: { query: query },
                        success: function(data) {
                            $('#suggestions').html(data);
                        }
                    });
                } else {
                    $('#suggestions').html('');
                }
            });

            $(document).on('click', '.suggestion-item', function() {
                var text = $(this).text();
                $('#search-input').val(text);
                $('#suggestions').html('');
                searchProducts(text);
            });

            function searchProducts(query) {
                $.ajax({
                    url: 'search.php',
                    method: 'GET',
                    data: { query: query },
                    success: function(data) {
                        $('#search-results').html($(data).find('#search-results').html());
                    }
                });
            }
        });
    </script>
</body>
</html>

<?php
// Close connection
$conn = null;
?>