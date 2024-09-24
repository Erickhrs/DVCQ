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

    $performance = [];
    while ($row = $result->fetch_assoc()) {
        $performance[] = [
            'question_ID' => $row['question_ID'],
            'correct_count' => (int)$row['correct_count'],
            'wrong_count' => (int)$row['wrong_count']
        ];
    }
    
    return $performance;
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


?>