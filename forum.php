<?php

///PÁGINA DO FÓRUM
session_start();
if (!isset($_SESSION['usuario'])) {
    include 'cabecalho.php';
    echo '
        <div class="erro">
        Você não tem permissão para ver o conteúdo do fórum.<br><br>
        <a href="index.php">Voltar</a>
        </div>
    ';
    include 'rodape.php';
    exit();
}

//-------------------------------------------------------------------------
//CABEÇALHO
include 'cabecalho.php';

//-------------------------------------------------------------------------
//DADOS DO USUÁRIO LOGADO
echo '
    <div class="dados_usuario">
        <img src="images/avatares/'.$_SESSION['avatar'].'">
        <span>'.ucfirst($_SESSION['usuario']).'</span> | 
        <a href="sair.php">Sair</a>
    </div>
';

//-------------------------------------------------------------------------
//RODAPÉ
include 'rodape.php';

?>