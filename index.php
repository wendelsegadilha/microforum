<?php

//PÁGINA PRINCIPAL
$id_sessao = session_id();
if (empty($id_sessao)) {
    session_start();
}

//-------------------------------------------------------------------------
//CABEÇALHO
include 'cabecalho.php';

//INCLUSÃO DO FORMULÁRIO DE LOGIN
include 'login.php';

//-------------------------------------------------------------------------
//RODAPÉ
include 'rodape.php';

?>