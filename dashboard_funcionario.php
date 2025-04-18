<?php
include 'conexao.php';

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_cargo'] != 'funcionario') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$nomeFuncionario = $_SESSION['user_name'];

$mensagem = "";
$pedidos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpfCliente = $_POST['cpf_cliente'];

    
    if (!empty($cpfCliente)) {
        
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
                GROUP_CONCAT(CONCAT(prod.Nome, ' (', pp.Quantidade, ')') SEPARATOR ', ') AS Produtos
            FROM TF_Pedido p
            JOIN TF_Cliente c ON p.PedidoCliente = c.idCliente
            JOIN Pedido_has_Produto pp ON p.idPedido = pp.TF_Pedido_idPedido
            JOIN TF_Produto prod ON pp.TF_Produto_idProduto = prod.idProduto
            WHERE c.CPF = :cpf
            GROUP BY p.idPedido
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute(['cpf' => $cpfCliente]);
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$pedidos) {
            $mensagem = "Nenhum pedido encontrado para este CPF.";
        }
    } else {
        $mensagem = "Por favor, insira um CPF válido.";
    }
}

if (isset($_POST['liberar_entrega'])) {
    $idPedido = $_POST['id_pedido'];

    $updateQuery = "
        UPDATE TF_Pedido
        SET StatusEntrega = 'Aguardando Cliente...'
        WHERE idPedido = :idPedido
    ";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute(['idPedido' => $idPedido]);

    $mensagem = "Status de entrega atualizado com sucesso!";
    header("Location: dashboard_funcionario.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Funcionário</title>
    <link rel="stylesheet" href="dashboard_funcionario.css">
</head>
<body>
    <div class="container">
        <h1>Bem Vindo(a), <?php echo htmlspecialchars($nomeFuncionario); ?>!</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="cpf_cliente">Consultar Pedidos do Cliente (CPF):</label>
                <input type="text" name="cpf_cliente" id="cpf_cliente" placeholder="Digite o CPF do cliente" required>
            </div>
            <button type="submit" class="btn">Consultar</button>
        </form>

        <?php if ($mensagem): ?>
            <p class="mensagem"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>

        <?php if ($pedidos): ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido">
                    <p><strong>Pedido #<?php echo $pedido['idPedido']; ?></strong></p>
                    <p>Cliente: <?php echo htmlspecialchars($pedido['Cliente']); ?></p>
                    <p>Data: <?php echo $pedido['Data']; ?></p>
                    <p>Endereço: <?php echo htmlspecialchars($pedido['Endereco']); ?></p>
                    <p>Status Pagamento: <?php echo htmlspecialchars($pedido['StatusPagamento']); ?></p>
                    <p>Valor Total: R$ <?php echo number_format($pedido['ValorTotal'], 2, ',', '.'); ?></p>
                    <p>Tipo: <?php echo htmlspecialchars($pedido['Tipo']); ?></p>
                    <p>Status Entrega: <?php echo htmlspecialchars($pedido['StatusEntrega']); ?></p>
                    <p>Produtos: <?php echo htmlspecialchars($pedido['Produtos']); ?></p>


                    <?php if ($pedido['StatusEntrega'] === 'Aguardando Atendente...'): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="id_pedido" value="<?php echo $pedido['idPedido']; ?>">
                            <button type="submit" name="liberar_entrega" class="btn btn-danger">Liberar Entrega</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <a href="index.php" class="btn">Voltar ao Menu</a>
    </div>
</body>
</html>
