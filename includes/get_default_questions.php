<?php
include_once './includes/connection.php'; // Inclui o arquivo de conexão

// Define o número de registros por página
$records_per_page = 2; // Ajuste conforme necessário

// Obtém o número da página atual da URL, se não estiver definido, assume a página 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calcula o OFFSET para a consulta SQL
$offset = ($page - 1) * $records_per_page;

// Consulta SQL para contar o número total de registros
$total_query = "SELECT COUNT(*) AS total FROM questions";
$total_result = $mysqli->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// Calcula o número total de páginas
$total_pages = ceil($total_records / $records_per_page);

// Consulta SQL para buscar as questões da página atual
$query = "SELECT * FROM questions LIMIT $offset, $records_per_page";
$result = $mysqli->query($query);

// Função para obter alternativas por ID da questão
function getAlternativesByQuestionId($mysqli, $question_id) {
    $stmt = $mysqli->prepare("SELECT alternative, answer FROM answers WHERE questions_ID = ? ORDER BY ID ASC");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $alternatives = [];

    while ($row = $result->fetch_assoc()) {
        $alternatives[$row['answer']] = $row['alternative'];
    }

    $stmt->close();
    return $alternatives;
}

// Verifica se há resultados
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Exibe as informações da questão
        echo '<form class="question">';
        echo '    <div id="question_infos">';
        echo '        <span class="span_number_list">#' . htmlspecialchars($row['ID']) . '</span>';
        echo '        <span class="span_about">' . htmlspecialchars($row['adms_ID']) . '</span>';
        echo '        <span class="span_about">' . htmlspecialchars($row['year']) . '</span>';
        echo '        <span class="span_about">' . htmlspecialchars($row['banca']) . '</span>';
        echo '        <span class="span_about">' . htmlspecialchars($row['level']) . '</span>';
        echo '        <span class="span_about">' . htmlspecialchars($row['question_type']) . '</span>';
        echo '        <span class="span_about">' . htmlspecialchars($row['subject']) . '</span>';
        echo '        <span class="span_about">' . htmlspecialchars($row['course']) . '</span>';
        echo '    </div>';
        echo '    <span id="question">' . $row['question'] . '</span>'; // Não usa htmlspecialchars aqui
        echo '    <div id="options">';
        
        // Obtém alternativas para a questão atual
        $alternatives = getAlternativesByQuestionId($mysqli, $row['ID']);
        
        foreach (['A', 'B', 'C', 'D', 'E'] as $option) {
            // Verifica se a alternativa existe para a opção atual
            $alternative_text = isset($alternatives[$option]) ? $alternatives[$option] : 'Não disponível';
            echo '    <div class="option">';
            echo '        <input type="radio" id="' . $option . $row['ID'] . '" name="answer' . $row['ID'] . '" value="' . $option . '">';
            echo '        <label for="' . $option . $row['ID'] . '" data-content="' . $option . '">' . "OPÇÃO " . $option . ': ' . htmlspecialchars($alternative_text) . '</label>';
            echo '    </div>';
        }

        echo '    </div>';
        echo '    <div id="question_tools">';
        echo '        <button type="submit" id="answerValidate">Responder</button>';
        echo '        <div id="tools">';
        echo '            <span><ion-icon name="chatbox-outline"></ion-icon> Gabarito</span>';
        echo '            <span><i class="bx bx-paperclip"></i>Gabarito</span>';
        echo '            <span><ion-icon name="chatbubbles-outline"></ion-icon>Comentários</span>';
        echo '            <span><ion-icon name="analytics-outline"></ion-icon>Estátisticas</span>';
        echo '            <span><ion-icon name="document-outline"></ion-icon>Criar Anotações</span>';
        echo '            <span><ion-icon name="flag-outline"></ion-icon>Erro</span>';
        echo '        </div>';
        echo '    </div>';
        echo '</form>';
    }
} else {
    echo 'Nenhuma questão encontrada.';
}

// Exibe links de navegação para as páginas
if ($total_pages > 1) {
    echo '<div class="pagination">';
    if ($page > 1) {
        echo '<a href="?page=' . ($page - 1) . '">&laquo; Anterior</a>';
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo '<span class="current">' . $i . '</span>';
        } else {
            echo '<a href="?page=' . $i . '">' . $i . '</a>';
        }
    }
    if ($page < $total_pages) {
        echo '<a href="?page=' . ($page + 1) . '">Próximo &raquo;</a>';
    }
    echo '</div>';
}

// Fecha a conexão
$mysqli->close();
?>