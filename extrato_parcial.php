<?php
require_once("./config/connect.php");

$stmt = $conn->prepare("SELECT tipo, SUM(valor) AS valor_parcial FROM vendas GROUP BY tipo");
$stmt->execute();
$valor_vale_comum = 0;
$valor_vale_estudantil = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['tipo'] === "vale_comum") {
        $valor_vale_comum = $row['valor_parcial'];
    } elseif ($row['tipo'] === "vale_estudantil") {
        $valor_vale_estudantil = $row['valor_parcial'];
    }
}
$valor_total = $valor_vale_comum + $valor_vale_estudantil;


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/app.css">
    <title>Extrato Parcial</title>
</head>

<body>
    <div class="container">
        <div class="extrato-container">
            <h2>Extrato Parcial</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tipo de Vale</th>
                        <th>Valor Parcial</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Vale Transporte Comum</td>
                        <td>R$ <?php echo $valor_vale_comum; ?></td>
                    </tr>
                    <tr>
                        <td>Vale Estudantil</td>
                        <td>R$ <?php echo $valor_vale_estudantil; ?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>R$ <?php echo $valor_total; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>