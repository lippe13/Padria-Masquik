CREATE TABLE IF NOT EXISTS `TF_Cliente` (
  `idCliente` INT NOT NULL AUTO_INCREMENT,
  `Senha` VARCHAR(255) NOT NULL,
  `CPF` VARCHAR(90) NOT NULL,
  `Celular` VARCHAR(90) NOT NULL,
  `Nome` VARCHAR(45) NOT NULL,
  `Email` VARCHAR(45) NOT NULL,
  `Saldo` FLOAT NOT NULL,
  PRIMARY KEY (`idCliente`),
  UNIQUE INDEX `CPF_UNIQUE` (`CPF` ASC) VISIBLE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TF_Pedido` (
  `idPedido` INT NOT NULL AUTO_INCREMENT,
  `StatusPagamento` VARCHAR(45) NOT NULL,
  `ValorTotal` FLOAT NOT NULL,
  `Endereco` VARCHAR(45) NOT NULL,
  `Data` DATETIME NOT NULL,
  `Tipo` VARCHAR(45) NOT NULL,
  `StatusEntrega` VARCHAR(45) NOT NULL,
  `PedidoCliente` INT NOT NULL,
  PRIMARY KEY (`idPedido`),
  INDEX `fk_Pedido_Cliente_idx` (`PedidoCliente` ASC) VISIBLE,
  CONSTRAINT `fk_Pedido_Cliente`
    FOREIGN KEY (`PedidoCliente`)
    REFERENCES `TF_Cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TF_Funcionario` (
  `idFuncionario` INT NOT NULL AUTO_INCREMENT,
  `Senha` VARCHAR(255) NOT NULL,
  `CPF` VARCHAR(45) NOT NULL,
  `Celular` VARCHAR(45) NOT NULL,
  `Nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idFuncionario`),
  UNIQUE INDEX `CPF_UNIQUE` (`CPF` ASC) VISIBLE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TF_Produto` (
  `idProduto` INT NOT NULL AUTO_INCREMENT,
  `Nome` VARCHAR(45) NOT NULL,
  `PrecoUnitario` FLOAT NOT NULL,
  `Desconto` FLOAT NOT NULL,
  `Estoque` INT NOT NULL,
  `Fornecedor` VARCHAR(90) NOT NULL,
  PRIMARY KEY (`idProduto`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TF_Gerente` (
  `idGerente` INT NOT NULL AUTO_INCREMENT,
  `Senha` VARCHAR(255) NOT NULL,
  `CPF` VARCHAR(45) NOT NULL,
  `Celular` VARCHAR(45) NOT NULL,
  `Nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idGerente`),
  UNIQUE INDEX `CPF_UNIQUE` (`CPF` ASC) VISIBLE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `TF_ADM` (
  `idADM` INT NOT NULL AUTO_INCREMENT,
  `Senha` VARCHAR(255) NOT NULL,
  `CPF` VARCHAR(45) NOT NULL,
  `Celular` VARCHAR(45) NOT NULL,
  `Nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idADM`),
  UNIQUE INDEX `CPF_UNIQUE` (`CPF` ASC) VISIBLE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Pedido_has_Produto` (
  `TF_Pedido_idPedido` INT NOT NULL,
  `TF_Produto_idProduto` INT NOT NULL,
  `Quantidade` INT NOT NULL,
  PRIMARY KEY (`TF_Pedido_idPedido`, `TF_Produto_idProduto`),
  INDEX `fk_TF_Pedido_has_TF_Produto_TF_Produto1_idx` (`TF_Produto_idProduto` ASC) VISIBLE,
  INDEX `fk_TF_Pedido_has_TF_Produto_TF_Pedido1_idx` (`TF_Pedido_idPedido` ASC) VISIBLE,
  CONSTRAINT `fk_TF_Pedido_has_TF_Produto_TF_Pedido1`
    FOREIGN KEY (`TF_Pedido_idPedido`)
    REFERENCES `TF_Pedido` (`idPedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TF_Pedido_has_TF_Produto_TF_Produto1`
    FOREIGN KEY (`TF_Produto_idProduto`)
    REFERENCES `TF_Produto` (`idProduto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO TF_Produto (Nome, PrecoUnitario, Desconto, Estoque, Fornecedor) VALUES
('Pão Francês', 2.50, 0.50, 100, 'Verdemar'),
('Pão de Queijo', 3.00, 0, 50, 'Verdemar'),
('Bolo de Chocolate', 15.00, 2.50, 30, 'Boca do Forno'),
('Baguete', 4.50, 0.50, 80, 'Boca do Forno'),
('Pão de Forma', 5.00, 0.70, 60, 'Boca do Forno'),
('Leite', 6.00, 1.50, 120, 'Supermercados BH'),
('Café', 10.00, 3.00, 150, 'Supermercados BH'),
('Muffin de Baunilha', 14.00, 0, 40, 'Dona Benta'),
('Coxinha', 7.00, 1.50, 20, 'Verdemar'),
('Biscoito de Polvilho', 5.00, 0, 200, 'Nestle');