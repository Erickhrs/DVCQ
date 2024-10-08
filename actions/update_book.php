<?php
include('../includes/connection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Atualizando o nome do livro
    $query = "UPDATE users_books SET name = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    $stmt->close();

    // Redirecionando após a atualização
    header("Location: ../books.php"); // Altere para sua página de sucesso
    exit();
}
?>