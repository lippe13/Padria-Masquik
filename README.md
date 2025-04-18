# Padria-Masquik

Linguagens utilizadas: PHP, MySql, HTML/CSS

## Descrição do Sistema

Sistema de padaria com uma capacidade de uso para 4 tipos/cargos de usuários diferente, cada um "acima do outro", respectivamente: cliente, funcionário, gerente e ADM.
Todo o sistema tem 1 usuário pré cadastrado em cada cargo.(além de 1 exemplo de pedido delivery feito). Há também, presença de outras telas para "familiarizar" o app, tornando-o mais bonito, interativo e chamativo ao usuário(Sobre Nós, Contato, etc)

Código e modelagem do banco de dados estão localizados nos outros branchs.

## Usuários

CLIENTE
--> Clientes podem ser cadastrados a qualquer momento, em acesso pelo menu --> login/cadastro
--> Clientes podem fazer 1 ou N compras. Sua dashboard, mostra os pedidos que já fez, métodos para adicionar saldo a carteira(será usado para fazer compras) e a opção "FAZER COMPRA";
--> Fazendo um pedido, o cliente pode comprar 1 ou N produtos, cada um na quantidade que desejar. Além disso adicionamos métodos para que haja 2 tipos de pedidos: o delivery e o loja física(simulando um "pegar na loja" do Ifood). Caso ele peça delivery, um funcionário deve liberar o pedido para entrega, e depois, o cliente deve confirmar a entrega/pagamento. Em caso de loja física, o cliente apenas deve confirmar a aquisição dos produtos.

FUNCIONÁRIO
--> Funcionários podem ser cadastrados/removidos do sistema por gerentes.
--> Sua tela é uma aba de consulta, onde ele insere o CPF do cliente, e vê todos os pedidos feitos por esse usuário. Caso o pedido seja delivery, e ainda não esteja entregue, o funcionário tem a opção de liberar o pedido para entrega, o que só aguardará a confirmação do cliente para que fique "Entregue".

GERENTE
--> Gerentes podem ser cadastrados/removidos do sistema por ADMs.
--> Sua tela tem opções para cadastrar/remover Funcionários, além de uma opção para ver TODOS os pedidos registrados no sistema.

ADM
--> Cargo mais alto no sistema, ele possui um usuário pré inserido. Não pode ser removido do sistema.
--> Sua tela apresenta funções para: cadastrar e remover Gerentes // cadastrar novos ADMs // adicionar um novo produto ao sistema // ver todos os produtos cadastrados

## Dados Pré-Inseridos

ADMIN
--> Nome: Felipe Mendes
--> CPF: 15161444657
--> Celular: 31971740540
--> Senha: robin

GERENTE
--> Nome: Arthur Magno
--> CPF: 99257099
--> Celular: 03199386-5185
--> Senha: senha

FUNCIONARIO
--> Nome: Matheus Silva
--> CPF: 995000410
--> Celular: 03198920-5392
--> Senha: senha

CLIENTE
--> Nome: Marcio Fantini
--> Email: mf@gmail.com
--> CPF: 1020304050
--> Celular: 992584571
--> Senha: mf

## LINK para acesso

-- http://150.164.102.160/turma2024-integrado/303/a2023951571@teiacoltec.org/hp/Padaria/

## Autores

-- Felipe Davila Mendes, https://github.com/lippe13
-- Arthur Magno Castanha Só, 
-- Matheus Silva Rosa, 
