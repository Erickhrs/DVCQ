<?php
include_once '../includes/connection.php';
session_start();
function saveAnswer($mysqli, $user, $question, $userAnswer, $correct, $data) {
    // Usa prepared statements para evitar SQL Injection
    $query_insert = "INSERT INTO users_answers (user_ID, question_ID, answer, is_correct, answer_date) 
                     VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $mysqli->prepare($query_insert)) {
        // Bind dos parâmetros
        $stmt->bind_param('issis', $user, $question, $userAnswer, $correct, $data);
        
        // Executa a instrução
        $stmt->execute();
        
        // Fecha a instrução
        $stmt->close();
    } else {
        echo "Erro ao preparar a instrução: " . $mysqli->error;
    }
}

if (isset($_POST['question_id'], $_POST['alternative'])) {
    $question_id = $mysqli->real_escape_string($_POST['question_id']);
    $alternative = $mysqli->real_escape_string($_POST['alternative']);

    // Consulta para verificar se a alternativa está correta
    $query = "SELECT answer FROM questions WHERE ID = '$question_id' LIMIT 1";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['answer'] == $alternative) {
         saveAnswer($mysqli, $_SESSION['id'], $question_id, $alternative, 1, date('Y-m-d'));
            echo 'correct';
        } else {
          saveAnswer($mysqli, $_SESSION['id'], $question_id, $alternative, 0, date('Y-m-d'));
            echo 'wrong';
        }
    } else {
        echo 'Alternativa não encontrada.';
    }
} else {
    echo 'Dados inválidos.';
}
?>