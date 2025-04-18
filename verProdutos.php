<?php
session_start();
include 'conexao.php'; 

$mensagem = '';

try {

    $stmt = $pdo->query("SELECT * FROM TF_Produto");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensagem = "Erro ao buscar produtos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="produtos.css"> 
</head>
<body>
    <div class="container">
        <h1>Masquik - Produtos</h1>

        <?php if ($mensagem): ?>
            <p class="mensagem"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Desconto</th>
                    <th>Estoque</th>
                    <th>Fornecedor</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($produtos): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($produto['Nome']); ?></td>
                            <td>R$ <?php echo number_format($produto['PrecoUnitario'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($produto['Desconto'], 2, ',', '.'); ?></td>
                            <td><?php echo $produto['Estoque']; ?></td>
                            <td><?php echo htmlspecialchars($produto['Fornecedor']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhum produto encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

            <div class="buttons">
            <button type="button" id="voltar" onclick="location.href='dashboard_ADM.php';">Voltar ao Menu ADM</button>
            </div>

        </table>
    </div>
</body>
</html>
