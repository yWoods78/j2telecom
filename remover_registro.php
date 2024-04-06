<?php
    if (isset($_POST['rua'])) {
        $rua = mysqli_real_escape_string($conn, $_POST['rua']);

        $sql = "DELETE FROM rotas WHERE rua = '$rua'";
        
        if (mysqli_query($conn, $sql)) {
            http_response_code(200);
            echo 'Registro removido com sucesso';
        } else {
            http_response_code(500);
            echo 'Erro ao remover registro: ' . mysqli_error($conn);
        }
    } else {
        http_response_code(400);
        echo 'rua do registro não fornecido';
    }

    mysqli_close($conn);
?>
