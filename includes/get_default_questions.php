<?php
include_once './includes/connection.php'; // Inclui o arquivo de conexão

// Define o número de registros por página
$records_per_page = 2; // Ajuste conforme necessário

// Obtém o número da página atual da URL, se não estiver definido, assume a página 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calcula o OFFSET para a consulta SQL
$offset = ($page - 1) * $records_per_page;

// Construa a cláusula WHERE com base nos parâmetros do formulário
$conditions = [];
$params = [];
$types = '';

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

// Consulta SQL para contar o número total de registros
$total_query = "SELECT COUNT(*) AS total FROM questions $where_clause";
$total_result = $mysqli->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// Calcula o número total de páginas
$total_pages = ceil($total_records / $records_per_page);

// Consulta SQL para buscar as questões da página atual
$query = "SELECT * FROM questions $where_clause LIMIT $offset, $records_per_page";
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
    while ($row = $result->fetch_assoc()) {
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
        }else {
            // Para outros tipos de questões
            foreach (['A', 'B', 'C', 'D', 'E'] as $option) {
                $alternative_style = "";
                // Obtém a alternativa para a opção atual
                $alternative_text = getAlternative($mysqli, $row['ID'], $option);
                $alternative_style = $alternative_text == 'Não disponível' ? 'display: none !important;' : '';
                echo '    <div class="option" style="'.$alternative_style.'">';
                echo '        <input type="radio" id="' . $option . $row['ID'] . '" name="answer' . $row['ID'] . '" value="' . $option . '">';
                echo '        <label for="' . $option . $row['ID'] . '" data-content="' . $option . '" style="'.$alternative_style.'">'  . $alternative_text . '</label>';
                echo '    </div>';
            }
        }

        echo '    </div>';
        echo '    <div id="question_tools">';
        echo '        <button type="submit" id="answerValidate">Responder</button>';
        echo '        <div id="tools">';
        echo '            <span class ="likeBtn"><ion-icon name="heart-outline"></ion-icon> Gostei</span>';
        echo '            <span class ="toggle" data-target="' . "gabarito_" . $row['ID'] . '"><ion-icon name="chatbox-outline"></ion-icon> Gabarito</span>';
        echo '            <span class="toggle" data-target="' . "comments_" . $row['ID'] . '"><ion-icon  name="chatbubbles-outline" ></ion-icon>Comentários</span>';
        echo '            <span class="toggle" data-target="' . "est_" . $row['ID'] . '"><ion-icon name="analytics-outline"></ion-icon>Estátisticas</span>';
        echo '            <span class="toggle" data-target="' . "note_" . $row['ID'] . '"><ion-icon name="document-outline"></ion-icon>Criar Anotações</span>';
        echo '            <span id="feedback_btn"><ion-icon name="flag-outline"></ion-icon>Feedback</span>';
        echo '        </div>';
        echo '    </div>';
        echo '<div id="' . "gabarito_" . $row['ID'] . '" class="gabarito animate__animated animate__zoomIn">
        <span><ion-icon name="chatbox-outline"></ion-icon> Gabarito:</span>
        <p>
        Wikipedia relies entirely on volunteers to create and maintain its content. That often works well, but there are tasks that volunteers don’t enjoy doing, and topics where volunteers are missing.
        </p>
        <span><i class="bx bx-paperclip"></i> Anexados:</span>
        <p>
        Wikipedia relies entirely on volunteers to create and maintain its content. That often works well, but there are tasks that volunteers don’t enjoy doing, and topics where volunteers are missing.
        </p>
        </div>';
    echo '<div id="' . "est_" . $row['ID'] . '" class="charts animate__animated animate__zoomIn">
        <span>DESEMPENHO GERAL (ACERTOS ERROS) - ALTernativas marcadas em colunas</span>
        <canvas id="chart' . $row['ID'] . '"></canvas>
        <canvas id="chart' . $row['ID'] . '"></canvas>
        </div>';
    echo '<div id="' . "comments_" . $row['ID'] . '" class="comments animate__animated animate__zoomIn">
        <span>* AQUI FICARÁ OS COMENTÁRIOS *</span>
        </div>'; 
        echo '<div id="' . "note_" . $row['ID'] . '" class="comments animate__animated animate__zoomIn">
        <span>* faça um comentário aqui *</span>
        </div>'; 
        echo '</form>';
    }
} else {
    echo '<span style="text-align: center;">Nenhuma questão encontrad</span>';
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