<?php
include 'conexao.php';

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['user_cargo'] != 'adm' && $_SESSION['user_cargo'] != 'gerente')) {
    header('Location: login.php');
    exit();
}

try {

    $query = "
        SELECT 
            p.idPedido, 
            p.StatusPagamento, 
            p.ValorTotal, 
            p.Endereco, 
            p.Data, 
            p.Tipo, 
            p.StatusEntrega, 
            c.Nome AS Cliente, 
            c.CPF AS CPF_Cliente
        FROM TF_Pedido p
        JOIN TF_Cliente c ON p.PedidoCliente = c.idCliente
        ORDER BY p.Data DESC
    ";
    $stmt = $pdo->query($query);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Pedidos</title>
    <link rel="stylesheet" href="verPedidos.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Pedidos</h1>

        <?php if ($pedidos): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>CPF Cliente</th>
                        <th>Data</th>
                        <th>Endereço</th>
                        <th>Status Pagamento</th>
                        <th>Valor Total (R$)</th>
                        <th>Tipo</th>
                        <th>Status Entrega</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['idPedido']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['Cliente']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['CPF_Cliente']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['Data']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['Endereco']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['StatusPagamento']); ?></td>
                            <td><?php echo number_format($pedido['ValorTotal'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($pedido['Tipo']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['StatusEntrega']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum pedido encontrado.</p>
        <?php endif; ?>

        <a href="dashboard_gerente.php" class="btn">Voltar ao menu Gerente</a>
    </div>
</body>
</html>
