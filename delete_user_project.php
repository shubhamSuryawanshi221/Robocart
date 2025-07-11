<!-- filepath: /c:/xampp/htdocs/Robocart/delete_user_project.php -->
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

include 'config.php';

$project_id = $_GET['id'];

$sql_delete = "DELETE FROM user_projects WHERE id = :project_id";
$query_delete = $conn->prepare($sql_delete);
$query_delete->bindParam(':project_id', $project_id, PDO::PARAM_INT);
$query_delete->execute();

header('Location: admin_dashboard.php');
exit();
?>