<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados dos Cadernos</title>

    <!-- Boxicons Icons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <style>
    :root {
        --main-color: #648e4a;
        --logo-blue: #1d3969;
        --logo-green: #007700;
        --light-green: #6aac41;
        --green-todbg: #b3e295;
        --background-blue: #1d3969;
        /* Fundo azul */
    }

    body {
        font-family: Arial, sans-serif;
        background-color: var(--background-blue);
        /* Fundo azul */
        color: white;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        opacity: 0;
        animation: fadeIn 1s forwards;
        /* Efeito fade-in para o container */
        color: #333;
        /* Cor do texto dentro do container */
    }

    h1 {
        color: var(--main-color);
        text-align: center;
        margin-bottom: 20px;
    }

    .search-box {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .search-box input {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 300px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 12px;
        text-align: center;
    }

    th {
        background-color: var(--main-color);
        color: white;
    }

    tr:nth-child(even) {
        background-color: var(--green-todbg);
    }

    .icon {
        font-size: 20px;
        color: var(--logo-blue);
    }

    /* Estilo para o botão de voltar */
    .back-button {
        display: inline-block;
        padding: 10px 20px;
        margin-bottom: 20px;
        background-color: var(--logo-blue);
        color: white;
        text-align: center;
        border-radius: 8px;
        text-decoration: none;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .back-button:hover {
        background-color: var(--light-green);
        color: white;
    }

    /* Fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Botão para voltar à área de cadernos -->
        <a href="books.php" class="back-button"><i class='bx bx-arrow-back'></i> Voltar para Área de Cadernos</a>

        <h1><i class='bx bx-book-alt'></i> Resultados dos Cadernos</h1>

        <!-- Barra de pesquisa -->
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Pesquisar pelo nome do Caderno..."
                onkeyup="filterResults()">
        </div>

        <!-- Tabela de resultados -->
        <table id="resultsTable">
            <thead>
                <tr>
                    <th><i class='bx bx-book'></i> Caderno</th>
                    <th><i class='bx bx-edit-alt'></i> Total Respondido</th>
                    <th><i class='bx bx-check'></i> Corretas</th>
                    <th><i class='bx bx-x'></i> Erradas</th>
                    <th><i class='bx bx-time'></i> Tempo Finalizado</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aqui os resultados serão inseridos via PHP -->
                <?php
                session_start();
                require_once('./includes/connection.php');
                require_once('./includes/functions.php');
                require_once('./includes/protect.php');
                include_once('./includes/loading.php'); // Conexão com o banco de dados

                // Verifica se a sessão está definida
                if (isset($_SESSION['id'])) {
                    $userId = $_SESSION['id'];

                    // Consulta ao banco, ordenando pelos resultados mais recentes
                    $query = "SELECT book, user_ID, total_answered, corrects, wrongs, finished_time FROM users_books_results WHERE user_ID = ? ORDER BY finished_time DESC";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('i', $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Exibe os resultados
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['book']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['total_answered']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['corrects']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['wrongs']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['finished_time']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Nenhum resultado encontrado.</td></tr>";
                    }

                    $stmt->close();
                    $mysqli->close();
                } else {
                    echo "<tr><td colspan='6'>Sessão não iniciada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
    function filterResults() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const tableRows = document.querySelectorAll('#resultsTable tbody tr');

        tableRows.forEach(row => {
            const bookTitle = row.cells[0].textContent.toLowerCase();
            if (bookTitle.includes(searchInput)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    </script>
</body>

</html>