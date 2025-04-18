<?php
session_start();
include 'conexao.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['user_cargo'] != 'cliente') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT saldo FROM TF_Cliente WHERE idCliente = :idCliente");
$stmt->execute(['idCliente' => $user_id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    echo "Cliente não encontrado!";
    exit();
}

$saldoCliente = $cliente['saldo'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer Compra</title>
    <link rel="stylesheet" href="fazerCompra.css">
</head>
<body>

    <div class="container">
        <h1>Fazer Compra</h1>

        <div class="saldo">
            <p>Saldo disponível: R$ <?php echo number_format($saldoCliente, 2, ',', '.'); ?></p>
        </div>

        <form method="POST">
            <div class="produtos">
                <?php
                
                $queryProdutos = "SELECT idProduto, Nome, PrecoUnitario, Desconto, Estoque FROM TF_Produto";
                $stmtProdutos = $pdo->prepare($queryProdutos);
                $stmtProdutos->execute();
                $produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

                foreach ($produtos as $produto) {
                    echo '<div class="produto">';
                    echo '<label for="produto_' . $produto['idProduto'] . '">' . $produto['Nome'] . '</label>';
                    echo '<input type="number" name="produto[' . $produto['idProduto'] . ']" value="0" min="0" id="produto_' . $produto['idProduto'] . '" /> ';
                    echo 'Preço: R$ ' . $produto['PrecoUnitario'] . ' | Desconto: R$ ' . $produto['Desconto'] . ' | Estoque: ' . $produto['Estoque'];
                    echo '</div>';
                }
                ?>
            </div>

            
            <div class="endereco">
                <label for="endereco">Endereço para entrega:</label>
                <input type="text" name="endereco" id="endereco" placeholder="Digite o endereço de entrega" required />
            </div>

            
            <div class="tipo-pedido">
                <label for="tipoPedido">Tipo de Pedido:</label>
                <select name="tipoPedido" id="tipoPedido" required>
                    <option value="delivery">Delivery</option>
                    <option value="loja">Loja Física</option>
                </select>
            </div>

            
            <div class="status-pagamento">
                <label for="statusPagamento">Forma de pagamento:</label>
                <select name="statusPagamento" id="statusPagamento" required>
                    <option value="a vista">À vista</option>
                    <option value="na entrega">Pagamento na entrega</option>
                </select>
            </div>

            
            <button type="submit" name="finalizarPedido">Finalizar Pedido</button>
        </form>

        
        <a href="dashboard_cliente.php">Voltar para o menu do Cliente</a>
    </div>

</body>
</html>

<?php

if (isset($_POST['finalizarPedido'])) {
    $enderecoEntrega = $_POST['endereco'];
    $tipoPedido = $_POST['tipoPedido'];
    $statusEntrega = ($tipoPedido == 'delivery') ? 'Aguardando Atendente...' : 'Aguardando Cliente...';
    $statusPagamento = $_POST['statusPagamento'];
    $dataPedido = date('Y-m-d H:i:s'); 

    
    $valorTotal = 0;
    $produtos = $_POST['produto']; 


    $produtosIndisponiveis = [];

    foreach ($produtos as $produtoId => $quantidade) {
        if ($quantidade > 0) {
            $produtoQuery = "SELECT PrecoUnitario, Desconto, Estoque FROM TF_Produto WHERE idProduto = ?";
            $produtoStmt = $pdo->prepare($produtoQuery);
            $produtoStmt->execute([$produtoId]);
            $produto = $produtoStmt->fetch(PDO::FETCH_ASSOC);

            if ($produto) {
                if ($quantidade > $produto['Estoque']) {
                    $produtosIndisponiveis[] = $produto['Nome'];
                } else {
                    $valorProduto = ($produto['PrecoUnitario'] - $produto['Desconto']) * $quantidade;
                    $valorTotal += $valorProduto;
                }
            }
        }
    }

    if (!empty($produtosIndisponiveis)) {
        echo "Os seguintes produtos estão fora de estoque: " . implode(', ', $produtosIndisponiveis);
        exit();
    }

    if ($saldoCliente >= $valorTotal) {
        $insertPedidoQuery = "INSERT INTO TF_Pedido (PedidoCliente, Tipo, StatusEntrega, StatusPagamento, ValorTotal, Endereco, Data)
                              VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $pdo->prepare($insertPedidoQuery);
        $insertStmt->execute([$user_id, $tipoPedido, $statusEntrega, $statusPagamento, $valorTotal, $enderecoEntrega, $dataPedido]);

        $pedidoId = $pdo->lastInsertId();

        foreach ($produtos as $produtoId => $quantidade) {
            if ($quantidade > 0) {
                $updateEstoqueQuery = "UPDATE TF_Produto SET Estoque = Estoque - ? WHERE idProduto = ?";
                $updateEstoqueStmt = $pdo->prepare($updateEstoqueQuery);
                $updateEstoqueStmt->execute([$quantidade, $produtoId]);

                $insertProdutoQuery = "INSERT INTO Pedido_has_Produto (TF_Pedido_idPedido, TF_Produto_idProduto, quantidade)
                                       VALUES (?, ?, ?)";
                $insertProdutoStmt = $pdo->prepare($insertProdutoQuery);
                $insertProdutoStmt->execute([$pedidoId, $produtoId, $quantidade]);
            }
        }

        $novoSaldo = $saldoCliente - $valorTotal;
        $updateSaldoQuery = "UPDATE TF_Cliente SET saldo = ? WHERE idCliente = ?";
        $updateSaldoStmt = $pdo->prepare($updateSaldoQuery);
        $updateSaldoStmt->execute([$novoSaldo, $user_id]);

        echo '<div class="mensagem-sucesso"><i class="fa fa-check-circle"></i> Pedido realizado com sucesso!</div>';
        
    } else {
        echo "Saldo insuficiente para realizar o pedido.";
    }
}
?>
