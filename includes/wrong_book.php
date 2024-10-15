<?php
include_once './includes/connection.php'; // Inclui o arquivo de conexão
include_once './includes/functions.php';
$answers = getUserAnswers($mysqli, $_SESSION['id']);
if (!$answers) {
    $answers = []; // Inicializa como array vazio caso não haja respostas
}
$incorrectAnswers = getIncorrectAnswers($mysqli, $_SESSION['id']);

// Verifique se o array não está vazio e prepare para enviar ao JavaScript
if (!empty($incorrectAnswers)) {
    // Converta o array PHP para JSON e envie ao JavaScript
    echo "<script>console.log(" . json_encode($incorrectAnswers) . ");</script>";
} else {
    // Se não houver respostas incorretas, envia uma mensagem ao console
    echo "<script>console.log('Nenhuma resposta incorreta encontrada.');</script>";
}
// Construa a cláusula WHERE com base nos parâmetros do formulário
$conditions = [];
$params = [];
$types = '';
$text = [
    "Você acertou! Continue assim!",
    "Certo! Muito bem!",
    "Isso aí! Ótimo!",
    "Acertou! Parabéns!",
    "Bom trabalho! Certo!",
    "Exato! Continue!",
    "Correto! Excelente!",
    "Perfeito! Segue assim!",
    "Ótimo palpite!",
    "Certo! Bela resposta!"
];

// Seleciona uma mensagem aleatória

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


// Consulta SQL para buscar as questões da página atual
$query = "SELECT * FROM questions $where_clause ORDER BY ID DESC";
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
        $is_correct = isQuestionAnswered($answers, $row['ID']);
        $idQuestion = $row['ID'];
        $random_message = $text[array_rand($text)];
        $liked_class = isQuestionLiked($mysqli, $_SESSION['id'], $row['ID']) ? 'liked' : '';
        // Exibe as informações da questão
        if ($is_correct == 1 || $is_correct =="") {
            echo '<form class="question" style="display:none!important">';
        } else if ($is_correct == 0){
            echo '<form class="question">';
        }
        echo '    <div id="question_infos">';
        echo '        <span class="span_number_list">#' . $row['ID'] . '</span>';
        echo '        <span class="span_about">' . $row['year'] . '</span>';
        echo '        <span class="span_about">' . getBancaName($mysqli, $row['banca']) . '</span>';
        echo '        <span class="span_about">' . $row['level'] . '</span>';
        echo '        <span class="span_about">' . $row['grade_level'] . '</span>';
        echo '        <span class="span_about">' . getQuestionTypeDescription($row['question_type']) . '</span>';
        echo '        <span class="span_about">' . getSubjectName($mysqli, $row['subject']) . '</span>';
        echo '        <span class="span_about">' . getDisciplinesFromIds($mysqli, $row['discipline']) . '</span>';
        echo '<span class="span_about">' . getCoursesFromIds($mysqli, $row['course']) . '</span>';
        echo '        <span class="span_about">' . getJobRole($mysqli, $row['job_role']) . '</span>';
        echo '        <span class="span_about">' . getJobFunction($mysqli, $row['job_function']) . '</span>';
        

        if ($is_correct !== null) {
            $class = ($is_correct == 1) ? 'correct' : 'incorrect'; // Define a classe com base em is_correct
            echo '<span class="span_respondida ' . $class . '"> ✓ respondida</span>';
        }
        
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
        echo '<div class="correctmsg animate__animated animate__zoomIn" id="cmsg_' . $row['ID'] . '">'. "✔️ "  . $random_message . '</div>';
        echo '<div class="wrongmsg animate__animated animate__shakeX" id="'. "wmsg_" .$row['ID'].'">'. "❌ " . $row['prof_comment'] .'</div>';
        echo '    </div>';
        echo '    <div id="question_tools">';
        echo '<button type="submit" id="vbtn_' . $row['ID'] . '" onclick="disableBtn(\'' . $row['ID'] . '\')">Responder</button>';
        echo '        <div id="tools">';
        echo '    <span class="likeBtn ' . $liked_class . '" data-id="' . $row['ID'] . '"><ion-icon name="heart-outline"></ion-icon> Gostei</span>';

        echo '<span class ="toggle gabaritobtn" data-target="' . "gabarito_" . $row['ID'] . '"><ion-icon name="chatbox-outline"></ion-icon> Gabarito</span>';
        echo '            <span class="toggle commentsbtn" data-target="' . "comments_" . $row['ID'] . '"><ion-icon  name="chatbubbles-outline" ></ion-icon>Comentários</span>';
        echo '            <span class="toggle stbtn" data-target="' . "est_" . $row['ID'] . '"><ion-icon name="analytics-outline"></ion-icon>Estátisticas</span>';
        echo '            <span class="toggle" data-target="' . "note_" . $row['ID'] . '"><ion-icon name="document-outline"></ion-icon>Criar Anotações</span>';
        echo '<span class="feedback_btn" data-session-id="' . $_SESSION['id']. '" data-question-id="' . $row['ID'] . '"><ion-icon name="flag-outline"></ion-icon>Feedback</span>';
        echo '        </div>';
        echo '    </div>';
        echo '<div id="' . "gabarito_" . $row['ID'] . '" class="gabarito animate__animated animate__zoomIn">
        <span><ion-icon name="chatbox-outline"></ion-icon> Gabarito:</span>
        <p> ' . $row['prof_comment'] . ' </p>
        <span><i class="bx bx-paperclip"></i> Anexados:</span>
         <p> ' . $row['related_contents'] . ' </p>
        </div>';

        
        echo '<div id="est_' . $row['ID'] . '" class="charts animate__animated animate__zoomIn">';
        echo '    <div class="container_to_flex">';
        echo '        <div class="chart-wrapper">';
        echo '            <canvas id="chart' . $row['ID'] . '"></canvas>';
        echo '        </div>';
        echo '        <div class="chart-wrapper">';
        echo '            <canvas id="chart2' . $row['ID'] . '"></canvas>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
       
        
    echo '<div id="' . "comments_" . $row['ID'] . '" class="comments animate__animated animate__fadeIn">';
    include './includes/get_comments.php';
    echo '</div>'; 
    echo '<div id="' . "note_" . $row['ID'] . '" class="notes animate__animated animate__fadeIn">';

    echo '<div style="display:flex;gap:5px;margin-bottom:20px;" class="note-container">
    <textarea class="note" placeholder="Digite sua nota aqui..."></textarea>
    <span class="add-note-btn" data-question-id="'. $row['ID'] . '">+</span>
</div>';

include './includes/get_notes.php';
echo '</div>';
echo '</form>';
}
} else {
echo '<span style="text-align: center;">Nenhuma questão encontrad</span>';
}

// Exibe links de navegação para as páginas
        ?>