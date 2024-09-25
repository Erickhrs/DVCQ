<?php
include('./includes/connection.php');

function getOptions($mysqli, $chart, $column, $label, $selectedValue = '') {
    $sql = "SELECT ID, $column FROM $chart";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        echo '<option value="">' . $label . '</option>';
        while ($row = $result->fetch_assoc()) {
            $selected = ($row['ID'] == $selectedValue) ? 'selected' : '';
            echo '<option value="' . $row['ID'] . '" ' . $selected . '>' . $row[$column] . '</option>';
        }
    } else {
        echo '<option disabled>nenhuma opção encontrada...</option>';
    }
}


function getBancaName($mysqli, $banca) {
    $query = "SELECT banca FROM bancas WHERE id = '" . $mysqli->real_escape_string($banca) . "' LIMIT 1";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    return $row ? strip_tags($row['banca']) : 'Desconhecido';
}

function getJobRole($mysqli, $role) {
    $query = "SELECT job_role FROM job_roles WHERE id = '" . $mysqli->real_escape_string($role) . "' LIMIT 1";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    return $row ? strip_tags($row['job_role']) : 'Desconhecido';
}

function getQuestionTypeDescription($type) {
    if ($type === 'tf') {
        return 'Verdadeiro ou Falso';
    } elseif ($type === 'mult') {
        return 'Múltipla Escolha';
    } else {
        return 'Desconhecido';
    }
}

function getSubjectName($mysqli, $subject) {
    $query = "SELECT subject FROM subjects WHERE id = '" . $mysqli->real_escape_string($subject) . "' LIMIT 1";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    return $row ? strip_tags($row['subject']) : 'Desconhecido';
}

// Função para obter os nomes dos cursos a partir dos IDs
function getCoursesFromIds($mysqli, $ids) {
    // Divide os IDs pelo separador '-'
    $ids_array = explode('-', $ids);
    
    // Cria uma consulta SQL para buscar os nomes baseados nos IDs
    $ids_placeholders = implode(',', array_fill(0, count($ids_array), '?'));
    $query = "SELECT id, course FROM courses WHERE id IN ($ids_placeholders)";
    
    // Prepara a consulta
    if ($stmt = $mysqli->prepare($query)) {
        // Vincula os parâmetros da consulta
        $stmt->bind_param(str_repeat('i', count($ids_array)), ...$ids_array);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Cria um array associativo de IDs para nomes
        $names = [];
        while ($row = $result->fetch_assoc()) {
            $names[$row['id']] = $row['course'];
        }
        
        // Fecha a consulta
        $stmt->close();
        
        // Retorna os nomes correspondentes
        $result_names = array_map(function($id) use ($names) {
            return isset($names[$id]) ? $names[$id] : 'Desconhecido';
        }, $ids_array);
        
        return implode(' - ', $result_names);
    }
    
    return 'Erro na consulta';
}
function getDisciplinesFromIds($mysqli, $ids) {
    // Divide os IDs pelo separador '-'
    $ids_array = explode('-', $ids);
    
    // Cria uma consulta SQL para buscar os nomes baseados nos IDs
    $ids_placeholders = implode(',', array_fill(0, count($ids_array), '?'));
    $query = "SELECT id, discipline FROM disciplines WHERE id IN ($ids_placeholders)";
    
    // Prepara a consulta
    if ($stmt = $mysqli->prepare($query)) {
        // Vincula os parâmetros da consulta
        $stmt->bind_param(str_repeat('i', count($ids_array)), ...$ids_array);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Cria um array associativo de IDs para nomes
        $names = [];
        while ($row = $result->fetch_assoc()) {
            $names[$row['id']] = $row['discipline'];
        }
        
        // Fecha a consulta
        $stmt->close();
        
        // Retorna os nomes correspondentes
        $result_names = array_map(function($id) use ($names) {
            return isset($names[$id]) ? $names[$id] : 'Desconhecido';
        }, $ids_array);
        
        return implode(' - ', $result_names);
    }
    
    return 'Erro na consulta';
}
function getJobFunction($mysqli, $ids) {
    // Divide os IDs pelo separador '-'
    $ids_array = explode('-', $ids);
    
    // Cria uma consulta SQL para buscar os nomes baseados nos IDs
    $ids_placeholders = implode(',', array_fill(0, count($ids_array), '?'));
    $query = "SELECT id, job_function FROM job_functions WHERE id IN ($ids_placeholders)";
    
    // Prepara a consulta
    if ($stmt = $mysqli->prepare($query)) {
        // Vincula os parâmetros da consulta
        $stmt->bind_param(str_repeat('i', count($ids_array)), ...$ids_array);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Cria um array associativo de IDs para nomes
        $names = [];
        while ($row = $result->fetch_assoc()) {
            $names[$row['id']] = $row['job_function'];
        }
        
        // Fecha a consulta
        $stmt->close();
        
        // Retorna os nomes correspondentes
        $result_names = array_map(function($id) use ($names) {
            return isset($names[$id]) ? $names[$id] : 'Desconhecido';
        }, $ids_array);
        
        return implode(' - ', $result_names);
    }
    
    return 'Erro na consulta';
}

function isQuestionLiked($mysqli, $user_id, $question_id) {
    $user_id = $mysqli->real_escape_string($user_id);
    $question_id = $mysqli->real_escape_string($question_id);
    $query = "SELECT 1 FROM users_likes WHERE user_ID = '$user_id' AND question_ID = '$question_id' LIMIT 1";
    $result = $mysqli->query($query);
    return $result->num_rows > 0;
}
function getUserName($mysqli, $userID) {
    $query = "SELECT name FROM users WHERE id = '" . $mysqli->real_escape_string($userID) . "' LIMIT 1";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    return $row ? strip_tags($row['name']) : 'Desconhecido';
}

function total_questions_answered($mysqli, $userID) {
    $total = 0;
    // Prepara a consulta SQL
    $query = "SELECT COUNT(*) as total FROM users_answers WHERE user_ID = ?";
    
    // Prepara a declaração
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();
    
    return $total;
}
function total_subjects($mysqli, $userID) {
    $total = 0;

    // Prepara a consulta SQL para contar perguntas distintas
    $query = "SELECT COUNT(DISTINCT question_ID) as total FROM users_answers WHERE user_ID = ?";
    
    // Prepara a declaração
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();
    
    return $total;
}
function total_user_cw($mysqli, $userID, $cw) {
    $total = 0;
    // Prepara a consulta SQL
    $query = "SELECT COUNT(*) as total FROM users_answers WHERE user_ID = ? AND is_correct = $cw";
    
    // Prepara a declaração
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();
    
    return $total;
}


function get_performance_by_subject($mysqli, $user_id) {
    // Primeiro, pegar todos os question_ID da tabela users_answers para o usuário
    $query = "
        SELECT question_ID, 
               SUM(is_correct) AS correct_count, 
               COUNT(*) - SUM(is_correct) AS wrong_count
        FROM users_answers 
        WHERE user_ID = ? 
        GROUP BY question_ID
    ";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Array para armazenar o desempenho por matéria
    $performanceBySubject = [];

    // Percorrer cada resposta e contar acertos e erros por matéria
    while ($row = $result->fetch_assoc()) {
        $questionID = $row['question_ID'];
        $correctCount = (int)$row['correct_count'];
        $wrongCount = (int)$row['wrong_count'];

        // Obter o subject correspondente ao question_ID
        $subjectQuery = "SELECT subject FROM questions WHERE ID = ?";
        $subjectStmt = $mysqli->prepare($subjectQuery);
        $subjectStmt->bind_param("s", $questionID);
        $subjectStmt->execute();
        $subjectResult = $subjectStmt->get_result();

        if ($subjectRow = $subjectResult->fetch_assoc()) {
            $subject = $subjectRow['subject'];

            // Adicionar ou atualizar os contadores no array de desempenho
            if (!isset($performanceBySubject[$subject])) {
                $performanceBySubject[$subject] = [
                    'correct_count' => 0,
                    'wrong_count' => 0,
                ];
            }

            $performanceBySubject[$subject]['correct_count'] += $correctCount;
            $performanceBySubject[$subject]['wrong_count'] += $wrongCount;
        }

        $subjectStmt->close();
    }

    return $performanceBySubject;
}


function get_evolution_data($mysqli, $user_id) {
    $query = "SELECT DATE(answer_date) AS date, SUM(is_correct) AS correct_count, COUNT(*) - SUM(is_correct) AS wrong_count
              FROM users_answers
              WHERE user_ID = ?
              GROUP BY DATE(answer_date)
              ORDER BY DATE(answer_date)";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $dates = [];
    $correct_counts = [];
    $wrong_counts = [];

    while ($row = $result->fetch_assoc()) {
        $dates[] = $row['date'];
        $correct_counts[] = $row['correct_count'];
        $wrong_counts[] = $row['wrong_count'];
    }

    return [$dates, $correct_counts, $wrong_counts];
}


function getUserDisciplinesCount($mysqli, $userID) {
    // Primeiro, pegar todos os question_ID da tabela users_answers para o usuário
    $query = "SELECT question_ID FROM users_answers WHERE user_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Array para contar a ocorrência de cada question_ID
    $questionCounts = [];

    // Guardar todos os question_ID e contar quantas vezes aparecem
    while ($row = $result->fetch_assoc()) {
        $questionID = $row['question_ID'];
        if (!isset($questionCounts[$questionID])) {
            $questionCounts[$questionID] = 0;
        }
        $questionCounts[$questionID]++;
    }

    $stmt->close();

    // Array final com os subjects e seus contadores
    $subjectsCount = [];

    // Para cada question_ID, pegar os disciplines na tabela questions
    foreach ($questionCounts as $questionID => $count) {
        $query = "SELECT discipline FROM questions WHERE ID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $questionID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se encontrar os disciplines, separar e contar
        if ($row = $result->fetch_assoc()) {
            $disciplines = $row['discipline'];

            // Separar os IDs das disciplinas
            $disciplineIDs = explode('-', $disciplines);

            // Para cada disciplina, adicionar ao array com a disciplina como chave
            foreach ($disciplineIDs as $disciplineID) {
                // Remover espaços em branco
                $disciplineID = trim($disciplineID);

                // Adicionar contagem ao array de subjects
                if (!isset($subjectsCount[$disciplineID])) {
                    $subjectsCount[$disciplineID] = 0;
                }
                $subjectsCount[$disciplineID] += $count; // Acumula a contagem
            }
        }

        $stmt->close();
    }

    return $subjectsCount;
}

function getUserQuestionTypeCount($mysqli, $userID) {
    // Primeiro, pegar todos os question_ID da tabela users_answers para o usuário
    $query = "SELECT question_ID FROM users_answers WHERE user_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Array para contar a ocorrência de cada question_ID
    $questionCounts = [];

    // Guardar todos os question_ID e contar quantas vezes aparecem
    while ($row = $result->fetch_assoc()) {
        $questionID = $row['question_ID'];
        if (!isset($questionCounts[$questionID])) {
            $questionCounts[$questionID] = 0;
        }
        $questionCounts[$questionID]++;
    }

    $stmt->close();

    // Array final com os question types e seus contadores
    $typesCount = [];

    // Para cada question_ID, pegar o question_type na tabela questions
    foreach ($questionCounts as $questionID => $count) {
        $query = "SELECT question_type FROM questions WHERE ID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $questionID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se encontrar o question_type, contar
        if ($row = $result->fetch_assoc()) {
            $questionType = $row['question_type'];

            // Adicionar contagem ao array de types
            if (!isset($typesCount[$questionType])) {
                $typesCount[$questionType] = 0;
            }
            $typesCount[$questionType] += $count; // Acumula a contagem
        }

        $stmt->close();
    }

    return $typesCount;
}
function getUserDisciplinesCountByLevel($mysqli, $userID) {
    // Primeiro, pegar todos os question_ID e levels da tabela users_answers para o usuário
    $query = "SELECT question_ID FROM users_answers WHERE user_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Array para contar a ocorrência de cada question_ID
    $questionCounts = [];

    // Guardar todos os question_ID e contar quantas vezes aparecem
    while ($row = $result->fetch_assoc()) {
        $questionID = $row['question_ID'];
        if (!isset($questionCounts[$questionID])) {
            $questionCounts[$questionID] = 0;
        }
        $questionCounts[$questionID]++;
    }

    $stmt->close();

    // Array final com os levels e seus contadores
    $levelsCount = [];

    // Para cada question_ID, pegar o level na tabela questions
    foreach ($questionCounts as $questionID => $count) {
        $query = "SELECT level FROM questions WHERE ID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $questionID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se encontrar o level, contar
        if ($row = $result->fetch_assoc()) {
            $level = $row['level'];

            // Adicionar contagem ao array de levels
            if (!isset($levelsCount[$level])) {
                $levelsCount[$level] = 0;
            }
            $levelsCount[$level] += $count; // Acumula a contagem
        }

        $stmt->close();
    }

    return $levelsCount;
}






?>