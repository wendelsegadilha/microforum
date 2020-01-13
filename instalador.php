<?php

//INSTALADOR

//-------------------------------------------------------------------------
//INCLUSAO DO ARQUIVO DE CONFIGURAÇÃO
include 'config.php';

//-------------------------------------------------------------------------
//CRIAÇÃO DO BANCO DE DADOS
$conexao = new PDO("mysql:host=$servidor", $usuario, $senha);
$stmt = $conexao->prepare("CREATE DATABASE $banco_dados");
$stmt->execute();
$conexao = null;
echo '<p>Banco de dados criado com sucesso.</p><hr>';

//-------------------------------------------------------------------------
//CRIAR CONEXÃO PARA CRIAÇÃO DAS TABELAS
$conexao = new PDO("mysql:dbname=$banco_dados;host=$servidor", $usuario, $senha);

//-------------------------------------------------------------------------
//CRIAR TABELAS "ususarios" - USUÁRIOS DO MICRO FORUM
$sql = 'CREATE TABLE usuarios (
        id_usuario  INT NOT NULL PRIMARY KEY,
        nome_usuario VARCHAR(50),
        senha_usuario VARCHAR(100),
        avatar_usuario VARCHAR(250)
)';
$stmt = $conexao->prepare($sql);
$stmt->execute();
echo '<p>Tabela [usuarios] criada com sucesso.</p><hr>';

//-------------------------------------------------------------------------
//CRIAR TABELAS "postagens" - POSTAGENS DOS USUÁRIOS DO MICRO FORUM
$sql = 'CREATE TABLE postagens (
    id_postagem  INT NOT NULL PRIMARY KEY,
    id_usuario  INT NOT NULL,
    titulo_postagem VARCHAR(150),
    mensagem_postagem TEXT,
    data_postagem DATETIME,
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE
)';
$stmt = $conexao->prepare($sql);
$stmt->execute();
echo '<p>Tabela [postagens] criada com sucesso.</p><hr>';
$conexao = null;

//-------------------------------------------------------------------------
//INFORMAÇÃO DE CONCLUSÃO DO PROCESSO DE CRIAÇÃO DO BANCO DE DADOS
echo '<p>Processo de criação do Banco de Dados terminado.</p>';

?>