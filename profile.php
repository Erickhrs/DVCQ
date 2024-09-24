<?php
session_start();
require_once('./includes/connection.php'); // Supondo que você tenha um arquivo de conexão
require_once('./includes/protect.php');
// Recuperar o ID do usuário da sessão
$user_id = $_SESSION['id'];

// Consultar os dados do usuário no banco de dados
$query = "SELECT name, email, phone, address, district, city, UF, CEP, birth, since FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

// Verifique se o usuário foi encontrado
if (!$user_data) {
    // Redirecionar ou mostrar mensagem de erro
    echo "Usuário não encontrado.";
    exit();
}
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
                    <p class="user-plan">Plano: <?php echo $_SESSION['plan'];?></p>
                </div>
            </div>
        </section>

        <!-- User Settings (Edit, Change Password, Activity History) -->
        <section id="settings" class="user-settings-section">
            <a href="./edit-profile.php">
                <ion-icon name="create-outline"></ion-icon>
                Editar informações
            </a>
            <a href="./my-plan.php">
                <ion-icon name="star-outline"></ion-icon> Meu plano
            </a>
            <a href="./edit-psw.php">
                <ion-icon name="key-outline"></ion-icon> Alterar senha
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
                    <ion-icon name="person-outline"></ion-icon> Informações Pessoais
                </h2>
                <div class="user-info">
                    <div class="user-info-group">
                        <label>Email:</label>
                        <p><?php echo htmlspecialchars($user_data['email']); ?></p>
                    </div>

                    <div class="user-info-group">
                        <label>Telefone:</label>
                        <p><?php echo htmlspecialchars($user_data['phone']); ?></p>
                    </div>

                    <div class="user-info-group">
                        <label>Data de Nascimento:</label>
                        <p><?php echo htmlspecialchars(date('d/m/Y', strtotime($user_data['birth']))); ?></p>
                    </div>

                    <div class="user-info-group">
                        <label>Cliente Desde:</label>
                        <p><?php echo htmlspecialchars(date('d/m/Y', strtotime($user_data['since']))); ?></p>
                    </div>
                </div>
            </section>

            <!-- Informações de Endereço -->
            <section class="user-info-section">
                <h2>
                    <ion-icon name="home-outline"></ion-icon> Endereço
                </h2>
                <div class="user-info">
                    <div class="user-info-group">
                        <label>Endereço:</label>
                        <p><?php echo htmlspecialchars($user_data['address']); ?></p>
                    </div>

                    <div class="user-info-group">
                        <label>Bairro:</label>
                        <p><?php echo htmlspecialchars($user_data['district']); ?></p>
                    </div>

                    <div class="user-info-group">
                        <label>Cidade:</label>
                        <p><?php echo htmlspecialchars($user_data['city']); ?></p>
                    </div>

                    <div class="user-info-group">
                        <label>UF:</label>
                        <p><?php echo htmlspecialchars($user_data['UF']); ?></p>
                    </div>

                    <div class="user-info-group">
                        <label>CEP:</label>
                        <p><?php echo htmlspecialchars($user_data['CEP']); ?></p>
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