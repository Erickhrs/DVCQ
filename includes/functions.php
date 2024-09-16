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


?>