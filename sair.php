<?php

session_start();
//-------------------------------------------------------------------------
//CABEÇALHO
include 'cabecalho.php';

//MSG PADRÃO DO SISTEMA
$mensagem = "Página não disponível a visitantes.";

//ESPECIFICA A MSG AO USUÁRIO
if(isset($_SESSION['usuario'])){
    $mensagem = 'Até a próxima '.$_SESSION['usuario'].'!';
}

//FAZ O LOGOUT DO USUÁRIO
unset($_SESSION['usuario']);

//APRESENTA BOX COM A MENSAGEM
echo '
    <div class="login_sucesso">
        '.$mensagem.'<br><br>
        <a href="index.php">Ínicio</a>
    </di>
';

//-------------------------------------------------------------------------
//RODAPÉ
include 'rodape.php';

?>