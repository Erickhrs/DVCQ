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

function getUserDisciplinesCountByBanca($mysqli, $userID) {
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

    // Array final com as bancas e seus contadores
    $bancasCount = [];

    // Para cada question_ID, pegar a banca na tabela questions
    foreach ($questionCounts as $questionID => $count) {
        $query = "SELECT banca FROM questions WHERE ID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $questionID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se encontrar a banca, adicionar ao contador
        if ($row = $result->fetch_assoc()) {
            $banca = $row['banca'];

            // Remover espaços em branco
            $banca = trim($banca);

            // Adicionar contagem ao array de bancas
            if (!isset($bancasCount[$banca])) {
                $bancasCount[$banca] = 0;
            }
            $bancasCount[$banca] += $count; // Acumula a contagem
        }

        $stmt->close();
    }

    // Transformar o array de bancas em um array de arrays associativos
    $resultArray = [];
    foreach ($bancasCount as $banca => $count) {
        $resultArray[] = [
            'name' => $banca,
            'count' => $count
        ];
    }

    return $resultArray; // Retorna um array de arrays associativos
}

function getUserJobFunctionsCount($mysqli, $userID) {
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

    // Array final com os job functions e seus contadores
    $jobFunctionsCount = [];

    // Para cada question_ID, pegar os job_functions na tabela questions
    foreach ($questionCounts as $questionID => $count) {
        $query = "SELECT job_function FROM questions WHERE ID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $questionID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se encontrar os job_functions, separar e contar
        if ($row = $result->fetch_assoc()) {
            $jobFunctions = $row['job_function'];

            // Separar os IDs dos job_functions
            $jobFunctionIDs = explode('-', $jobFunctions);

            // Para cada job_function, adicionar ao array com o job_function como chave
            foreach ($jobFunctionIDs as $jobFunctionID) {
                // Remover espaços em branco
                $jobFunctionID = trim($jobFunctionID);

                // Adicionar contagem ao array de job functions
                if (!isset($jobFunctionsCount[$jobFunctionID])) {
                    $jobFunctionsCount[$jobFunctionID] = 0;
                }
                $jobFunctionsCount[$jobFunctionID] += $count; // Acumula a contagem
            }
        }

        $stmt->close();
    }

    return $jobFunctionsCount;
}
function getUserJobRolesCount($mysqli, $userID) {
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

    // Array final com os job_roles e seus contadores
    $jobRolesCount = [];

    // Para cada question_ID, pegar os job_roles na tabela questions
    foreach ($questionCounts as $questionID => $count) {
        $query = "SELECT job_role FROM questions WHERE ID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $questionID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se encontrar os job_roles, separar e contar
        if ($row = $result->fetch_assoc()) {
            $jobRoles = $row['job_role'];

            // Separar os IDs dos job_roles
            $jobRoleIDs = explode('-', $jobRoles);

            // Para cada job_role, adicionar ao array com o job_role como chave
            foreach ($jobRoleIDs as $jobRoleID) {
                // Remover espaços em branco
                $jobRoleID = trim($jobRoleID);

                // Adicionar contagem ao array de jobRoles
                if (!isset($jobRolesCount[$jobRoleID])) {
                    $jobRolesCount[$jobRoleID] = 0;
                }
                $jobRolesCount[$jobRoleID] += $count; // Acumula a contagem
            }
        }

        $stmt->close();
    }

    return $jobRolesCount;
}
function getUserCoursesCount($mysqli, $userID) {
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

    // Array final com os courses e seus contadores
    $coursesCount = [];

    // Para cada question_ID, pegar os courses na tabela questions
    foreach ($questionCounts as $questionID => $count) {
        $query = "SELECT course FROM questions WHERE ID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $questionID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se encontrar os courses, separar e contar
        if ($row = $result->fetch_assoc()) {
            $courses = $row['course'];

            // Separar os IDs dos cursos
            $courseIDs = explode('-', $courses);

            // Para cada curso, adicionar ao array com o curso como chave
            foreach ($courseIDs as $courseID) {
                // Remover espaços em branco
                $courseID = trim($courseID);

                // Adicionar contagem ao array de courses
                if (!isset($coursesCount[$courseID])) {
                    $coursesCount[$courseID] = 0;
                }
                $coursesCount[$courseID] += $count; // Acumula a contagem
            }
        }

        $stmt->close();
    }

    return $coursesCount;
}


function evaluateUserPerformance($mysqli, $userID) {
    // Consulta para contar acertos e erros
    $query = "SELECT COUNT(*) AS total, SUM(is_correct) AS correct_count FROM users_answers WHERE user_id = ?";
    
    // Prepare a statement
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        
        // Obtendo resultados
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        $total = $data['total'];
        $correct_count = $data['correct_count'];
        
        // Calcular a média de acertos
        if ($total > 0) {
            $average = ($correct_count / $total) * 100; // Média em porcentagem
        } else {
            $average = 0; // Caso não haja respostas
        }
        
        // Mensagens motivacionais
        $excellentMessages = [
            "Ótimo trabalho! 🌟 Você é uma estrela! Continue assim! 💪",
            "Parabéns! 🎉 Você está arrasando! Siga firme! 🚀",
            "Incrível! 👏 Seus esforços estão valendo a pena! Mantenha o foco! 🔥",
            "Fantástico! 🎊 Você superou as expectativas! Rumo ao sucesso! ✨",
            "Maravilhoso! 🌈 Seu desempenho é inspirador! Continue brilhando! 💖",
            "Impressionante! 🏆 Você está no caminho certo! A vitória é sua! 🥇",
            "Show de bola! 🤩 Seu empenho é admirável! Continue assim! ✌️",
            "Excelente! 🥳 Você está se destacando! Persista e conquiste mais! 🌟",
            "Sensacional! 🚀 Seu esforço está fazendo a diferença! Mantenha o ritmo! 💪",
            "Magnífico! 🌌 Você está fazendo história! Não pare agora! 🌟"
        ];

        $goodMessages = [
            "Bom trabalho! 😊 Você está indo muito bem! Continue nessa trajetória!",
            "Ótimo! 👍 Você já chegou longe! Mantenha o foco e siga em frente!",
            "Bacana! 😃 Seus esforços estão dando resultados! Continue assim!",
            "Legal! 🌼 Você está progredindo! Mais um empurrão e você chega lá!",
            "Bom! 🚀 Você está no caminho certo! Não pare de praticar!",
            "Agradável! 🌟 Você está evoluindo! Cada dia é uma nova chance!",
            "Legal! 👍 Você está quase lá! Continue acreditando em você!",
            "Encantador! ✨ Seu esforço é visível! Persistência é a chave!",
            "Bom! 💪 Você está mostrando garra! Mantenha o ritmo!",
            "Animador! 🎈 Você está indo bem! Continue buscando melhorar!"
        ];

        $poorMessages = [
            "Não desista! 😞 Cada erro é uma oportunidade de aprender!",
            "Força! 💪 Você pode melhorar! Pratique e a vitória virá!",
            "Coragem! 🌈 Todo mundo começa em algum lugar! Continue tentando!",
            "Persistência! 💖 Aprender leva tempo! Mantenha-se firme!",
            "Não se preocupe! 🚀 Você está no caminho de aprender! Siga em frente!",
            "Foquem! ✨ Cada passo conta! Mantenha-se motivado!",
            "Acredite! 🌼 O sucesso é a soma de pequenos esforços! Não pare!",
            "Desafios são oportunidades! 🏆 Continue tentando e você vai conseguir!",
            "Não desista! 🔥 Cada erro é um passo mais perto do sucesso!",
            "Tenha fé! 🌟 Você é capaz de superações! Continue sua jornada!"
        ];

        // Avaliação do desempenho
        if ($average >= 80) {
            $evaluation = $excellentMessages[array_rand($excellentMessages)];
            $icon = "star";
            $color = "#4CAF50"; // Verde
        } elseif ($average >= 50) {
            $evaluation = $goodMessages[array_rand($goodMessages)];
            $icon = "thumbs-up";
            $color = "#2196F3"; // Azul
        } else {
            $evaluation = $poorMessages[array_rand($poorMessages)];
            $icon = "thumbs-down";
            $color = "#FF5722"; // Laranja
        }
        
        // Echo a avaliação com estilos
        echo "<div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border-radius: 8px; border: 1px solid #ddd; text-align: center;'>";
        echo "<h2 style='color: $color;'>Média de Acertos: <strong style='color: #333;'>" . number_format($average, 2) . "%</strong></h2>";
        echo "<p style='font-size: 18px; color: $color;'><ion-icon name='$icon' style='font-size: 40px; vertical-align: middle;'></ion-icon> $evaluation</p>";
        echo "</div>";
        
        // Fechar a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $mysqli->error;
    }
}

function evaluateQuestionsPerDay($mysqli, $userID) {
    // Definindo as datas para as comparações
    $today = date('Y-m-d');
    $lastWeek = date('Y-m-d', strtotime('-7 days'));
    $lastFifteenDays = date('Y-m-d', strtotime('-15 days'));
    $lastMonth = date('Y-m-d', strtotime('-30 days'));

    // Consultas para contar questões respondidas
    $query = "
        SELECT 
            COUNT(*) AS total,
            SUM(CASE WHEN answer_date >= ? THEN 1 ELSE 0 END) AS last_week,
            SUM(CASE WHEN answer_date >= ? THEN 1 ELSE 0 END) AS last_15_days,
            SUM(CASE WHEN answer_date >= ? THEN 1 ELSE 0 END) AS last_month,
            MIN(answer_date) AS first_answer_date
        FROM users_answers 
        WHERE user_id = ?
    ";

    // Preparar a declaração
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sssi", $lastWeek, $lastFifteenDays, $lastMonth, $userID);
        $stmt->execute();
        
        // Obtendo resultados
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        // Extraindo informações
        $total = $data['total'];
        $lastWeekCount = $data['last_week'];
        $lastFifteenDaysCount = $data['last_15_days'];
        $lastMonthCount = $data['last_month'];
        $firstAnswerDate = $data['first_answer_date'];

        // Verifica se houve respostas
        if ($total > 0 && $firstAnswerDate) {
            // Média de questões respondidas por dia
            $daysSinceFirstAnswer = max(1, ceil((strtotime($today) - strtotime($firstAnswerDate)) / (60 * 60 * 24)));
            $averagePerDay = $total / $daysSinceFirstAnswer;

            echo "<div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border-radius: 8px; border: 1px solid #ddd;    min-height: 347px;
    margin-top: 16px;'>";
            echo "<h2 style='color: #333; text-align: center;'>Relatório de Questões Respondidas</h2>";
            
            // Total de questões respondidas
            echo "<p style='font-size: 18px; color: #4CAF50;'><ion-icon name='checkmark-circle' style='vertical-align: middle;'></ion-icon> Total de questões respondidas: <strong style='color: #333;'>$total</strong></p>";
            
            // Questões nos últimos 7 dias
            echo "<p style='font-size: 18px; color: #2196F3;'><ion-icon name='calendar' style='vertical-align: middle;'></ion-icon> Questões nos últimos 7 dias: <strong style='color: #333;'>$lastWeekCount</strong></p>";
            
            // Questões nos últimos 15 dias
            echo "<p style='font-size: 18px; color: #FF9800;'><ion-icon name='time' style='vertical-align: middle;'></ion-icon> Questões nos últimos 15 dias: <strong style='color: #333;'>$lastFifteenDaysCount</strong></p>";
            
            // Questões no último mês
            echo "<p style='font-size: 18px; color: #9C27B0;'><ion-icon name='calendar' style='vertical-align: middle;'></ion-icon>  Questões no último mês: <strong style='color: #333;'>$lastMonthCount</strong></p>";
            
            // Média de questões respondidas por dia
            echo "<p style='font-size: 18px; color: #E91E63;'><ion-icon name='stats-chart' style='vertical-align: middle;'></ion-icon> Média de questões respondidas por dia: <strong style='color: #333;'>" . number_format($averagePerDay, 2) . "</strong></p>";
            
            echo "</div>";
        } else {
            // Exibe mensagem se não houver respostas
            echo "Nenhuma questão respondida ainda.\n";
        }
        
        // Fechar a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $mysqli->error;
    }
}

function getUserRanking($mysqli, $userID) {
    // Consulta para contar questões respondidas por cada usuário
    $query = "
        SELECT user_id, COUNT(*) AS total_answers 
        FROM users_answers 
        GROUP BY user_id 
        ORDER BY total_answers DESC
    ";

    // Preparar a declaração
    if ($result = $mysqli->query($query)) {
        $userRank = 1; // Inicializa a posição do usuário
        $foundUser = false; // Flag para verificar se o usuário foi encontrado

        // Percorre os resultados para determinar a posição
        while ($row = $result->fetch_assoc()) {
            if ($row['user_id'] == $userID) {
                $foundUser = true; // Marca que o usuário foi encontrado
                break; // Para de buscar após encontrar o usuário
            }
            $userRank++; // Incrementa a posição para cada usuário encontrado
        }

        // Verifica se o usuário foi encontrado e exibe a posição
        echo "<div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border-radius: 8px; border: 1px solid #ddd; text-align: center;'>";
        if ($foundUser) {
            echo "<h2 style='color: #4CAF50;'>Ranking de Questões Respondidas</h2>";
            echo "<p style='font-size: 18px; color: #333;'><ion-icon name='checkmark-circle' style='font-size: 40px; vertical-align: middle;'></ion-icon> O usuário com ID <strong>$userID</strong> está na posição: <strong style='color: #FF9800;'>$userRank</strong>.</p>";
        } else {
            echo "<h2 style='color: #FF5722;'>Ranking de Questões Respondidas</h2>";
            echo "<p style='font-size: 18px; color: #333;'><ion-icon name='alert-circle' style='font-size: 40px; vertical-align: middle;'></ion-icon> O usuário com ID <strong>$userID</strong> não respondeu a nenhuma questão.</p>";
        }
        echo "</div>";

        // Liberar resultados
        $result->free();
    } else {
        echo "Erro ao preparar a consulta: " . $mysqli->error;
    }
}
function getUserRankingByCorrectAnswers($mysqli, $userID) {
    // Consulta para contar acertos por cada usuário
    $query = "
        SELECT user_id, SUM(is_correct) AS total_correct_answers 
        FROM users_answers 
        GROUP BY user_id 
        ORDER BY total_correct_answers DESC
    ";

    // Preparar a declaração
    if ($result = $mysqli->query($query)) {
        $userRank = 1; // Inicializa a posição do usuário
        $foundUser = false; // Flag para verificar se o usuário foi encontrado

        // Percorre os resultados para determinar a posição
        while ($row = $result->fetch_assoc()) {
            if ($row['user_id'] == $userID) {
                $foundUser = true; // Marca que o usuário foi encontrado
                break; // Para de buscar após encontrar o usuário
            }
            $userRank++; // Incrementa a posição para cada usuário encontrado
        }

        // Verifica se o usuário foi encontrado e exibe a posição
        echo "<div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border-radius: 8px; border: 1px solid #ddd; text-align: center;'>";
        if ($foundUser) {
            echo "<h2 style='color: #2196F3;'>Ranking de Acertos</h2>";
            echo "<p style='font-size: 18px; color: #333;'><ion-icon name='trophy' style='font-size: 40px; vertical-align: middle;'></ion-icon> O usuário com ID <strong>$userID</strong> está na posição de acertos: <strong style='color: #FF9800;'>$userRank</strong>.</p>";
        } else {
            echo "<h2 style='color: #FF5722;'>Ranking de Acertos</h2>";
            echo "<p style='font-size: 18px; color: #333;'><ion-icon name='sad' style='font-size: 40px; vertical-align: middle;'></ion-icon> O usuário com ID <strong>$userID</strong> não teve acertos registrados.</p>";
        }
        echo "</div>";

        // Liberar resultados
        $result->free();
    } else {
        echo "Erro ao preparar a consulta: " . $mysqli->error;
    }
}

function getUserAnswers($mysqli, $userId) {
    // Consulta para pegar a última resposta de cada questão, considerando a data e o ID
    $query = "
        SELECT question_ID, is_correct, answer_date 
        FROM users_answers AS ua
        WHERE user_ID = ? 
        AND id IN (
            SELECT MAX(id) 
            FROM users_answers 
            WHERE user_ID = ? 
            GROUP BY question_ID, DATE(answer_date)
        )
        ORDER BY answer_date DESC
    ";
    
    // Preparar a consulta
    if ($stmt = $mysqli->prepare($query)) {
        // Vincular os parâmetros
        $stmt->bind_param("ii", $userId, $userId);
        
        // Executar a consulta
        $stmt->execute();
        
        // Armazenar o resultado
        $result = $stmt->get_result();
        
        // Criar um array para armazenar as respostas mais recentes do usuário
        $answers = [];

        // Iterar sobre o resultado da consulta
        while ($row = $result->fetch_assoc()) {
            // Adicionar as respostas ao array de forma imutável
            $answers[] = (object)[
                'question_ID' => $row['question_ID'],
                'is_correct' => $row['is_correct'],
                'answer_date' => $row['answer_date']
            ];
        }
        
        // Fechar o statement
        $stmt->close();
        
        // Retornar as respostas mais recentes como um array de objetos
        return $answers;
    }
    
    // Em caso de erro na consulta, retornar null
    return null;
}

function isQuestionAnswered($answers, $questionId) {
    // Verifica se $answers é um array válido
    if (is_array($answers)) {
        foreach ($answers as $answer) {
            if ($answer->question_ID == $questionId) {
                return $answer->is_correct; // Retorna o valor de is_correct se a questão foi respondida
            }
        }
    }
    return null; // Retorna null se a questão não foi respondida
}

?>