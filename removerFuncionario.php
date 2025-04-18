<?php
include 'conexao.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_cargo'] != 'gerente') {
    header('Location: login.php');
    exit();
}

if (isset($_POST['remover_funcionario'])) {
    $idFuncionario = $_POST['id_funcionario'];

    if ($idFuncionario) {
        $deleteQuery = "DELETE FROM TF_Funcionario WHERE idFuncionario = :idFuncionario";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->execute(['idFuncionario' => $idFuncionario]);
    }
}

$query = "SELECT idFuncionario, Nome, CPF FROM TF_Funcionario";
$stmt = $pdo->prepare($query);
$stmt->execute();
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remover Funcionário</title>
    <link rel="stylesheet" href="removerFuncionario.css">
</head>
<body>
    <div class="container">
        <h1>Remover Funcionário</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($funcionarios): ?>
                    <?php foreach ($funcionarios as $funcionario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($funcionario['Nome']); ?></td>
                            <td><?php echo htmlspecialchars($funcionario['CPF']); ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id_funcionario" value="<?php echo $funcionario['idFuncionario']; ?>">
                                    <button type="submit" name="remover_funcionario" class="btn btn-danger">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Nenhum funcionário encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <a href="dashboard_gerente.php" class="btn">Voltar para o Menu Gerente</a>
    </div>
</body>
</html>
