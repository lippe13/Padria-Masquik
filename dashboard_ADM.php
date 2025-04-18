<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_cargo'] != 'adm') {
    header('Location: login.php');
    exit();
}

$nomeADM = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard ADM</title>
    <link rel="stylesheet" href="dashboard_ADM.css">
</head>
<body>
    <div class="container">
        <h1>Bem Vindo(a), <?php echo htmlspecialchars($nomeADM); ?>!</h1>

        <div class="buttons">
            <a href="cadastroADM.php" class="btn">Adicionar ADM</a>
            <a href="adicionarGerente.php" class="btn">Adicionar Gerente</a>
            <a href="removerGerente.php" class="btn">Remover Gerente</a>
            <a href="adicionarProduto.php" class="btn">Adicionar Produto</a>
            <a href="verProdutos.php" class="btn">Ver Produtos</a>
            <a href="index.php" class="btn btn-secondary">Voltar ao Menu</a>
        </div>
    </div>
</body>
</html>
