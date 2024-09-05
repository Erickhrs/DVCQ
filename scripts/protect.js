$.getJSON('./includes/connection_validate.php', function(data) {
    var validation = data;
    if (validation !== 'true') {
        document.getElementById('root').innerHTML = `
            <link rel="stylesheet" href="./style/protect.css">
            <div class="not-user-container">
                <ion-icon name="sad-outline"></ion-icon>
                <h1>Quem é você?</h1>
                <p>Parece que você não está conectado...</p>
                <a href="./login.php">Fazer Login</a>
            </div>`;
    }
   document.querySelector('.protected_content').style.display = "block";
});
