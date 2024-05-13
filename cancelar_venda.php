<?php
require_once("./config/connect.php");
session_start();

$msg = '';

if ($_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

try {
    $query = "SELECT id, tipo, valor FROM vendas";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $vendaId = $_GET["id"];

        if (!is_numeric($vendaId) || $vendaId <= 0) {
            $msg = "ID de venda inválido.";
        } else {
            $stmt2 = $conn->prepare("DELETE FROM vendas WHERE id = ?");
            $stmt2->bindParam(1, $vendaId, PDO::PARAM_INT);

            if ($stmt2->execute()) {
                header("Location: menu.php");
                exit();
            } else {
                $msg = "Erro ao excluir a venda.";
            }
        }
    }
} catch (PDOException $e) {
    $msg = "Erro ao recuperar lista de vendas: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/app.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Cancelar Venda</title>
</head>

<body>
    <div class="container">
        <div class="extrato-container">
            <h2>Lista de vendas:</h2>
            <div class="error-container">
                <?php if (!empty($msg)) { ?>
                    <div class="alert alert-danger"><?php echo $msg; ?></div>
                <?php } ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo de Venda</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vendas as $venda) { ?>
                        <tr>
                            <td><?php echo $venda['id']?></td>
                            <td><?php echo $venda['tipo']; ?></td>
                            <td>R$ <?php echo $venda['valor']; ?></td>
                            <td>
                                <button class="btn-excluir" data-id="<?php echo $venda['id']; ?>">Excluir</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="menu.php" class="btn btn-primary mt-3">Retorna para o menu principal</a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function() {
            $(".btn-excluir").click(function() {
                if (confirm("Tem certeza que deseja excluir esta venda?")) {
                    var vendaId = $(this).data("id");
                    window.location.href = "cancelar_venda.php?id=" + vendaId;
                }
            });
        });
    </script>
</body>

</html>
