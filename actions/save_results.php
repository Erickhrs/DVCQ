<?php
session_start();
require_once('../includes/connection.php'); // Conexão com o banco de dados

$book = $_POST['book'];
$userId = $_POST['userId'];
$totalAnswered = $_POST['totalAnswered'];
$corrects = $_POST['corrects'];
$wrongs = $_POST['wrongs'];
$finishedTime = $_POST['finishedTime'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se todos os valores necessários estão definidos
    if (isset($_POST['book'], $_POST['userId'], $_POST['totalAnswered'], $_POST['corrects'], $_POST['wrongs'], $_POST['finishedTime'])) {
        // Obtém os dados enviados via POST
      
        // Insere os dados na tabela users_books_results
        $stmt = $mysqli->prepare("INSERT INTO users_books_results (book, user_ID, total_answered, corrects, wrongs, finished_time) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('siiiis', $book, $userId, $totalAnswered, $corrects, $wrongs, $finishedTime);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar no banco de dados']);
        }

        $stmt->close();
        $mysqli->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados incompletos.']);
    }
}
?>