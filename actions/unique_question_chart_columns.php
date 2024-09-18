<?php
include_once '../includes/connection.php';

// Obtém o ID da questão da URL
$question_id = isset($_GET['question_id']) ? $mysqli->real_escape_string($_GET['question_id']) : '';

if ($question_id) {
    // Inicializa o array de contagem
    $counts = [
        'A' => 0,
        'B' => 0,
        'C' => 0,
        'D' => 0,
        'E' => 0,
        '0' => 0,
        '1' => 0
    ];
    
    // Consulta para contar as respostas para cada alternativa
    $query = "SELECT answer, COUNT(*) as count FROM users_answers WHERE question_ID = '$question_id' GROUP BY answer";
    $result = $mysqli->query($query);

    while ($row = $result->fetch_assoc()) {
        if (isset($counts[$row['answer']])) {
            $counts[$row['answer']] = $row['count'];
        }
    }

    // Calcula o total de respostas para calcular as porcentagens
    $total = array_sum($counts);
    $percentages = [];

    foreach ($counts as $answer => $count) {
        $percentages[$answer] = $total > 0 ? ($count / $total) * 100 : 0;
    }

    // Retorna o JSON com as porcentagens
    header('Content-Type: application/json');
    echo json_encode($percentages);
}

$mysqli->close();
?>