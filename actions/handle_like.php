<?php
session_start();
include_once '../includes/connection.php'; // Inclui o arquivo de conexão

if (isset($_SESSION['id']) && isset($_POST['question_id'])) {
    $user_id = $_SESSION['id'];
    $question_id = $mysqli->real_escape_string($_POST['question_id']);
    
    // Verifica se o usuário já curtiu a questão
    $check_like_query = "SELECT * FROM users_likes WHERE user_ID = '$user_id' AND question_ID = '$question_id'";
    $check_like_result = $mysqli->query($check_like_query);
    
    if ($check_like_result->num_rows > 0) {
        // Se já tiver curtido, remove a curtida
        $delete_like_query = "DELETE FROM users_likes WHERE user_ID = '$user_id' AND question_ID = '$question_id'";
        $mysqli->query($delete_like_query);
        echo json_encode(['status' => 'removed']);
    } else {
        // Caso contrário, adiciona a curtida
        $date = date('Y-m-d H:i:s');
        $insert_like_query = "INSERT INTO users_likes (user_ID, question_ID, date) VALUES ('$user_id', '$question_id', '$date')";
        $mysqli->query($insert_like_query);
        echo json_encode(['status' => 'added']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

$mysqli->close();
?>