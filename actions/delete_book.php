<?php
include('../includes/connection.php');
include('../includes/functions.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookId = $_POST['id'];
    $userId = $_SESSION['id'];

    // Prepara a consulta de exclusão
    $stmt = $mysqli->prepare("DELETE FROM users_books WHERE ID = ? AND owner = ?");
    $stmt->bind_param("is", $bookId, $userId); // 'i' para inteiro e 's' para string
    $stmt->execute();

    // Redireciona de volta com uma mensagem de sucesso
    if ($stmt->affected_rows > 0) {
        header("Location: ../books.php?msg=Livro excluído com sucesso.");
    } else {
        header("Location: ../books.php?msg=Erro ao excluir livro.");
    }

    // Fecha a declaração
    $stmt->close();
}
?>