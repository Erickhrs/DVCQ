<?php
session_start();
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
    <title>DVC - QUESTÕES</title>
</head>

<body>
    <div style="background-color: white;">
        <?php require_once('./includes/navbar.php');?>
        <?php require_once('./includes/nav_menu.php');?>
    </div>
    <main id="root">
        <nav id="home-menu">
            <ul>
                <li><a href="./index.php">
                        <ion-icon name="rocket-outline"></ion-icon> Ambiente de estudos
                    </a></li>
                <li><a href="./books.php" class="active">
                        <ion-icon name="document-text-outline"></ion-icon> Cadernos e Simulados
                    </a></li>
                <li><a href="./statistics.php">
                        <ion-icon name="stats-chart-outline"></ion-icon> Meu Desempenho
                    </a></li>
            </ul>
            <main id="home-menu-root">
                <nav id="nav-tools">
                    <select name="page" id="page">
                        <option value="book">Caderno</option>
                        <option value="exam">Simulados</option>
                    </select>
                    <button>Criar<i class='bx bx-plus'></i></button>
                </nav>
            </main>
        </nav>
    </main>
</body><?php include_once('./includes/footer.php')?>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./scripts/protect.js"></script>

</html>