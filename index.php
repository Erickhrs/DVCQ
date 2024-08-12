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
    <header>
        <div id="nav-first-container">
            <img src="./assets/logo.svg" alt="logo dvc">
            <input type="search" class="searchInput" placeholder="o que procura?">
            <ion-icon name="search-outline"></ion-icon>
            <ion-icon name="reorder-three-outline" id="burguer"></ion-icon>
        </div>
        <div id="nav-second-container">
            <?php if(!isset($_SESSION['id'])){echo ' <a href="./login.php">Entrar</a>
            <a href="./signup.html">Criar uma conta gratuitamente</a>
            <ion-icon name="help-circle-outline" title="Central de ajuda"></ion-icon>';}?>
            <div>
                <img src="./assets/picc.jpg" alt="profile" class="profile_pic">
            </div>

        </div>

    </header>
    <nav>
        <ul id="nav-menus">
            <li><a href="#home">
                    <ion-icon name="home-outline"></ion-icon> Início
                </a></li>
            <li><a href="#questions">
                    <ion-icon name="book-outline"></ion-icon> Questões
                </a></li>
            <li><a href="#classes">
                    <ion-icon name="albums-outline"></ion-icon> Aulas
                </a></li>
            <li><a href="#exams">
                    <ion-icon name="copy-outline"></ion-icon> Concursos
                </a></li>
            <li><a href="#disciplines">
                    <ion-icon name="school-outline"></ion-icon> Disciplinas
                </a></li>
        </ul>
    </nav>
    <main id="root">

    </main>
</body>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>

</html>