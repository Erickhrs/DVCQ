<?php
include('../includes/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Recuperar as opções selecionadas e separar por '/'
    $disciplines = isset($_POST['disciplines']) ? implode('/', $_POST['disciplines']) : null;
    $subjects = isset($_POST['subjects']) ? implode('/', $_POST['subjects']) : null;
    $courses = isset($_POST['courses']) ? implode('/', $_POST['courses']) : null;
    $job_functions = isset($_POST['job_functions']) ? implode('/', $_POST['job_functions']) : null;
    $job_roles = isset($_POST['job_roles']) ? implode('/', $_POST['job_roles']) : null;

    // Atualizando o nome e os IDs das colunas correspondentes
    $query = "UPDATE users_books 
              SET name = ?, disciplines = ?, subjects = ?, courses = ?, job_functions = ?, job_role = ? 
              WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssssi", $name, $disciplines, $subjects, $courses, $job_functions, $job_roles, $id);
    $stmt->execute();
    $stmt->close();

    // Redirecionando após a atualização
    header("Location: ../books.php"); // Altere para sua página de sucesso
    exit();
}
?>