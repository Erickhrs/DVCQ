<?php
include_once './includes/connection.php'; // Inclui o arquivo de conexão

// Define o número de registros por página
$records_per_page = 1; // Ajuste para 1 registro por vez

// Construa a cláusula WHERE com base nos parâmetros do formulário
$conditions = [];

// Verifica e adiciona filtros baseados nos parâmetros do formulário
if (!empty($_GET['keys'])) {
    $conditions[] = "question LIKE '%" . $mysqli->real_escape_string($_GET['keys']) . "%'";
}
if (!empty($_GET['discipline'])) {
    $conditions[] = "discipline = '" . $mysqli->real_escape_string($_GET['discipline']) . "'";
}
if (!empty($_GET['subject'])) {
    $conditions[] = "subject = '" . $mysqli->real_escape_string($_GET['subject']) . "'";
}
if (!empty($_GET['banca'])) {
    $conditions[] = "banca = '" . $mysqli->real_escape_string($_GET['banca']) . "'";
}
if (!empty($_GET['year'])) {
    $conditions[] = "year = '" . $mysqli->real_escape_string($_GET['year']) . "'";
}
if (!empty($_GET['job_roles'])) {
    $conditions[] = "job_role = '" . $mysqli->real_escape_string($_GET['job_roles']) . "'";
}
if (!empty($_GET['grade_level'])) {
    $conditions[] = "grade_level = '" . $mysqli->real_escape_string($_GET['grade_level']) . "'";
}
if (!empty($_GET['course'])) {
    $conditions[] = "course = '" . $mysqli->real_escape_string($_GET['course']) . "'";
}
if (!empty($_GET['job_function'])) {
    $conditions[] = "job_function = '" . $mysqli->real_escape_string($_GET['job_function']) . "'";
}
if (!empty($_GET['question_type'])) {
    $conditions[] = "question_type = '" . $mysqli->real_escape_string($_GET['question_type']) . "'";
}
if (!empty($_GET['level'])) {
    $conditions[] = "level = '" . $mysqli->real_escape_string($_GET['level']) . "'";
}

// Adiciona a cláusula WHERE à consulta SQL se houver filtros
$where_clause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

// Consulta SQL para buscar a questão filtrada
$query = "SELECT * FROM questions $where_clause LIMIT 1";
$result = $mysqli->query($query);

// Função para obter alternativas por ID da questão e alternativa
function getAlternative($mysqli, $question_id, $alternative) {
    $question_id = $mysqli->real_escape_string($question_id);
    $alternative = $mysqli->real_escape_string($alternative);
    $query = "SELECT answer FROM answers WHERE questions_ID = '$question_id' AND alternative = '$alternative' LIMIT 1";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    return $row ? strip_tags($row['answer']) : 'Não disponível';
}

// Verifica se há resultados
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Exibe as informações da questão
    echo '<form class="question">';
    echo '    <div id="question_infos">';
    echo '        <span class="span_number_list">#' . $row['ID'] . '</span>';
    echo '        <span class="span_about">' . $row['year'] . '</span>';
    echo '        <span class="span_about">' . $row['banca'] . '</span>';
    echo '        <span class="span_about">' . $row['level'] . '</span>';
    echo '        <span class="span_about">' . $row['question_type'] . '</span>';
    echo '        <span class="span_about">' . $row['subject'] . '</span>';
    echo '        <span class="span_about">' . $row['course'] . '</span>';
    echo '    </div>';
    echo '    <span id="question">' . $row['question'] . '</span>'; 
    echo '    <div id="options">';
    
    if ($row['question_type'] == 'tf') {
        // Se a questão for do tipo verdadeiro ou falso, use valores 0 e 1
        echo '    <div class="option">';
        echo '        <input type="radio" id="True' . $row['ID'] . '" name="answer' . $row['ID'] . '" value="1">';
        echo '        <label for="True' . $row['ID'] . '" data-content="V">Verdadeiro</label>';
        echo '    </div>';
        echo '    <div class="option">';
        echo '        <input type="radio" id="False' . $row['ID'] . '" name="answer' . $row['ID'] . '" value="0">';
        echo '        <label for="False' . $row['ID'] . '" data-content="F">Falso</label>';
        echo '    </div>';
    } else {
        // Para outros tipos de questões
        foreach (['A', 'B', 'C', 'D', 'E'] as $option) {
            $alternative_text = getAlternative($mysqli, $row['ID'], $option);
            if ($alternative_text != 'Não disponível') {
                echo '    <div class="option">';
                echo '        <input type="radio" id="' . $option . $row['ID'] . '" name="answer' . $row['ID'] . '" value="' . $option . '">';
                echo '        <label for="' . $option . $row['ID'] . '" data-content="' . $option . '">' . $alternative_text . '</label>';
                echo '    </div>';
            }
        }
    }

    echo '    </div>';
    echo '    <div id="question_tools">';
    echo '        <span id="answerValidate">Responder</span>';
    echo '        <div id="tools">';
    echo '            <span class="tool-item" data-action="like"><ion-icon name="heart-outline"></ion-icon> Gostei</span>';
    echo '            <span class="tool-item" data-action="answer"><ion-icon name="chatbox-outline"></ion-icon> Gabarito</span>';
    echo '            <span class="tool-item" data-action="attachments"><i class="bx bx-paperclip"></i>Anexados</span>';
    echo '            <span class="tool-item" data-action="comments"><ion-icon name="chatbubbles-outline"></ion-icon>Comentários</span>';
    echo '            <span class="tool-item" data-action="stats"><ion-icon name="analytics-outline"></ion-icon>Estátisticas</span>';
    echo '            <span class="tool-item" data-action="notes"><ion-icon name="document-outline"></ion-icon>Criar Anotações</span>';
    echo '            <span class="tool-item" data-action="error"><ion-icon name="flag-outline"></ion-icon>Erro</span>';
    echo '        </div>';
    echo '    </div>';
    
    echo '</form>';
} else {
    echo '<span style="text-align: center;">Nenhuma questão encontrada</span>';
}

// Fecha a conexão
$mysqli->close();
?>