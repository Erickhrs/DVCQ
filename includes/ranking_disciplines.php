<?php
include('./includes/connection.php');

// Consulta todas as disciplinas
$query_disciplines = "SELECT * FROM disciplines";
$result_disciplines = $mysqli->query($query_disciplines);

if ($result_disciplines->num_rows > 0) {
    echo "<div class='ranking-container'>";
    echo "<h2>Ranking de Disciplinas</h2>";
    echo "<table class='ranking-table'>";
    echo "<thead><tr><th>Disciplina</th><th>Quantidade de Questões</th></tr></thead>";
    echo "<tbody>";

    // Loop pelas disciplinas
    while ($row = $result_disciplines->fetch_assoc()) {
        $discipline_id = $row['ID'];
        $discipline_name = $row['discipline'];

        // Contar quantas questões estão vinculadas a esta disciplina
        $query_count_questions = "SELECT COUNT(*) as total FROM questions WHERE FIND_IN_SET('$discipline_id', REPLACE(discipline, '-', ','))";
        $result_count_questions = $mysqli->query($query_count_questions);
        $count = $result_count_questions->fetch_assoc()['total'];

        // Exibir o nome da disciplina e a contagem de questões
        echo "<tr><td>$discipline_name</td><td>$count</td></tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<p>Nenhuma disciplina encontrada.</p>";
}
?>

<style>
/* Container do ranking */
.ranking-container {
    margin: 40px auto;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    margin-top: 40px;
    margin-bottom: 10%;
}

/* Título */
.ranking-container h2 {
    color: #007bff;
    font-size: 24px;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-align: left;
}

/* Estilo da tabela */
.ranking-table {
    width: 100%;
    border-collapse: collapse;
}

.ranking-table th,
.ranking-table td {
    padding: 12px 15px;
    text-align: left;
}

.ranking-table thead th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.ranking-table tbody tr {
    background-color: #f9f9f9;
    border-bottom: 1px solid #ddd;
}

.ranking-table tbody tr:nth-child(even) {
    background-color: #f1f1f1;
}

.ranking-table tbody tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

.ranking-table tbody td {
    color: #333;
    font-size: 16px;
}

/* Estilo das células de cabeçalho */
.ranking-table th {
    border-bottom: 2px solid #007bff;
}

/* Efeito hover nas linhas */
.ranking-table tbody tr:hover {
    background-color: #e9ecef;
}


/* Ajuste em telas pequenas */
@media (max-width: 600px) {
    .ranking-container {
        padding: 10px;
    }

    .ranking-table th,
    .ranking-table td {
        font-size: 14px;
        padding: 10px;
    }

    .ranking-container h2 {
        font-size: 20px;
    }
}
</style>