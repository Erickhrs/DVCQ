<?php
session_start();
include_once('./includes/loading.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/index.css">
    <link rel="stylesheet" href="./style/books.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>DVC - QUESTÕES</title>
</head>

<body>
    <div style="background-color: white;">
        <?php require_once('./includes/navbar.php');?>
        <?php require_once('./includes/nav_menu.php');?>
    </div>
    <main id="root">
        <?php include('./includes/wpp_btn.php');?>
        <nav id="home-menu">
            <ul>
                <li><a href="./index.php">
                        <ion-icon name="rocket-outline"></ion-icon> Ambiente de estudos
                    </a></li>
                <li><a href="./books.php" class="active">
                        <ion-icon name="document-text-outline"></ion-icon> Cadernos
                    </a></li>
                <li><a href="./statistics.php">
                        <ion-icon name="stats-chart-outline"></ion-icon> Meu Desempenho
                    </a></li>
            </ul>
            <div class="container animate__animated animate__fadeInUp">
                <div class="header">
                    <h1>Cadernos de <?php echo $_SESSION['name']; ?></h1>
                    <div class="search-bar">
                        <input type="text" id="searchInput" placeholder="Busque pelo nome">
                        <button class="create-button">Criar <i>+</i></button>
                    </div>
                </div>

                <ul class="notebook-list" id="notebookList" class="animate__animated animate__fadeInUp">
                    <?php include_once('./includes/get_books.php')?>
                </ul>
            </div>
        </nav>
    </main>

    <div id="createBookModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Criar Novo Caderno</h2>
            <form id="createNotebookForm">
                <label for="notebookName">Nome do Caderno:</label>
                <input type="text" id="notebookName" name="notebookName" required>
                <button type="submit">Criar</button>
            </form>
        </div>
    </div>

</body>
<?php include_once('./includes/footer.php')?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./scripts/books.js"></script>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>
<script src="./scripts/protect.js"></script>

</html>