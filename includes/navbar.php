<?php
echo '
<header style="background-color: white!important;">
    <div id="nav-first-container">
        <img src="./assets/logo.svg" alt="logo dvc">
        <input type="search" class="searchInput" placeholder="o que procura?">
        <ion-icon name="search-outline"></ion-icon>
        <ion-icon name="reorder-three-outline" id="burguer"></ion-icon>
    </div>
    <div id="nav-second-container">';
    
if (!isset($_SESSION["id"])) {
    echo '
        <a href="./login.php">Entrar</a>
        <a href="./signup.html">Criar uma conta gratuitamente</a>
        <ion-icon name="help-circle-outline" title="Central de ajuda"></ion-icon>';
} else { 
    echo '
        <div>
            <a href="#profile" style="background-color: transparent">
                <img src="./assets/picc.jpg" alt="profile" class="profile_pic">
            </a>
        </div>';
}

echo '
    </div>
</header>';
?>