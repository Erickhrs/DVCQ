<?php
session_start();
include('../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $note = $_POST['note'];
    $question_ID = $_POST['question_ID'];
    $user_ID = $_SESSION['id']; // Supondo que o ID do usuário esteja na sessão

    // Prepara a consulta para inserir a nova nota
    $stmt = $mysqli->prepare("INSERT INTO users_notes (user_ID, question_ID, note, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $user_ID, $question_ID, $note); // 'i' para integer, 's' para string

    // Executa a consulta
    if ($stmt->execute()) {
        echo "Nota adicionada com sucesso!";
    } else {
        echo "Erro ao adicionar nota: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
}
?>