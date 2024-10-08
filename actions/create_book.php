<?php
session_start();
include('../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notebookName = $_POST['name'];
    $userId = $_SESSION['id'];

    // Prepara a consulta para inserir o novo caderno
    $stmt = $mysqli->prepare("INSERT INTO users_books (name, owner, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $notebookName, $userId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
}
?>