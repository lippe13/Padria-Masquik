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

$stmtPedidos = $pdo->prepare("SELECT * FROM TF_Pedido WHERE PedidoCliente = :idCliente");
$stmtPedidos->execute(['idCliente' => $user_id]);
$pedidos = $stmtPedidos->fetchAll();

$stmtProdutos = $pdo->prepare("SELECT p.Nome FROM TF_Produto p 
                               INNER JOIN Pedido_has_Produto ph ON ph.TF_Produto_idProduto = p.idProduto
                               WHERE ph.TF_Pedido_idPedido = :idPedido");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Cliente</title>
    <link rel="stylesheet" href="dashboard_cliente.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>ÁREA DO CLIENTE</h1>
            <p>Bem-vindo(a), <?php echo htmlspecialchars($cliente['Nome']); ?>!</p>
        </header>
        
        <section class="saldo">
            <h2>Seu Saldo: R$ <?php echo number_format($cliente['Saldo'], 2, ',', '.'); ?></h2>
        </section>

        <section class="pedidos">
            <h3>Seus Pedidos:</h3>
            <?php if (count($pedidos) > 0): ?>
                <ul>
                    <?php foreach ($pedidos as $pedido): ?>
                        <li>
                            <strong>ID do Pedido:</strong> <?php echo $pedido['idPedido']; ?> |
                            <strong>Status:</strong> <?php echo $pedido['StatusEntrega']; ?> |
                            <strong>Valor Total:</strong> R$ <?php echo number_format($pedido['ValorTotal'], 2, ',', '.'); ?> |
                            <strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['Data'])); ?> |
                            <strong>Tipo:</strong> <?php echo $pedido['Tipo']; ?>

                            
                            <ul>
                                <?php
                                
                                $stmtProdutos = $pdo->prepare("
                                    SELECT p.Nome, pp.quantidade 
                                    FROM TF_Produto p
                                    JOIN Pedido_has_Produto pp ON pp.TF_Produto_idProduto = p.idProduto
                                    WHERE pp.TF_Pedido_idPedido = :idPedido
                                ");
                                $stmtProdutos->execute(['idPedido' => $pedido['idPedido']]);
                                $produtos = $stmtProdutos->fetchAll();

                                
                                foreach ($produtos as $produto) {
                                    echo "<li>" . htmlspecialchars($produto['quantidade']) . " " . htmlspecialchars($produto['Nome']) . "</li>";
                                }
                                ?>
                            </ul>

                            <?php if ($pedido['Tipo'] == 'delivery' && $pedido['StatusPagamento'] == 'a vista' && $pedido['StatusEntrega'] == 'Aguardando Atendente...'): ?>
                                <p>Aguardando atendimento.</p>

                            <?php elseif ($pedido['Tipo'] == 'delivery' && $pedido['StatusEntrega'] == 'Aguardando Cliente...'): ?>
                                
                                <form action="atualizar_status.php" method="POST">
                                    <input type="hidden" name="idPedido" value="<?php echo $pedido['idPedido']; ?>">
                                    <button type="submit" class="button">Confirmar Entrega/Pagamento</button>
                                </form>
                            <?php elseif ($pedido['Tipo'] == 'loja'): ?>
                                
                                <form action="atualizar_status.php" method="POST">
                                    <input type="hidden" name="idPedido" value="<?php echo $pedido['idPedido']; ?>">
                                    <button type="submit" class="button">Pegar/Pagar Pedido</button>
                                </form>

                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Você ainda não fez pedidos.</p>
            <?php endif; ?>
        </section>

        <section class="actions">
            <a href="fazerCompra.php" class="button">FAZER COMPRA</a>
            <a href="adicionarSaldo.php" class="button">ADICIONAR SALDO</a>
            <a href="index.php" class="button">VOLTAR AO MENU</a>
        </section>
    </div>
</body>
</html>
