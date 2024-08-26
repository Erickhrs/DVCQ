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
    <div style="background-color: white;">
        <?php require_once('./includes/navbar.php');?>
        <?php require_once('./includes/nav_menu.php');?>
    </div>

    <main id="root">
        <header>
            <h1>Questões</h1>
            <p id="filterDetails">DETALHES FILTRO ATUAL</p>
        </header>
        <form action="" method="get" id="filter">
            <div id="filter1">
                <input type="search" placeholder="Palavra chave" name="keys"
                    value="<?php echo isset($_GET['keys']) ? htmlspecialchars($_GET['keys']) : ''; ?>">

                <select id="discipline" name="discipline">
                    <?php getOptions($mysqli, 'disciplines', 'discipline', 'Disciplina', isset($_GET['discipline']) ? $_GET['discipline'] : ''); ?>
                </select>

                <select id="subjects" name="subject">
                    <?php getOptions($mysqli, 'subjects', 'subject', 'Assunto', isset($_GET['subject']) ? $_GET['subject'] : ''); ?>
                </select>

                <select id="banca" name="banca">
                    <?php getOptions($mysqli, 'bancas', 'banca', 'Banca', isset($_GET['banca']) ? $_GET['banca'] : ''); ?>
                </select>

                <select id="year" name="year">
                    <option value="">Ano da questão</option>
                    <script>
                    const selectedYear = "<?php echo isset($_GET['year']) ? $_GET['year'] : ''; ?>";
                    for (let ano = 1980; ano <= 2030; ano++) {
                        document.write(
                            `<option value="${ano}" ${ano == selectedYear ? 'selected' : ''}>${ano}</option>`);
                    }
                    </script>
                </select>

                <select id="job_position" name="job_roles">
                    <?php getOptions($mysqli, 'job_roles', 'job_role', 'Cargo', isset($_GET['job_roles']) ? $_GET['job_roles'] : ''); ?>
                </select>

                <select id="grade_level" name="grade_level">
                    <option value="">Nível</option>
                    <option value="fundamental"
                        <?php echo (isset($_GET['grade_level']) && $_GET['grade_level'] == 'fundamental') ? 'selected' : ''; ?>>
                        Fundamental</option>
                    <option value="médio"
                        <?php echo (isset($_GET['grade_level']) && $_GET['grade_level'] == 'médio') ? 'selected' : ''; ?>>
                        Médio</option>
                    <option value="superior"
                        <?php echo (isset($_GET['grade_level']) && $_GET['grade_level'] == 'superior') ? 'selected' : ''; ?>>
                        Superior</option>
                </select>

                <select id="course" name="course">
                    <?php getOptions($mysqli, 'courses', 'course', 'Formação', isset($_GET['course']) ? $_GET['course'] : ''); ?>
                </select>

                <select id="area_of_expertise" name="job_function">
                    <?php getOptions($mysqli, 'job_functions', 'job_function', 'Atuação', isset($_GET['job_function']) ? $_GET['job_function'] : ''); ?>
                </select>

                <select id="question_type" name="question_type">
                    <option value="mult"
                        <?php echo (isset($_GET['question_type']) && $_GET['question_type'] == 'mult') ? 'selected' : ''; ?>>
                        Múltipla Escolha</option>
                    <option value="tf"
                        <?php echo (isset($_GET['question_type']) && $_GET['question_type'] == 'tf') ? 'selected' : ''; ?>>
                        Verdadeiro ou Falso</option>
                </select>

                <select id="level" name="level">
                    <option value="">Dificuldade</option>
                    <option value="facil"
                        <?php echo (isset($_GET['level']) && $_GET['level'] == 'facil') ? 'selected' : ''; ?>>Fácil
                    </option>
                    <option value="medio"
                        <?php echo (isset($_GET['level']) && $_GET['level'] == 'medio') ? 'selected' : ''; ?>>Médio
                    </option>
                    <option value="dificil"
                        <?php echo (isset($_GET['level']) && $_GET['level'] == 'dificil') ? 'selected' : ''; ?>>Difícil
                    </option>
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
                <button type="button" onclick="window.location.href = window.location.pathname;">
                    <!-- Limpar -->
                    <ion-icon name="reload-outline"></ion-icon> Limpar
                </button>
                <input type="submit" value="FILTRAR">
            </div>
        </form>

        <div>
            <div id="ads_container">

            </div>
            <div id="questions_container">
                <?php include_once('./includes/get_default_questions.php'); ?>
            </div>
            <div>

            </div>
        </div>

    </main>

</body><?php include_once('./includes/footer.php')?>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>

</html>