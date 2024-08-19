$filters = [];
$params = [];

if (!empty($_GET['keys'])) {
    $filters[] = "question_text LIKE ?";
    $params[] = '%' . $_GET['keys'] . '%';
}

if (!empty($_GET['discipline'])) {
    $filters[] = "discipline = ?";
    $params[] = $_GET['discipline'];
}

if (!empty($_GET['subject'])) {
    $filters[] = "subject = ?";
    $params[] = $_GET['subject'];
}

if (!empty($_GET['banca'])) {
    $filters[] = "banca = ?";
    $params[] = $_GET['banca'];
}

if (!empty($_GET['year'])) {
    $filters[] = "year = ?";
    $params[] = $_GET['year'];
}

if (!empty($_GET['job_roles'])) {
    $filters[] = "job_role = ?";
    $params[] = $_GET['job_roles'];
}

if (!empty($_GET['grade_level'])) {
    $filters[] = "grade_level = ?";
    $params[] = $_GET['grade_level'];
}

if (!empty($_GET['course'])) {
    $filters[] = "course = ?";
    $params[] = $_GET['course'];
}

if (!empty($_GET['job_function'])) {
    $filters[] = "job_function = ?";
    $params[] = $_GET['job_function'];
}

if (!empty($_GET['question_type'])) {
    $filters[] = "question_type = ?";
    $params[] = $_GET['question_type'];
}

if (!empty($_GET['level'])) {
    $filters[] = "level = ?";
    $params[] = $_GET['level'];
}

$sql = "SELECT * FROM questions";

if (count($filters) > 0) {
    $sql .= " WHERE " . implode(" AND ", $filters);
}

$stmt = $mysqli->prepare($sql);

if ($stmt !== false) {
    if (!empty($params)) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    
    // Aqui você pode iterar sobre os resultados e exibi-los
    while ($row = $result->fetch_assoc()) {
        echo "<div class='question'>{$row['question']}</div>";
    }

    $stmt->close();
}

$mysqli->close();