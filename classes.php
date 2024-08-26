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
    <link rel="stylesheet" href="./style/classes.css">
    <title>DVC - QUESTÕES</title>
</head>

<body>
    <div style="background-color: white;">
        <?php require_once('./includes/navbar.php');?>
        <?php require_once('./includes/nav_menu.php');?>
    </div>
    <main id="root">
        <div class="container">
            <h1>404</h1>
            <p>Página Não Encontrada</p>
            <a href="/">Voltar para a Página Inicial</a>
        </div>
    </main>
</body><?php include_once('./includes/footer.php')?>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>

 </html>