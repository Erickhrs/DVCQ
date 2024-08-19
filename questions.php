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
    <link rel="stylesheet" href="./style/questions.css">
    <title>DVC - QUESTÕES</title>
</head>

<body>
    <?php require_once('./includes/navbar.php');?>
    <?php require_once('./includes/nav_menu.php');?>
    <main id="root">
        <header>
            <h1>Questões</h1>
            <p id="filterDetails">DETALHES FILTRO ATUAL</p>
        </header>
        <form action="" method="get">
            <div id="filter1">
                <input type="search" placeholder="Palavra chave">
                <select id="discipline" name="discipline">
                    <option value="">Disciplinas</option>
                    <option value="">EXEMPLO 1</option>
                    <option value="">EXEMPLO 2</option>
                </select>
                <select id="subjects" name="">
                    <option value="">Assunto</option>
                    <option value="">EXEMPLO 1</option>
                    <option value="">EXEMPLO 2</option>
                </select>
                <select id="banca" name="">
                    <option value="">Banca</option>
                    <option value="">EXEMPLO 1</option>
                    <option value="">EXEMPLO 2</option>
                </select>
                <select id="year" name="year">
                    <option value="">Ano</option>
                    <option value="">2004</option>
                    <option value="">2005</option>
                </select>
                <select id="job_position" name="job_position">
                    <option value="">Cargo</option>
                    <option value="">EXEMPLO 1</option>
                    <option value="">EXEMPLO 2</option>
                </select>
                <select id="grade_level" name="grade_level">
                    <option value="">Nível</option>
                    <option value="">EXEMPLO 1</option>
                    <option value="">EXEMPLO 2</option>
                </select>
                <select id="course" name="course">
                    <option value="">Formação</option>
                    <option value="">EXEMPLO 1</option>
                    <option value="">EXEMPLO 2</option>
                </select>
                <select id="area_of_expertise" name="area_of_expertise">
                    <option value="">Atuação</option>
                    <option value="">EXEMPLO 1</option>
                    <option value="">EXEMPLO 2</option>
                </select>
                <select id="question_type" name="question_type">
                    <option value="">Modalidade</option>
                    <option value="">EXEMPLO 1</option>
                    <option value="">EXEMPLO 2</option>
                </select>
                <select id="level" name="level">
                    <option value="">Dificuldadee</option>
                    <option value="">EXEMPLO 1</option>
                    <option value="">EXEMPLO 2</option>
                </select>
            </div>
            <div id="filter2">
                <span>Excluir Questões:</span>
                <label for="opcao1">
                    <input type="checkbox" name="opcoes" value="opcao1"> Dos meus cadernos
                </label>
                <label for="opcao2">
                    <input type="checkbox" name="opcoes" value="opcao2"> Dos meus Simulados
                </label><br><br>
                <span>Questões com:</span>
                <label for="opcao3">
                    <input type="checkbox" name="opcoes" value="opcao3"> Gabarito comentado
                </label>
                <label for="opcao4">
                    <input type="checkbox" name="opcoes" value="opcao4"> Comentários
                </label>
                <label for="opcao5">
                    <input type="checkbox" name="opcoes" value="opcao5"> Meus Comentários
                </label>
                <label for="opcao6">
                    <input type="checkbox" name="opcoes" value="opcao6"> Aulas
                </label>
                <label for="opcao7">
                    <input type="checkbox" name="opcoes" value="opcao7"> Minhas anotações
                </label>
            </div>
            <div id="btns">
                <button>
                    <ion-icon name="reload-outline"></ion-icon> Limpar
                </button>
                <input type="submit" value="FILTRAR">
            </div>
        </form>
    </main>
</body>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>

</html>