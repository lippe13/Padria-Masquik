<?php
include 'conexao.php'; 

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_cargo'] != 'adm') {
    header('Location: login.php');
    exit();
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $precoUnitario = $_POST['precoUnitario'];
    $desconto = $_POST['desconto'];
    $estoque = $_POST['estoque'];
    $fornecedor = $_POST['fornecedor'];

    try {
        $query = "INSERT INTO TF_Produto (Nome, PrecoUnitario, Desconto, Estoque, Fornecedor) 
                  VALUES (:nome, :precoUnitario, :desconto, :estoque, :fornecedor)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':precoUnitario', $precoUnitario);
        $stmt->bindParam(':desconto', $desconto);
        $stmt->bindParam(':estoque', $estoque);
        $stmt->bindParam(':fornecedor', $fornecedor);
        $stmt->execute();

        $mensagem = "Produto adicionado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao adicionar produto: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="adicionarProduto.css">
</head>
<body>
    <div class="container">
        <h1>MASQUIK - Adicionar Produto</h1>

        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>

        <form method="POST" action="adicionarProduto.php">
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="precoUnitario">Preço Unitário:</label>
            <input type="number" step="0.01" id="precoUnitario" name="precoUnitario" required>

            <label for="desconto">Desconto (em reais):</label>
            <input type="number" step="0.01" id="desconto" name="desconto" required>

            <label for="estoque">Estoque:</label>
            <input type="number" id="estoque" name="estoque" required>

            <label for="fornecedor">Fornecedor:</label>
            <input type="text" id="fornecedor" name="fornecedor" required>

            <button type="submit" class="btn">Adicionar Produto</button>
        </form>

        <a href="dashboard_ADM.php" class="btn-voltar">Voltar à Dashboard</a>
    </div>
</body>
</html>
