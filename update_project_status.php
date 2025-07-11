<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['project_id'], $_POST['action'])) {
    $project_id = $_POST['project_id'];
    $action = $_POST['action'];

    try {
        // Update project status
        $status = ($action === 'accept') ? 'Accepted' : 'Rejected';
        $sql_update = "UPDATE projects SET status = :status WHERE id = :project_id";
        $query_update = $conn->prepare($sql_update);
        $query_update->bindParam(':status', $status, PDO::PARAM_STR);
        $query_update->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $query_update->execute();

        // Fetch user email associated with the project
        $sql_user = "SELECT u.email FROM projects p JOIN users u ON p.user_id = u.id WHERE p.id = :project_id"; // Use 'user_id' as the linking column
        $query_user = $conn->prepare($sql_user);
        $query_user->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $query_user->execute();
        $user_email = $query_user->fetch(PDO::FETCH_ASSOC)['email'];

        // Send notification email to the user
        $subject = "Project Status Update";
        $message = "Your project has been " . strtolower($status) . ".";
        mail($user_email, $subject, $message);

        // Redirect back to the admin dashboard
        header('Location: admin_dashboard.php');
        exit();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header('Location: admin_dashboard.php');
    exit();
}
