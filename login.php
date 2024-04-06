<?php
    require_once("conn.php");
    require_once("Usuario.php");
    $vida_da_sessao = 30 * 60;
    session_set_cookie_params($vida_da_sessao);
    session_start();

    if (isset($_COOKIE["user"])) {
        header("Location: http://localhost/inter-2024/home.php");
    }
    if (isset($_POST["user"]) && isset($_POST["pass"])) {
        $nome = $_POST["user"];
        $sql = "SELECT * FROM usuarios WHERE usuario='$nome'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $linha = mysqli_fetch_assoc($result);
            $nome = $linha['usuario'];
            $senha_cifrada = $linha['senha'];
            $usuario_correto = $nome;
            $senha_correta = $senha_cifrada;
        }
        $senha_form = $_POST["pass"];
        if (isset($senha_form) && isset($linha['senha'])) {
            $verifificado = $senha_form == $linha['senha'];
            if ($_POST["user"] == $usuario_correto && $verifificado) {
                setcookie('user', $usuario_correto, time() + 3600);
                header("Location: http://localhost/inter-2024/home.php");
                $_SESSION["logged_user"] = new Usuario($usuario_correto, $senha_correta, $linha['admin']);
            } else {
                $mensagem_erro = "Usuário ou senha incorretos";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style-geral.css">
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="shortcut icon" type="imagex/png" href="assets/j2.png">
</head>
<body>
    <div class="container-login">
        <?php if (isset($mensagem_erro)) { ?>
            <p style="color:red;font-size:24px;"><?php echo $mensagem_erro; ?></p>
        <?php } ?>
        <img src="assets/logo.jpg" alt="" class="logo">
        <div class="form">
            <form class="form-pass" method="post" action="">
                <spam class="login-label">Login</spam>
                <input type="text" class="login" name="user" id="user">
                <spam class="pass-label">Senha</spam>
                <input type="password" class="pass" name="pass" id="pass">
                <input type="submit" name="acao" value="Entrar" class="send-button">
            </form>
        </div>
    </div>
</body>
</html>