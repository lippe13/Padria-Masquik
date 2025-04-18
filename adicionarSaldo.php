<?php
session_start();
include 'conexao.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['user_cargo'] != 'cliente') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM TF_Cliente WHERE idCliente = :idCliente");
$stmt->execute(['idCliente' => $user_id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    echo "Cliente não encontrado!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = floatval($_POST['valor']);
    $metodo_pagamento = $_POST['metodo_pagamento'];

    if ($valor > 0) {

        $novo_saldo = $cliente['Saldo'] + $valor;
        $stmtUpdate = $pdo->prepare("UPDATE TF_Cliente SET Saldo = :saldo WHERE idCliente = :idCliente");
        $stmtUpdate->execute(['saldo' => $novo_saldo, 'idCliente' => $user_id]);

        $mensagem = "Saldo adicionado com sucesso!";
        $cliente['Saldo'] = $novo_saldo; 
    } else {
        $mensagem = "Por favor, insira um valor válido!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Saldo</title>
    <link rel="stylesheet" href="adicionarSaldo.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Adicionar Saldo à sua Carteira</h1>
        </header>
        
        <section class="saldo">
            <h2>Seu Saldo Atual: R$ <?php echo number_format($cliente['Saldo'], 2, ',', '.'); ?></h2>
        </section>

        <?php if (isset($mensagem)): ?>
            <section class="mensagem">
                <p><?php echo $mensagem; ?></p>
            </section>
        <?php endif; ?>

        <section class="formulario">
            <form action="adicionarSaldo.php" method="POST">
                <label for="valor">Valor a Adicionar:</label>
                <input type="number" name="valor" id="valor" step="0.01" required>

                <label for="metodo_pagamento">Método de Pagamento:</label>
                <select name="metodo_pagamento" id="metodo_pagamento" required>
                    <option value="cartao_credito">Cartão de Crédito</option>
                    <option value="cartao_debito">Cartão de Débito</option>
                    <option value="pix">PIX</option>
                </select>

                <button type="submit" class="button">Adicionar Saldo</button>
            </form>
        </section>

        <section class="actions">
            <a href="dashboard_cliente.php" class="button">VOLTAR À ÁREA DO CLIENTE</a>
        </section>
    </div>
</body>
</html>
