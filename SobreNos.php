<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Padaria Masquik</title>
    <link rel="stylesheet" href="SobreNos.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo Padaria Masquik">
        </div>
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
            <h1>Sobre Nós</h1>
            <div class="sobre-conteudo">
                <div class="texto">
                    <p>
                        Fundada em 2024, a <strong>Padaria Masquik</strong> é uma referência na produção e distribuição de pães, doces caseiros e produtos frescos. Nosso compromisso é oferecer produtos de alta qualidade com ingredientes selecionados, preparados com carinho e dedicação.
                    </p>
                    <p>
                        Ao longo dos anos, conquistamos a confiança e o carinho de nossos clientes, sempre inovando, mas sem perder as raízes de tradição. Seja para um simples café da manhã ou uma ocasião especial, temos uma variedade de produtos para satisfazer todos os gostos.
                    </p>
                </div>

                <div class="imagem">
                    <img src="donos.png" alt="Donos da Padaria Masquik">
                    <p>
                        <strong>Felipe Mendes (LP), Matheus Silva (Masquik), Arthur Magno (Supas)</strong> são os principais empreendedores no segmento de produção e distribuição de produtos tradicionais de panificação. Pioneiros nos serviços de entrega, fundaram a padaria "Masquik", uma das mais conhecidas e renomadas em Belo Horizonte e região.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Padaria Masquik. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
