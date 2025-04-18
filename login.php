<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    if (empty($cpf) || empty($senha)) {
        echo "CPF e Senha são obrigatórios!";
        exit();
    }

    try {
        if ($tipo === 'cliente') {
            $stmt = $pdo->prepare("SELECT idCliente, Nome, Senha FROM TF_Cliente WHERE CPF = :cpf");
        } elseif ($tipo === 'adm') {
            $stmt = $pdo->prepare("SELECT idADM, Nome, Senha FROM TF_ADM WHERE CPF = :cpf");
        } elseif ($tipo === 'funcionario') {
            $stmt = $pdo->prepare("SELECT idFuncionario, Nome, Senha FROM TF_Funcionario WHERE CPF = :cpf");
        } elseif ($tipo === 'gerente') {
            $stmt = $pdo->prepare("SELECT idGerente, Nome, Senha FROM TF_Gerente WHERE CPF = :cpf");
        }
         else {
            echo "Tipo de usuário inválido!";
            exit();
        }

        $stmt->execute(['cpf' => $cpf]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['Senha'])) {
            $_SESSION['user_id'] = $user['idCliente'] ?? $user['idADM'] ?? $user['idFuncionario'] ?? $user['idGerente'];
            $_SESSION['user_name'] = $user['Nome'];
            $_SESSION['user_cargo'] = $tipo;

            if ($tipo === 'cliente') {
                header('Location: dashboard_cliente.php');
            } elseif ($tipo === 'adm') {
                header('Location: dashboard_ADM.php');
            } elseif ($tipo === 'funcionario') {
                header('Location: dashboard_funcionario.php');
            } elseif ($tipo === 'gerente') {
                header('Location: dashboard_gerente.php');
            }
            exit();
        } else {
            echo "<p>CPF/Senha/Cargo incorreto(s)! <a href='login.php'>Tente novamente</a></p>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" required>
            
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
            
            <label for="tipo">Cargo:</label>
            <select name="tipo" id="tipo" required>
                <option value="cliente">Cliente</option>
                <option value="adm">Administrador</option>
                <option value="gerente">Gerente</option>
                <option value="funcionario">Funcionario</option>
            </select>
            
            <button type="submit">Entrar</button>
            <a href="index.php" class="button">VOLTAR AO MENU</a>
        </form>
    </div>
</body>
</html>
