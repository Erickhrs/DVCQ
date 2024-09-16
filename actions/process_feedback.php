<?php
include('../includes/connection.php'); // Certifique-se de que o caminho está correto

$data = json_decode(file_get_contents('php://input'), true);

$user_ID = isset($data['user_ID']) ? intval($data['user_ID']) : 0;
$question_ID = isset($data['question_ID']) ? trim($data['question_ID']) : '';
$feedback = isset($data['feedback']) ? trim($data['feedback']) : '';

if ($user_ID && $question_ID && $feedback) {
    // Verifica a conexão
    if ($mysqli->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'Falha na conexão com o banco de dados']);
        exit;
    }

    // Prepara e executa a consulta
    $stmt = $mysqli->prepare("INSERT INTO feedbacks (user_ID, question_ID, feedback) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_ID, $question_ID, $feedback);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Feedback enviado com sucesso']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao inserir feedback']);
    }

    $stmt->close();
    $mysqli->close();
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
}
?>