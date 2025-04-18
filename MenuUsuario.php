<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu da Padaria</title>
    <link rel="stylesheet" href="MenuUsuario.css">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="logo.png" alt="Logo Padaria do Masquik">
            </div>
            <h1>Padaria do Masquik</h1>
        </div>
    </header>

    <main>
        <div class="menu-options">
            <a href="FazerPedido.php" class="menu-btn">Fazer Pedido</a>
            <a href="SobreNos.php" class="menu-btn">Sobre Nós</a>
            <a href="VerPedidos.php" class="menu-btn">Ver seus pedidos</a>
            <a href="Produtos.php" class="menu-btn">Ver os produtos</a>
            <a href="Logout.php" class="menu-btn">Log-out</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Padaria Masquik. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
