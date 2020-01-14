<?php

//PÁGINA PRINCIPAL
session_start();
$sessao_usuario = null;

//unset($_SESSION['usuario']);

if (isset($_SESSION['usuario'])) {
    //CABEÇALHO
    include 'cabecalho.php';
    echo '
        <div class="mensagem">
            Olá <strong>'.$_SESSION['usuario'].'</strong>, você já está logado.<br><br>
            <a href="forum.php">Entrar no Fórum</a>
        </div>
    ';
    //RODAPÉ
    include 'rodape.php';
    exit();
}

//-------------------------------------------------------------------------
//CABEÇALHO
include 'cabecalho.php';

//INCLUSÃO DO FORMULÁRIO DE LOGIN
if($sessao_usuario == null){
    include 'login.php';
}

//-------------------------------------------------------------------------
//RODAPÉ
include 'rodape.php';

?>