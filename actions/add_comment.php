<?php
include('../includes/connection.php');
session_start();

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do POST
    $question_ID = isset($_POST['question_ID']) ? $_POST['question_ID'] : '';
    $user_ID = $_SESSION['id'];
    $picture = $_SESSION['picture'];
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    // Valida os dados
    if (empty($question_ID) || empty($user_ID) || empty($comment)) {
        echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
        exit();
    }

    // Prepara a consulta para inserir o comentário
    $stmt = $mysqli->prepare("INSERT INTO comments (question_ID, user_ID, picture, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $question_ID, $user_ID, $picture, $comment);

    // Executa a consulta
    if ($stmt->execute()) {
        // Retorna sucesso
        echo json_encode(['success' => true]);
    } else {
        // Retorna erro
        echo json_encode(['success' => false, 'message' => 'Erro ao adicionar comentário.']);
    }

    // Fecha a declaração
    $stmt->close();
} else {
    // Se não for um POST, retorna erro
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
}

// Fecha a conexão com o banco de dados
$mysqli->close();
?>