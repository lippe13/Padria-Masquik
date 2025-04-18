<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Padaria Masquik</title>
    <link rel="stylesheet" href="contato.css">
</head>
<body>
    <header>
        <nav>
            <ul>
            <?php if (isset($_SESSION['logado']) && $_SESSION['logado']): ?>
                <li><a href="index.php">Início</a></li>
            <?php else: ?>
                <li><a href="MenuUsuario.php">Início</a></li>
            <?php endif; ?>
                <li><a href="Produtos.php">Produtos</a></li>
                <li><a href="SobreNos.php">Sobre Nós</a></li>
                <li><a href="contato.php">Contato</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="sobre-nos">
            <h1>CONTATO</h1>
            <div class="sobre-conteudo">
                <div class="texto">
                    <p>
                        Em caso de dúvidas, entre em contato com os <strong>donos</strong>!
                    </p>
                    <p>
                        <strong>Felipe Mendes</strong>: 031 97174-0540
                    </p>
                    <p>
                        <strong>Matheus Silva</strong>: 031 98920-5392
                    </p>
                    <p>
                        <strong>Arthur Magno</strong>: 031 99386-5185
                    </p>
                    <p>
                        OBRIGADO POR COMPRAR COM A <strong>MASQUIK</strong>!
                    </p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
