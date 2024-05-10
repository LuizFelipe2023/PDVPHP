<?php
require_once("./config/connect.php");

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$msg = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["tipo"]) || empty($_POST["valor"])) { 
        $msg = "Preencha os campos!";
    } else {
        $tipo = $_POST["tipo"];
        $valor = floatval($_POST["valor"]);

        try {
            $sql = "INSERT INTO vendas(tipo, valor) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $tipo, PDO::PARAM_STR);
            $stmt->bindParam(2, $valor, PDO::PARAM_STR); 
            if ($stmt->execute()) {
                header("location: menu.php");
                exit();
            } else {
                $msg = "Erro ao inserir os valores na tabela de vendas.";
            }
        } catch (PDOException $e) {
            $msg = "Erro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/app.css">
    <title>Realizar Venda</title>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                <label for="tipo">Tipo de Vale Transporte</label>
                <select name="tipo" id="tipo">
                    <option value="">Selecione...</option>
                    <option value="vale_comum">Vale Transporte Comum</option>
                    <option value="vale_estudantil">Vale Estudantil</option>
                </select>
                <label for="valor">Preço:</label>
                <input type="number" class="form-control" id="valor" name="valor" step="0.01" required>
                <button type="submit" class="btn btn-primary">Realizar Venda</button>
            </form>
            <?php if (!empty($msg)): ?> 
                <p class="msg"><?php echo $msg; ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
