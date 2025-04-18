<?php
session_start();
include 'conexao.php'; 


if (!isset($_SESSION['user_id']) || $_SESSION['user_cargo'] != 'cliente') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idPedido'])) {
    $idPedido = $_POST['idPedido'];

    $stmt = $pdo->prepare("SELECT * FROM TF_Pedido WHERE idPedido = :idPedido");
    $stmt->execute(['idPedido' => $idPedido]);
    $pedido = $stmt->fetch();

    if (!$pedido) {
        echo "Pedido não encontrado!";
        exit();
    }

    if ($pedido['Tipo'] == 'delivery' && $pedido['StatusEntrega'] == 'Aguardando Cliente...') {

        $stmt = $pdo->prepare("UPDATE TF_Pedido SET StatusEntrega = 'Entregue' WHERE idPedido = :idPedido");
        $stmt->execute(['idPedido' => $idPedido]);

        header("Location: dashboard_cliente.php");
        exit();
    }


    if ($pedido['Tipo'] == 'loja') {

        $stmt = $pdo->prepare("UPDATE TF_Pedido SET StatusEntrega = 'Entregue' WHERE idPedido = :idPedido");
        $stmt->execute(['idPedido' => $idPedido]);


        header("Location: dashboard_cliente.php");
        exit();
    }

    echo "Não foi possível atualizar o status do pedido.";
    header("Location: dashboard_cliente.php");
    exit();
}
?>
