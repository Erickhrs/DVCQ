<?php
// Conexão com o banco de dados
include('./includes/connection.php');

// Obtendo o ID do livro via GET
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    // Consulta para buscar o nome e as colunas relacionadas
    $query = "SELECT name, disciplines, subjects, courses, job_functions, job_role FROM users_books WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $selectedDisciplines, $selectedSubjects, $selectedCourses, $selectedJobFunctions, $selectedJobRoles);
    $stmt->fetch();
    $stmt->close();
    
    // Separar os valores em arrays para facilitar a comparação
    $selectedDisciplines = explode('/', $selectedDisciplines);
    $selectedSubjects = explode('/', $selectedSubjects);
    $selectedCourses = explode('/', $selectedCourses);
    $selectedJobFunctions = explode('/', $selectedJobFunctions);
    $selectedJobRoles = explode('/', $selectedJobRoles);
} else {
    echo "ID inválido.";
    exit;
}

// Função para buscar dados das tabelas
function fetchOptions($mysqli, $table, $column) {
    $query = "SELECT id, $column FROM $table";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $options = [];
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
    $stmt->close();
    return $options;
}

// Buscar disciplinas, matérias, funções de trabalho, papéis de trabalho e cursos
$disciplines = fetchOptions($mysqli, 'disciplines', 'discipline');
$subjects = fetchOptions($mysqli, 'subjects', 'subject');
$jobFunctions = fetchOptions($mysqli, 'job_functions', 'job_function');
$jobRoles = fetchOptions($mysqli, 'job_roles', 'job_role');
$courses = fetchOptions($mysqli, 'courses', 'course'); // Adicionando a tabela courses
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/edit_book.css">
    <title>Edição de Caderno</title>
    <style>
    :root {
        --main-color: #648e4a;
        --logo-blue: #1d3969;
        --logo-green: #007700;
        --light-green: #6aac41;
        --green-todbg: #b3e295;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 20px;
    }

    h1 {
        color: var(--logo-blue);
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input[type="text"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    h2 {
        color: var(--main-color);
        margin: 20px 0 10px;
    }

    h3 {
        color: var(--logo-green);
        margin-top: 15px;
        margin-bottom: 10px;
    }

    input[type="checkbox"] {
        margin-right: 10px;
    }

    button {
        background-color: var(--main-color);
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: var(--light-green);
    }
    </style>
</head>

<body>
    <h1>Editar Caderno</h1>
    <form id="editForm" action="./actions/update_book.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="name">Nome do Caderno:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <h2>Selecione Disciplinas, Matérias, Cursos e Funções:</h2>

        <h3>Disciplinas</h3>
        <?php foreach ($disciplines as $discipline): ?>
        <label>
            <input type="checkbox" name="disciplines[]" value="<?php echo $discipline['id']; ?>"
                <?php echo in_array($discipline['id'], $selectedDisciplines) ? 'checked' : ''; ?>>
            <?php echo htmlspecialchars($discipline['discipline']); ?>
        </label>
        <?php endforeach; ?>

        <h3>Matérias</h3>
        <?php foreach ($subjects as $subject): ?>
        <label>
            <input type="checkbox" name="subjects[]" value="<?php echo $subject['id']; ?>"
                <?php echo in_array($subject['id'], $selectedSubjects) ? 'checked' : ''; ?>>
            <?php echo htmlspecialchars($subject['subject']); ?>
        </label>
        <?php endforeach; ?>

        <h3>Cursos</h3>
        <?php foreach ($courses as $course): ?>
        <label>
            <input type="checkbox" name="courses[]" value="<?php echo $course['id']; ?>"
                <?php echo in_array($course['id'], $selectedCourses) ? 'checked' : ''; ?>>
            <?php echo htmlspecialchars($course['course']); ?>
        </label>
        <?php endforeach; ?>

        <h3>Funções de Trabalho</h3>
        <?php foreach ($jobFunctions as $jobFunction): ?>
        <label>
            <input type="checkbox" name="job_functions[]" value="<?php echo $jobFunction['id']; ?>"
                <?php echo in_array($jobFunction['id'], $selectedJobFunctions) ? 'checked' : ''; ?>>
            <?php echo htmlspecialchars($jobFunction['job_function']); ?>
        </label>
        <?php endforeach; ?>

        <h3>Papéis de Trabalho</h3>
        <?php foreach ($jobRoles as $jobRole): ?>
        <label>
            <input type="checkbox" name="job_roles[]" value="<?php echo $jobRole['id']; ?>"
                <?php echo in_array($jobRole['id'], $selectedJobRoles) ? 'checked' : ''; ?>>
            <?php echo htmlspecialchars($jobRole['job_role']); ?>
        </label>
        <?php endforeach; ?>

        <button type="submit">Salvar</button>
    </form>


    <script>
    function saveOptions() {
        const form = document.getElementById('editForm');
        const formData = new FormData(form);
        const selectedOptions = formData.getAll('options[]');
        console.log('Opções selecionadas:', selectedOptions);
        // Aqui você pode implementar a lógica para enviar os dados, se necessário.
    }
    </script>

</body>

</html>