<?php
include_once '../includes/connection.php'; // Inclui a conexão com o banco de dados

if (isset($_POST['question_id'], $_POST['alternative'])) {
    $question_id = $mysqli->real_escape_string($_POST['question_id']);
    $alternative = $mysqli->real_escape_string($_POST['alternative']);

    // Consulta para verificar se a alternativa está correta
    $query = "SELECT answer FROM questions WHERE ID = '$question_id' LIMIT 1";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['answer'] == $alternative) {
            echo 'Correto!';
        } else {
            echo 'Errado!';
        }
    } else {
        echo 'Alternativa não encontrada.';
    }
} else {
    echo 'Dados inválidos.';
}
?>