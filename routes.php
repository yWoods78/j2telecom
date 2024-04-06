<?php
    if (!isset($_COOKIE["user"])) {
        header("Location: http://localhost/inter-2024/login.php");
    }
    require_once("conn.php");
    require_once("Usuario.php");
    session_start();
    $objeto = $_SESSION["logged_user"];
    $sql = "SELECT * FROM rotas";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $table = $result;
    }
    function Redirect($url, $permanent = false)
    {
        if (headers_sent() === false)
        {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        }
    
        exit();
    }
    if (isset($_POST["rua"]) && isset($_POST["qtdc"]) && isset($_POST["ref"]) && isset($_POST["vagas"]) && isset($_POST["sprint"])) {
        $rua = $_POST["rua"];
        $qtdc = $_POST["qtdc"];
        $ref = $_POST["ref"];
        $vagas = $_POST["vagas"];
        $sprint = $_POST["sprint"];

        $stmt = $conn->prepare("INSERT INTO rotas (rua, qtdc, referencia, vagas, sprint) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $rua, $qtdc, $ref, $vagas, $sprint);
        $stmt->execute();
        $stmt->close();
        Redirect('http://localhost/inter-2024/routes.php', false);
    }
    if (isset($_POST['ruaid'])) {
        $rua = mysqli_real_escape_string($conn, $_POST['ruaid']);
        $sql = "DELETE FROM rotas WHERE rua = '$rua'";
        
        if (mysqli_query($conn, $sql)) {
            http_response_code(200);
        } else {
            http_response_code(500);
        }
    } else {
        http_response_code(400);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rotas</title>
    <link rel="stylesheet" type="text/css" href="style-geral.css">
    <link rel="stylesheet" type="text/css" href="routes.css">
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
    <div class="routes-container">
        <div class="nav-bar"><a href="home.php">HOME</a> > ROTAS</div>
        <div class="routes">
            <table class="table-container">
                <tr class="table-labels">
                    <td>RUA</td>
                    <td>QTD CAIXAS</td>
                    <td>REFERÊNCIA</td>
                    <td>VAGAS</td>
                    <td>TIPO SPRINT</td>
                    <?php
                        if ($objeto->getisadmin() == 1) {
                            echo "<td>AÇÃO</td>";
                        }
                    ?>
                </tr>
                <?php
                    if (isset($table)) {
                        for($j=0;$j<$table->num_rows;$j++) {
                            $linha = mysqli_fetch_assoc($table);
                            echo "<tr data-rua=\"{$linha['rua']}\">";
                                echo "<td>";
                                echo $linha['rua'];
                                echo "</td>";

                                echo "<td>";
                                echo $linha['qtdc'];
                                echo "</td>";

                                echo "<td>";
                                echo $linha['referencia'];
                                echo "</td>";

                                echo "<td>";
                                echo $linha['vagas'];
                                echo "</td>";

                                echo "<td>";
                                echo $linha['sprint'];
                                echo "</td>";

                                if ($objeto->getisadmin() == 1) {
                                    echo "<td>";
                                    echo "<img class='img-table' src=\"assets/remove.png\" onclick=\"showconfirm(this)\"></img>";
                                    echo "</td>";
                                }

                            echo "</tr>";
                        }
                    }
                ?>
            </table>
        </div>
        
        <div class="new-route-container" onclick="showaddroute()">
            <span class="plus">+</span>
            <span class="new-route-label">INSERIR NOVA ROTA</span>
        </div>
        <div class="pop-up-container">
            <img src="assets/close.png" alt="" class="img-close" onclick="hideaddroute()">
            <span>INSERIR NOVA ROTA</span>
            <form class="form-add" id="myForm" method="post" action="">
                <input type="text" placeholder="Rua" name="rua">
                <input type="number" placeholder="QTD CAIXAS" name="qtdc">
                <input type="text" placeholder="REFERÊNCIA" name="ref">
                <input type="number" placeholder="VAGAS" name="vagas">
                <input type="text" placeholder="TIPO SPRINT" name="sprint">
            </form>
            <button type="button" onclick="submitForm()" class="button-insert">INSERIR</button>
        </div>
        <div class="pop-up-confirm">
            <div class="text">
                <span>DESEJA EXCLUIR ESSA ROTA?</span>
            </div>
            <div class="buttons">
                <button onclick="removeRow()">SIM</button>
                <button onclick="hideconfirm()">NÃO</button>
            </div>
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
        var savedbtn = null;
        function showaddroute() {
            var popup = document.getElementsByClassName("pop-up-container")[0];
            popup.style.display = 'flex'
        }
        function hideaddroute() {
            var popup = document.getElementsByClassName("pop-up-container")[0];
            popup.style.display = 'none'
        }
        function showconfirm(button) {
            var popup = document.getElementsByClassName("pop-up-confirm")[0];
            popup.style.display = 'flex'
            savedbtn = button;
        }
        function hideconfirm() {
            var popup = document.getElementsByClassName("pop-up-confirm")[0];
            popup.style.display = 'none'
        }
        function showinfos() {
            var popup = document.getElementsByClassName("pop-up-exit")[0];
            popup.style.display = 'flex'
        }
        function hideinfos() {
            var popup = document.getElementsByClassName("pop-up-exit")[0];
            popup.style.display = 'none'
        }
        function removeRow() {
            var row = savedbtn.parentNode.parentNode; // Obtém a linha
            var rua = row.getAttribute('data-rua'); // Obtém o ID do atributo de dados
            row.remove(); // Remove a linha da tabela
            
            // Faz uma solicitação AJAX para remover o registro do banco de dados
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'routes.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Registro removido com sucesso');
                } else {
                    console.log('Erro ao remover registro');
                }
            };
            xhr.send('ruaid=' + rua);
            hideconfirm();
        }
        function submitForm() {
            document.getElementById("myForm").submit();
        }
    </script>
</body>
</html>