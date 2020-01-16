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
//VERIFICAR SE É PARA EDITAR O POST
$id_postasgem = -1;
$editar = false;
$titulo_postagem = "";
$mensagem_postagem = "";

if(isset($_REQUEST['idpostagem'])){
    $id_postasgem = $_REQUEST['idpostagem'];
    $editar = true;
    //RECUPERANDO DADOS DA POSTAGEM
    include 'config.php';
    $conexao = new PDO("mysql:dbname=$banco_dados;host=$servidor", $usuario, $senha);
    $stmt = $conexao->prepare("SELECT * FROM postagens WHERE id_postagem = ".$id_postasgem);
    $stmt->execute();
    $postagem = $stmt->fetch(PDO::FETCH_ASSOC);
    $conexao = null;
    
    $titulo_postagem = $postagem['titulo_postagem'];
    $mensagem_postagem = $postagem['mensagem_postagem'];
}



//-------------------------------------------------------------------------
//DADOS DO USUÁRIO LOGADO
echo '
    <div class="dados_usuario">
        <img src="images/avatares/'.$_SESSION['avatar'].'">
        Usuário:<span>'.ucfirst($_SESSION['usuario']).'</span> | 
        <a href="sair.php">Sair</a>
    </div>
';


//-------------------------------------------------------------------------
//FORMULÁRIO DE CRIAÇÃO E EDIÇÃO DE POSTAGENS
echo '
    <div>
        <form class="form_postagem" action="adicionar_postagem.php" method="post">

        <h3>Postagem</h3><hr><br>
        
        <input type="hidden" name="id_usuario" value="'.$_SESSION['id_usuario'].'">
        <input type="hidden" name="id_postagem" value="'.$id_postasgem.'">

        <label for="txt_titulo">Título:</label><br>
        <input type="text" name="txt_titulo" id="txt_titulo" size="95" value="'.$titulo_postagem.'"><br><br>

        <label for="txt_mensagem">Mensagem:</label><br>
        <textarea id="txt_mensagem" name="txt_mensagem" rows="10" cols="97">'.$mensagem_postagem.'</textarea><br><br>
        
        <input type="submit" value="Postar" name="btn_postar"><br><br>

        <a href="forum.php">Voltar<a/>

        </form>
    </div>
';


//-------------------------------------------------------------------------
//RODAPÉ
include 'rodape.php';

?>