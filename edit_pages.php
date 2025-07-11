<!-- filepath: /c:/xampp/htdocs/Robocart/edit_pages.php -->
<?php
session_start();
error_reporting(0);
include('config.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_POST['submit'] == "Update") {
    $page_name = $_GET['page_name'];
    $page_content = $_POST['page_content'];

    $sql = "UPDATE pages SET content = :page_content WHERE page_name = :page_name";
    $query = $conn->prepare($sql);
    $query->bindParam(':page_name', $page_name, PDO::PARAM_STR);
    $query->bindParam(':page_content', $page_content, PDO::PARAM_STR);
    $query->execute();
    $msg = "Page data updated successfully";
}

// Fetch all pages data
$sql_all_pages = "SELECT * FROM pages";
$query_all_pages = $conn->prepare($sql_all_pages);
$query_all_pages->execute();
$all_pages = $query_all_pages->fetchAll(PDO::FETCH_ASSOC);

// Fetch content of the selected page
$page_content = '';
if (isset($_GET['page_name'])) {
    $page_name = $_GET['page_name'];
    $sql_page_content = "SELECT content FROM pages WHERE page_name = :page_name";
    $query_page_content = $conn->prepare($sql_page_content);
    $query_page_content->bindParam(':page_name', $page_name, PDO::PARAM_STR);
    $query_page_content->execute();
    $page_content = $query_page_content->fetch(PDO::FETCH_ASSOC)['content'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pages - Robocart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-family: Arial, sans-serif;
        }
        .dashboard-container {
            margin-top: 50px;
        } 
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            border-radius: 15px 15px 0 0;
            color: #fff;
        }
        .card-body {
            padding: 20px;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="sidebar">
<a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
<a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
        <a href="add_shops.php"><i class="fas fa-plus-circle"></i> Add Shop</a>
        <a href="insert_product.php"><i class="fas fa-plus-circle"></i> Insert Product</a>
        <a href="manage_products.php"><i class="fas fa-boxes"></i> Manage Products</a>
        <a href="edit_pages.php"><i class="fas fa-edit"></i> Edit Pages</a>
        <a href="contact_shops.php"><i class="fas fa-address-book"></i> Contact Shops</a> 
       
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <div class="container dashboard-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4>Edit Pages</h4>
                        </div>
                        <div class="card-body">
                            <?php if (isset($msg)): ?>
                                <div class="alert alert-success">
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="page_name" class="form-label">Page Name</label>
                                    <select class="form-select" id="page_name" name="page_name" onchange="location = this.value;">
                                        <option value="">Select a page</option>
                                        <?php foreach ($all_pages as $page): ?>
                                            <option value="edit_pages.php?page_name=<?php echo $page['page_name']; ?>" <?php echo (isset($page_name) && $page_name == $page['page_name']) ? 'selected' : ''; ?>><?php echo $page['page_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="page_content" class="form-label">Page Content</label>
                                    <textarea class="form-control" id="page_content" name="page_content" rows="10"><?php echo htmlspecialchars($page_content); ?></textarea>
                                </div>
                                <button type="submit" name="submit" value="Update" class="btn btn-primary">Update Page</button>
                            </form>
                        </div>
                        <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
                        <script>
                            CKEDITOR.replace('page_content');
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>