<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu do PDV</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link rel="stylesheet" href="./css/app.css">
</head>
<body>
    <div class="card mb-4">
        <h1 class="text-center mb-4">Menu do PDV</h1>
        <ul class="list-group mb-3">
            <li class="list-group-item text-center "><a href="realizar_venda.php">Realizar Venda</a></li>
            <li class="list-group-item text-center "><a href="extrato_parcial.php">Extrato Parcial</a></li>
            <li class="list-group-item text-center "><a href="cancelar_venda.php">Cancelar Venda</a></li>
            <li class="list-group-item text-center "><a href="fechamento_pdv.php">Fechamento de PDV</a></li>
        </ul>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
