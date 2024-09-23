<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/logo.ico" type="image/x-icon">

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/index.css">
    <link rel="stylesheet" href="./style/profile.css">



    <title>DVC - QUESTÕES</title>
</head>

<body>
    <!-- Navbar and Menu -->
    <div style="background-color: white;">
        <?php require_once('./includes/navbar.php');?>
        <?php require_once('./includes/nav_menu.php');?>
    </div>

    <!-- Main User Information -->
    <main id="root">
        <!-- User Header (Picture, Name, Status, Plan) -->
        <section class="user-header-section">
            <div class="user-header">
                <img src="<?php echo $_SESSION['picture'];?>" alt="User Picture" class="user-picture">
                <h1 class="user-name"><?php echo $_SESSION['name'];?></h1>
                <div id="infos">
                    <p class="user-status">Status: Ativo</p>
                    <p class="user-plan">Plano: Pago</p>
                </div>
            </div>
        </section>

        <!-- User Settings (Edit, Change Password, Activity History) -->
        <section id="settings" class="user-settings-section">
            <a href="./edit-profile.php">
                <ion-icon name="create-outline"></ion-icon>
                Editar informações
            </a>
            <a>
                <ion-icon name="star-outline"></ion-icon> Meu plano
            </a>
            <a href="./edit-psw.php">
                <ion-icon name="key-outline">
                </ion-icon> Alterar senha
            </a>
            <a>
                <ion-icon name="calendar-outline"></ion-icon>
                Ver histórico de atividade
            </a>
            <a href="logout.php" class="exit">
                <ion-icon name="exit-outline"></ion-icon>
                Desconectar
            </a>
        </section>

        <!-- Main User Information Container for Personal and Address Information -->
        <section class="user-info-container">
            <!-- Informações Pessoais -->
            <section class="user-info-section">
                <h2>
                    <ion-icon name="person-outline"></ion-icon>Informações Pessoais
                </h2>
                <div class="user-info">
                    <div class="user-info-group">
                        <label>Email:</label>
                        <p>email@domain.com</p>
                    </div>

                    <div class="user-info-group">
                        <label>Telefone:</label>
                        <p>(11) 99999-9999</p>
                    </div>

                    <div class="user-info-group">
                        <label>CPF:</label>
                        <p>123.456.789-10</p>
                    </div>

                    <div class="user-info-group">
                        <label>CNPJ:</label>
                        <p>12.345.678/0001-99</p>
                    </div>

                    <div class="user-info-group">
                        <label>Data de Nascimento:</label>
                        <p>01/01/1980</p>
                    </div>

                    <div class="user-info-group">
                        <label>Cliente Desde:</label>
                        <p>05/10/2010</p>
                    </div>
                </div>
            </section>

            <!-- Informações de Endereço -->
            <section class="user-info-section">
                <h2>
                    <ion-icon name="home-outline"></ion-icon></i> Endereço
                </h2>
                <div class="user-info">
                    <div class="user-info-group">
                        <label>Endereço:</label>
                        <p>Rua Exemplo, 123</p>
                    </div>

                    <div class="user-info-group">
                        <label>Bairro:</label>
                        <p>Bairro Exemplo</p>
                    </div>

                    <div class="user-info-group">
                        <label>Cidade:</label>
                        <p>São Paulo</p>
                    </div>

                    <div class="user-info-group">
                        <label>UF:</label>
                        <p>SP</p>
                    </div>

                    <div class="user-info-group">
                        <label>CEP:</label>
                        <p>12345-678</p>
                    </div>
                </div>
            </section>
        </section>
    </main>



    <!-- Footer -->
    <?php include_once('./includes/footer.php')?>

    <!-- Scripts -->
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <script src="./scripts/spa.js" type="module"></script>
    <script src="./scripts/global.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./scripts/protect.js"></script>
</body>

</html>