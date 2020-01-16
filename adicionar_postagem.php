<?php

//EDITAR / CRIAR POSTAGENS
session_start();
if (!isset($_SESSION['usuario'])) {
    include 'cabecalho.php';
    echo '
        <div class="erro">
        Você não tem permissão para acessar esta página.<br><br>
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
        Usuário:<span>'.ucfirst($_SESSION['usuario']).'</span> | 
        <a href="sair.php">Sair</a>
    </div>
';

//RECUPERANDO DADOS DO FORMULÁRIO
$id_usuario = $_POST['id_usuario'];
$id_postagem = $_POST['id_postagem'];
$titulo_postagem = $_POST['txt_titulo'];
$mensagem_postagem = $_POST['txt_mensagem'];
$editar = false;

//VERIFICAÇÃO DE CAMPOS VAZIOS
if ($titulo_postagem == "" || $mensagem_postagem == "") {
    //CAMPOS NÃO PREENCHIDOS
    echo '<div class="erro">
        Não foram preenchidos os campos necessários.<br><br>
        <a href="editor_postagem.php">Tente novamente</a>
        </div>';
    //RODAPÉ
    include 'rodape.php';
    exit();
}

//VERIFICAR SE É PARA EDITAR OU SALVAR UM NOVO POSTA
    //CONEXAO COM O BANCO
    include 'config.php';
    $conexao = new PDO("mysql:dbname=$banco_dados;host=$servidor", $usuario, $senha);
    
if($id_postagem == -1){
    //RECUPERA UM ID VÁLIDO
    $stmt = $conexao->prepare("SELECT MAX(id_postagem) AS max_id FROM postagens;");
    $stmt->execute();
    $id_max = $stmt->fetch(PDO::FETCH_ASSOC)['max_id'];
    if($id_max == null){
        $id_max = 0;
    }else{
        $id_max++;
    }

    $editar = false;

}else{
    $editar = true;
}

if(!$editar){
    //PEGAR DATA E HORA ATUAL
    date_default_timezone_set("America/Fortaleza");//Setando o horário local
    $data = date('Y-m-d h:i:s', time());
    //SALVA A POSTAGEM
    $stmt  = $conexao->prepare("INSERT INTO postagens VALUES (?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $id_max, PDO::PARAM_INT);
    $stmt->bindParam(2, $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(3, $titulo_postagem, PDO::PARAM_STR);
    $stmt->bindParam(4, $mensagem_postagem, PDO::PARAM_STR);
    $stmt->bindParam(5, $data, PDO::PARAM_STR);
    $stmt->execute();
}else{
    //PEGAR DATA E HORA ATUAL
    date_default_timezone_set("America/Fortaleza");//Setando o horário local
    $data = date('Y-m-d h:i:s', time());
    //EDITA A POSTAGEM
    $stmt  = $conexao->prepare("UPDATE postagens SET titulo_postagem = :tit, mensagem_postagem = :msg, data_postagem = :dt WHERE id_postagem = :idp");
    $stmt->bindParam(':tit', $titulo_postagem, PDO::PARAM_STR);
    $stmt->bindParam(':msg', $mensagem_postagem, PDO::PARAM_STR);
    $stmt->bindParam(':dt', $data, PDO::PARAM_STR);
    $stmt->bindParam(':idp', $id_postagem, PDO::PARAM_INT);
    $stmt->execute();

}

//MENSAGEM DE SUCESSO AO GRAVAR OU EDITAR
echo '<div class="login_sucesso">
    Postagem salva com sucesso.<br><br>
    <a href="forum.php">Voltar</a>
    </div>';

//-------------------------------------------------------------------------
//RODAPÉ
include 'rodape.php';

?>