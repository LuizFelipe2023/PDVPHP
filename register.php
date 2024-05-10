<?php
require_once("./config/connect.php");

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $msg = "Por favor, preencha todos os campos.";
    } else {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $msg = "Este e-mail já está sendo usado.";
        } else {
            $sql = "INSERT INTO usuarios (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            if ($stmt->execute([$email, $hashed_password])) {
                $msg = "Usuário cadastrado com sucesso.";
                header("location: login.php");
                exit();
            } else {
                $msg = "Erro ao cadastrar usuário.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar - PDV</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .register-form {
            max-width: 350px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 576px) {
            .container {
                margin-top: 20px;
            }
            .col-md-6 {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Registrar - PDV</h2>
        <div class="row justify-content-center">
            <div class=" register-form col-md-6">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    </div>
                    <div class="text-center">
                        <p><?php echo $msg; ?></p>
                        <p>Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
