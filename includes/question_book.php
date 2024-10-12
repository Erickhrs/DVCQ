<?php
include_once './includes/connection.php'; // Inclui o arquivo de conexão
include_once './includes/functions.php';
$answers = getUserAnswers($mysqli, $_SESSION['id']);
if (!$answers) {
    $answers = []; // Inicializa como array vazio caso não haja respostas
}

$bookId = $_POST['id'];
// Busque os dados da tabela users_books
$queryBook = "SELECT disciplines, subjects, courses, job_functions, job_role FROM users_books WHERE ID = ?";
$stmtBook = $mysqli->prepare($queryBook);
$stmtBook->bind_param('i', $bookId);
$stmtBook->execute();
$resultBook = $stmtBook->get_result();
$bookData = $resultBook->fetch_assoc();

if (!$bookData) {
    die('Erro: Livro não encontrado.');
}

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

// Construa a cláusula WHERE com base nos valores obtidos da tabela users_books
$conditions = [];

// Adicionar filtro para disciplinas
if (!empty($bookData['disciplines'])) {
    $disciplines = explode('/', $bookData['disciplines']);
    $disciplines = array_map('intval', $disciplines); // Converte os valores para inteiros
    $conditions[] = "discipline IN (" . implode(',', $disciplines) . ")";
}

// Adicionar filtro para subjects
if (!empty($bookData['subjects'])) {
    $subjects = explode('/', $bookData['subjects']);
    $subjects = array_map('intval', $subjects);
    $conditions[] = "subject IN (" . implode(',', $subjects) . ")";
}

// Adicionar filtro para courses
if (!empty($bookData['courses'])) {
    $courses = explode('/', $bookData['courses']);
    $courses = array_map('intval', $courses);
    $conditions[] = "course IN (" . implode(',', $courses) . ")";
}

// Adicionar filtro para job_functions
if (!empty($bookData['job_functions'])) {
    $job_functions = explode('/', $bookData['job_functions']);
    $job_functions = array_map('intval', $job_functions);
    $conditions[] = "job_function IN (" . implode(',', $job_functions) . ")";
}

// Adicionar filtro para job_roles
if (!empty($bookData['job_role'])) {
    $job_roles = explode('/', $bookData['job_role']);
    $job_roles = array_map('intval', $job_roles);
    $conditions[] = "job_role IN (" . implode(',', $job_roles) . ")";
}



// Adiciona a cláusula WHERE à consulta SQL se houver filtros
$where_clause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

// Consulta SQL para buscar as questões filtradas
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
        $idQuestion = $row['ID'];
        $random_message = $text[array_rand($text)];
        $liked_class = isQuestionLiked($mysqli, $_SESSION['id'], $row['ID']) ? 'liked' : '';
        // Exibe as informações da questão
        echo '<form class="question">';
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
        
        $is_correct = isQuestionAnswered($answers, $row['ID']);
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
echo '<span style="text-align: center; margin: 12%;">Nenhuma questão encontrada</span>';
}

 ?>