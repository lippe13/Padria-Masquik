<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['idCliente'])) {
    header("Location: login.php");
    exit;
}

$idCliente = $_SESSION['idCliente'];
$quantidades = $_POST['quantidades'];
$statusPagamento = $_POST['StatusPagamento'];
$endereco = $_POST['Endereco'] === 'Outro' ? $_POST['EnderecoOutro'] : $_POST['Endereco'];
$tipo = $_POST['Tipo'];
$data = $_POST['Data'];

$statusEntrega = $tipo === 'Delivery' ? 'Aguardando Atendente...' : 'Entregue';
$valorTotal = 0;

foreach ($quantidades as $idProduto => $quantidade) {
    if ($quantidade > 0) {
        $stmtProduto = $pdo->prepare("SELECT PrecoUnitario, Desconto FROM TF_Produto WHERE idProduto = :idProduto");
        $stmtProduto->execute(['idProduto' => $idProduto]);
        $produto = $stmtProduto->fetch(PDO::FETCH_ASSOC);

        $precoFinal = $produto['PrecoUnitario'] * (1 - $produto['Desconto'] / 100);
        $valorTotal += $precoFinal * $quantidade;
    }
}

$stmtPedido = $pdo->prepare("
    INSERT INTO TF_Pedido (StatusPagamento, ValorTotal, Endereco, Data, Tipo, StatusEntrega, PedidoCliente)
    VALUES (:statusPagamento, :valorTotal, :endereco, :data, :tipo, :statusEntrega, :idCliente)
");
$stmtPedido->execute([
    'statusPagamento' => $statusPagamento,
    'valorTotal' => $valorTotal,
    'endereco' => $endereco,
    'data' => $data,
    'tipo' => $tipo,
    'statusEntrega' => $statusEntrega,
    'idCliente' => $idCliente
]);

$idPedido = $pdo->lastInsertId();

foreach ($quantidades as $idProduto => $quantidade) {
    if ($quantidade > 0) {
        $stmtProdutoPedido = $pdo->prepare("
            INSERT INTO Pedido_has_Produto (TF_Pedido_idPedido, TF_Produto_idProduto, Quantidade)
            VALUES (:idPedido, :idProduto, :quantidade)
        ");
        $stmtProdutoPedido->execute([
            'idPedido' => $idPedido,
            'idProduto' => $idProduto,
            'quantidade' => $quantidade
        ]);
    }
}

header("Location: dashboard_cliente.php");
?>
