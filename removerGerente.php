<?php
include 'conexao.php'; 

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_cargo'] != 'adm') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idGerente'])) {
    $idGerente = $_POST['idGerente'];

    try {
        $query = "DELETE FROM TF_Gerente WHERE idGerente = :idGerente";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idGerente', $idGerente, PDO::PARAM_INT);
        $stmt->execute();

        $mensagem = "Gerente removido com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao remover gerente: " . $e->getMessage();
    }
}

try {
    $query = "SELECT idGerente, Nome, CPF, Celular FROM TF_Gerente";
    $stmt = $pdo->query($query);
    $gerentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Remover Gerente</title>
    <link rel="stylesheet" href="removerGerente.css">
</head>
<body>
    <div class="container">
        <h1>Remover Gerente</h1>

        <?php if (isset($mensagem)): ?>
            <p class="mensagem"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>

        <?php if ($gerentes): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Celular</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gerentes as $gerente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($gerente['Nome']); ?></td>
                            <td><?php echo htmlspecialchars($gerente['CPF']); ?></td>
                            <td><?php echo htmlspecialchars($gerente['Celular']); ?></td>
                            <td>
                                <form method="POST" action="removerGerente.php">
                                    <input type="hidden" name="idGerente" value="<?php echo htmlspecialchars($gerente['idGerente']); ?>">
                                    <button type="submit" class="btn-remove">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum gerente cadastrado.</p>
        <?php endif; ?>

        <a href="dashboard_ADM.php" class="btn">Voltar ao Menu ADM</a>
    </div>
</body>
</html>
