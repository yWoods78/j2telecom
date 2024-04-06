<?php
    require_once("conn.php");
    require_once("Usuario.php");
    session_start();
    $objeto = $_SESSION["logged_user"];
    if (!isset($_COOKIE["user"])) {
        header("Location: http://localhost/inter-2024/login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style-geral.css">
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="shortcut icon" type="imagex/png" href="assets/j2.png">
</head>
<body>
    <div class="header">
        <a href="home.php" class="container-logo">
            <img src="assets/logo.jpg" alt="" class="logo-header">
        </a>
        <div class="rotas-container">
            <a href="routes.php">ROTAS</a>
        </div>
        <div class="cadastro-container">
            <a href="clients.php">CLIENTES</a>
        </div>
        <div class="user-container" onclick="showinfos()">
            <img src="assets/user.png" alt="" class="user">
        </div>
    </div>

    <div class="home">
        <div class="box-containers">
            <a href="routes.php" class="container-routes">
                <div class="box-routes"><img src="assets/route.png" alt=""></div>
                <span class="label-routes">Rotas</span>
            </a>
            <a href="clients.php" class="container-clients">
                <div class="box-routes"><img src="assets/group.png" alt=""></div>
                <span class="label-routes">Clientes</span>
            </a>
        </div>
        <div class="pop-up-exit">
            <img src="assets/close.png" alt="" class="img-close" onclick="hideinfos()">
            <img src="assets/user.png" alt="" class="img-user">
            <span>Nome: <?php echo $objeto->getLogin(); ?></span>
            <span>Função: <?php if ($objeto->getisadmin() == 1) {
                echo "Admin";
            } else {
                echo "Operador";
            }
            ?></span>

            <a href="resetconn.php">
                <img src="assets/exit.png" alt="" class="img-exit" onclick="hideaddroute()">
            </a>
        </div>
    </div>
    
    <script>
        function showinfos() {
            var popup = document.getElementsByClassName("pop-up-exit")[0];
            popup.style.display = 'flex'
        }
        function hideinfos() {
            var popup = document.getElementsByClassName("pop-up-exit")[0];
            popup.style.display = 'none'
        }
    </script>
</body>
</html>
