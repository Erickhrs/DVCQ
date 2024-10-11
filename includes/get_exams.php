<?php
// Incluindo conexão ao banco de dados

// Consultando todos os simulados
$result = $mysqli->query("SELECT id, title, description, questions, created_at FROM exams ORDER BY created_at DESC");

// Verificando se há resultados e gerando o HTML
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $title = htmlspecialchars($row['title']);
        $description = htmlspecialchars($row['description']); // Captura a descrição
        $questionsCount = htmlspecialchars($row['questions']);
        $createdAt = htmlspecialchars(date('d/m/Y', strtotime($row['created_at'])));
        $id = htmlspecialchars($row['id']);
        
        // Gerando o card para cada simulado
        echo '<div class="simulado-card" onclick="window.location=\'detalhes_simulado.php?id=' . $id . '\';" style="cursor: pointer;">';
        echo '<h2>' . $title . '</h2>';
        echo '<p>' . $description . '</p>'; // Adiciona a descrição aqui
        echo '<p>' . $questionsCount . ' questões</p>';
        echo '<div class="footer-card">';
        echo '<i class="fa fa-calendar"></i>';
        echo '<span>' . $createdAt . '/ </span>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p class="no-data">Nenhum simulado encontrado.</p>';
}
?>