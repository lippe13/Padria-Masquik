<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_cargo'] != 'gerente') {
    header('Location: login.php');
    exit();
}

$nomeGerente = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Gerente</title>
    <link rel="stylesheet" href="dashboard_gerente.css">
</head>
<body>
    <div class="container">
        <h1>Bem Vindo(a), <?php echo htmlspecialchars($nomeGerente); ?>!</h1>
        <div class="buttons">
            <a href="cadastroFuncionario.php" class="btn">Cadastrar Funcionário</a>
            <a href="removerFuncionario.php" class="btn">Remover Funcionário</a>
            <a href="verPedidos.php" class="btn">Pedidos</a>
            <a href="index.php" class="btn">Voltar ao Menu</a>
        </div>
    </div>
</body>
</html>
