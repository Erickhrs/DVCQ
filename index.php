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
    <title>DVC - QUESTÕES</title>
</head>

<body>
    <?php require_once('./includes/navbar.php');?>
    <?php require_once('./includes/nav_menu.php');?>
    <main id="root">
        <nav id="home-menu">
            <ul>
                <li><a href="">
                        <ion-icon name="rocket-outline"></ion-icon> Ambiente de estudos
                    </a></li>
                <li><a href="">
                        <ion-icon name="document-text-outline"></ion-icon> Cadernos e Simulados
                    </a></li>
                <li><a href="">
                        <ion-icon name="stats-chart-outline"></ion-icon> Meu Desempenho
                    </a></li>
            </ul>
            <main id="home-menu-root">

            </main>
        </nav>
    </main>
</body>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>

</html>