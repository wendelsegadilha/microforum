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
}else{
    registrarUsuario();
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

        <h3>Registro<br><hr></h3><br>

        <label for="txt_usuario">Usuário:</label><br>
        <input type="text" name="txt_usuario" id="txt_usuario" size="20"><br><br>

        <label for="txt_senha_1">Senha:</label><br>
        <input type="password" name="txt_senha_1" id="txt_senha_1" size="20"><br><br>

        <label for="txt_senha_2">Confirmar senha:</label><br>
        <input type="password" name="txt_senha_2" id="txt_senha_2" size="20"><br><br>

        <label for="img_avatar">Avatar:</label><br>
        <input type="file" name="img_avatar" id="img_avatar"><br>
        <small>(Imagem do tipo <strong>JPG</strong>, tamanho máximo: <strong>100Kb</strong>)</small><br><br>

        <input type="submit" name="btn_registro" value="Registrar-se"><br><br>
        <a href="index.php">Voltar</a>

        </form>
    ';
}

//-------------------------------------------------------------------------
function registrarUsuario(){

    //OPERAÇÕES PARA REGISTRO DE UM NOVO USUÁRIO
    $nome_usuario = $_POST['txt_usuario']; 
    $senha_1 = $_POST['txt_senha_1']; 
    $senha_2 = $_POST['txt_senha_2']; 
    //AVATAR
    $avatar = $_FILES['img_avatar'];
    $erro = false;

    //-------------------------------------------------------------------------
    //VERIFICAÇÃO DOS ERROS DO USUÁRIO
    if($nome_usuario == "" || $senha_1 == "" || $senha_2 == ""){

        //ERRO - CAMPOS MAU PREENCHIDOS
        echo '<div class="erro">Não foram preenchidos os campos necessários.</div>';
        $erro = true;

    }else if($senha_1 != $senha_2){

         //ERRO - SENHAS NÃO COINCIDEM 
         echo '<div class="erro">As senhas informadas não coincidem.</div>';
         $erro = true;

    }else if($avatar['name'] != "" && $avatar['size'] > 100000){

        //ERRO - ARQUIVO DE IMAGEM DE TAMANHO MAIOR QUE O PERMITIDO
        echo '<div class="erro">A imagem selecionada tem tamanho maior que o permitido.</div>';
        $erro = true;

    }else if($avatar['name'] != "" && $avatar['type'] != 'image/jpeg'){

        //ERRO - TIPO DE IMAGEM INVÁLIDA
        echo '<div class="erro">Arquivo de imagem inválido: '.$avatar['type'].'</div>';
        $erro = true;

    }

    //-------------------------------------------------------------------------
    //VERIFICAR SE OCORRERAM ERROS
    if ($erro) {
        exibirFormulario();
        //INCLUSÃO DO RODAPE
        include 'rodape.php';
        exit();
    }

    //-------------------------------------------------------------------------
    //PROCESSAMENTO DO REGISTRO DO NOVO USUÁRIO
    //-------------------------------------------------------------------------
    include 'config.php';
    $conexao = new PDO("mysql:dbname=$banco_dados;host=$servidor", $usuario, $senha);

    //-------------------------------------------------------------------------
    //VERIFICAR SE JÁ EXISTE UM REGISTRO COM O MESMO NOME DE USUÁRIO
    $stmt = $conexao->prepare("SELECT nome_usuario FROM usuarios WHERE nome_usuario = ?");
    $stmt->bindParam(1, $nome_usuario, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() != 0){

        //USUÁRIO JÁ SE ENCONTRA REGISTRADO
        echo '<div class="erro">Já existe um usuário registrado com o mesmo nome.</div>';
        $conexao = null;
        exibirFormulario();
        //INCLUSÃO DO RODAPE
        include 'rodape.php';
        exit();

    }else{

        //EFETUA O REGISTRO DO USUÁRIO
        $stmt = $conexao->prepare("SELECT MAX(id_usuario) AS max_id FROM usuarios;");
        $stmt->execute();
        $id_max = $stmt->fetch(PDO::FETCH_ASSOC)['max_id'];
        if($id_max == null){
            $id_max = 0;
        }else{
            $id_max++;
        }

        //ENCTIPTAR A SENHA
        $senha_encriptada = md5($senha_1);

        $sql = "INSERT INTO usuarios VALUES (:id_usuario, :nome_usuario, :senha_usuario, :avatar_usuario)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam('id_usuario', $id_max, PDO::PARAM_INT);
        $stmt->bindParam('nome_usuario', $nome_usuario, PDO::PARAM_STR);
        $stmt->bindParam('senha_usuario', $senha_encriptada, PDO::PARAM_STR);
        $stmt->bindParam('avatar_usuario', $avatar['name'], PDO::PARAM_STR);
        $stmt->execute();
        $conexao = null;

        //UPLOAD DO AVATAR DO USUÁRIO
        move_uploaded_file($avatar['tmp_name'], "images/avatares/".$avatar['name']);

        //MENSAGEM DE BOAS VINDAS AO USUÁRIO
        echo '<div class="registro_sucesso">
                Bem vindo ao Micro Fórum, <strong>'.$nome_usuario.'.</strong><br><br>
                Efetue o login para ter acesso a nossa comunidade.<br><br>
                <a href="index.php">Formulário de Login</a>
             </div>';


    }

}

?>