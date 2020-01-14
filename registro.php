<?php

//PÁGINA PRINCIPAL
$id_sessao = session_id();
if (empty($id_sessao)) {
    session_start();
}

//-------------------------------------------------------------------------
//CABEÇALHO
include 'cabecalho.php';

//-------------------------------------------------------------------------
//VERIFICA SE FORAM INSERIDOS DADOS DO USUÁRIO
if(!isset($_POST['btn_registro'])){
    exibirFormulario();
}


//-------------------------------------------------------------------------
//RODAPÉ
include 'rodape.php';

//-------------------------------------------------------------------------
//FUNÇÕES
//-------------------------------------------------------------------------
function exibirFormulario(){
    echo '
        <form class="form_registro" method="post" action="registro.php?a=registro" enctype="multipart/form-data">

        <h3>Registro<br><hr></h3>

        <label for="txt_usuario">Usuário:</label><br>
        <input type="text" name="txt_usuario" id="txt_usuario" size="20"><br><br>

        <label for="txt_senha_1">Senha:</label><br>
        <input type="password" name="txt_senha_1" id="txt_senha_1" size="20"><br><br>

        <label for="txt_senha_2">Confirmar senha:</label><br>
        <input type="password" name="txt_senha_2" id="txt_senha_2" size="20"><br><br>

        <input type="hidden" name="MAX_FILE_SIZE" value="100000">
        <label for="img_avatar">Avatar:</label><br>
        <input type="file" name="img_avatar" id="img_avatar"><br>
        <small>(Imagem do tipo <strong>JPG</strong>, tamanho máximo: <strong>100Kb</strong>)</small><br><br>

        <input type="submit" name="btn_registro" value="Entar"><br><br>
        <a href="index.php">Voltar</a>

        </form>
    ';
}

?>