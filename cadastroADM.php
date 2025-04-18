<?php
session_start();
include 'conexao.php'; 

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = trim($_POST['cpf']);
    $nome = trim($_POST['nome']);
    $celular = trim($_POST['celular']);
    $senha = trim($_POST['senha']);

    if (!empty($cpf) && !empty($nome) && !empty($celular) && !empty($senha)) {
        try {
            
            $stmt = $pdo->prepare("SELECT * FROM TF_ADM WHERE CPF = :cpf");
            $stmt->execute(['cpf' => $cpf]);
            $cliente = $stmt->fetch();

            if ($cliente) {
                $mensagem = "Este CPF já está cadastrado!";
            } else {
                
                $stmt = $pdo->prepare("INSERT INTO TF_ADM (CPF, Nome, Celular, Senha) 
                VALUES (:cpf, :nome, :celular, :senha)");
                $stmt->execute([
                    'cpf' => $cpf,
                    'nome' => $nome,
                    'celular' => $celular,
                    'senha' => password_hash($senha, PASSWORD_BCRYPT) 
                ]);

                $mensagem = "Cadastrado com sucesso!";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro ao cadastrar: " . $e->getMessage();
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro</title>
  <link rel="stylesheet" href="cadastro.css">
</head>
<body>
  <div class="container">
    <h1>MASQUIK - Cadastro de ADM</h1>
    <form method="POST">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required>
      </div>
      <div class="form-group">
        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf" required>
      </div>
      <div class="form-group">
        <label for="celular">Celular</label>
        <input type="text" id="celular" name="celular" required>
      </div>
      <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required>
      </div>
      <div class="buttons">
        <button type="button" id="voltar" onclick="location.href='dashboard_ADM.php';">Voltar ao Menu ADM</button>
        <button type="button" id="voltar" onclick="location.href='index.php';">Voltar ao Menu Inicial</button>
        <button type="submit" id="cadastrar">Cadastrar</button>
      </div>
    </form>
    <p class="mensagem"><?php echo htmlspecialchars($mensagem); ?></p>
  </div>
</body>
</html>
