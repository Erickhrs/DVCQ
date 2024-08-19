<?php
session_start();
require_once('./includes/connection.php');
require_once('./includes/functions.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/logo.ico" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
        <form action="" method="get" id="filter">
            <div id="filter1">
                <input type="search" placeholder="Palavra chave" name="keys">
                <select id="discipline" name="discipline">
                    <?php getOptions($mysqli, 'disciplines', 'discipline', 'Disciplina')?>
                </select>
                <select id="subjects" name="subject">
                    <?php getOptions($mysqli, 'subjects', 'subject', 'Assunto')?>
                </select>
                <select id="banca" name="banca">
                    <?php getOptions($mysqli, 'bancas', 'banca', 'Banca')?>
                </select>
                <select id="year" name="year">
                    <option value="">Ano</option>
                    <option value="">2004</option>
                    <option value="">2005</option>
                </select>
                <select id="job_position" name="job_roles">
                    <?php getOptions($mysqli, 'job_roles', 'job_role', 'Cargo')?>
                </select>
                <select id="grade_level" name="grade_level">
                    <option value="">Nível</option>
                    <option value="fundamental">Fundamental</option>
                    <option value="médio">Médio</option>
                    <option value="superior">Superior</option>
                </select>
                <select id="course" name="course">
                    <?php getOptions($mysqli, 'courses', 'course', 'Formação')?>
                </select>
                <select id="area_of_expertise" name="job_function">
                    <?php getOptions($mysqli, 'job_functions', 'job_function', 'Atuação')?>
                </select>
                <select id="question_type" name="question_type">
                    <option value="mult">Múltipla Escolha</option>
                    <option value="tf">Verdadeiro ou Falso</option>
                </select>
                <select id="level" name="level">
                    <option value="">Dificuldade</option>
                    <option value="facil">Fácil</option>
                    <option value="medio">Médio</option>
                    <option value="dificil">Difícil</option>
                </select>
            </div>
            <!-- <div id="filter2">
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
                </div>-->
            <div id="btns">
                <button>
                    <ion-icon name="reload-outline"></ion-icon> Limpar
                </button>
                <input type="submit" value="FILTRAR">
            </div>
        </form>
        <div id="questions_container">
            <form class="question">
                <div id="question_infos">
                    <span class="span_number_list">#1</span>
                    <span class="span_about">#DVC123</span>
                    <span class="span_about">1998</span>
                    <span class="span_about">Banca1</span>
                    <span class="span_about">médio</span>
                    <span class="span_about">multiplaescolha</span>
                    <span class="span_about">multiplaescolha</span>
                    <span class="span_about">multiplaescolha</span>
                </div>
                <span id="question">Banana, pacoba ou pacova[1] é uma pseudobaga da bananeira, uma planta herbácea vivaz acaule da
                    família Musaceae (género Musa - além do género Ensete, que produz as chamadas "falsas bananas").
                    São cultivadas em 130 países. Originárias do sudeste da Ásia são atualmente cultivadas em
                    praticamente todas as regiões tropicais do planeta.</span>
                <div id="options">
                    <div class="option">
                        <input type="radio" id="A" name="answer" value="A">
                        <label for="A">ero, certo? Muito tem se falado sobre identidade de gênero, igualdade de gênero, ideologia de gêneroero, certo? Muito tem se falado sobre identidade de gênero, igualdade de gênero, ideologia de gênero</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="B" name="answer" value="B">
                        <label for="B">ero, certo? Muito tem se falado sobre identidade de gênero, igualdade de gênero, ideologia de gêneroero, certo? Muito tem se falado sobre identidade de gênero, igualdade de gênero, ideologia de gênero</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="C" name="answer" value="C">
                        <label for="C">ero, certo? Muito tem se falado sobre identidade de gênero, igualdade de gênero, ideologia de gêneroero, certo? Muito tem se falado sobre identidade de gênero, igualdade de gênero, ideologia de gênero</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="D" name="answer" value="D">
                        <label for="D">ero, certo? Muito tem se falado sobre identidade de gênero, igualdade de gênero, ideologia de gêneroero, certo? Muito tem se falado sobre identidade de gênero, igualdade de gênero, ideologia de gênero</label>
                    </div>
                    <div class="option">
                        <input type="radio" id="E" name="answer" value="E">
                        <label for="E">ero, certo? Muito tem se falado sobre identidade de gênero, igualdade de gênero, ideologia de gêneroero, certo? Muito tem se falado sobre identidade de gênero, igualdade de gênero, ideologia de gênero</label>
                    </div>
                </div>
                <div id="question_tools">
                    <button type="submit" id="answerValidate">Responder</button>
                    <div id="tools">
                    <span><ion-icon name="chatbox-outline"></ion-icon> Gabarito</span>
                    <span><i class='bx bx-paperclip'></i>Gabarito</span>
                    <span><ion-icon name="chatbubbles-outline"></ion-icon>Comentários</span>
                    <span><ion-icon name="analytics-outline"></ion-icon>Estátisticas</span>
                    <span><ion-icon name="document-outline"></ion-icon>Criar Anotações</span>
                    <span><ion-icon name="flag-outline"></ion-icon>Erro</span>
                    </div>
                  
                </div>
            </form>
        </div>
    </main>
</body>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>

</html>