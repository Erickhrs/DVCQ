<?php
include_once '../includes/connection.php'; // Conexão com o banco

if (isset($_GET['question_ID'])) {
    $question_ID = $_GET['question_ID'];

    // Consulta para contar os acertos e erros
    $query = "SELECT 
                SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) AS correct_count, 
                SUM(CASE WHEN is_correct = 0 THEN 1 ELSE 0 END) AS incorrect_count
              FROM users_answers 
              WHERE question_ID = ?";
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $question_ID); // 's' porque question_ID é varchar
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    // Retorna os dados como JSON para uso no Chart.js
    echo json_encode($data);
}
?>