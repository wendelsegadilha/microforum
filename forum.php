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
        Usuário:<span>'.ucfirst($_SESSION['usuario']).'</span> | 
        <a href="sair.php">Sair</a>
    </div>
';

//NOVA POSTAGEM
echo '<div class="nova_postagem">
        <a href="novo_postagem.php">Nova Postagem</a>
      </div>    
';

//-------------------------------------------------------------------------
//APRESENTAÇÃO DAS POSTAGENS NO FORUM
    include 'config.php';
    $conexao = new PDO("mysql:dbname=$banco_dados;host=$servidor", $usuario, $senha);

    //EFETUA BUSCA NO BANCO DE DADOS
    $sql = "SELECT * FROM postagens INNER JOIN usuarios ON postagens.id_usuario = usuarios.id_usuario ORDER BY postagens.data_postagem DESC";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $todas_postagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conexao =  null;

    //VERIFICANDO SE EXISTEM POSTAGENS NO FORUM
    if($stmt->rowCount() == 0){
        echo '<div class="login_sucesso">Não existem postagens no fórum.</div>';
    }else{
        foreach ($todas_postagens as $postagem) {

            //DADOS DA POSTAGEM
            $id_postagem = $postagem['id_postagem'];
            $id_usuario = $postagem['id_usuario'];
            $titulo_postagem = $postagem['titulo_postagem'];
            $mensagem_postagem = $postagem['mensagem_postagem'];
            $data_postagem = $postagem['data_postagem'];

            //DADOS DO  USUARIO
            $nome_usuario = $postagem['nome_usuario'];
            $avatar_usuario = $postagem['avatar_usuario'];

            echo '<div class="postagens">';
            echo '<img src="images/avatares/'.$avatar_usuario.'">';
            echo '<span id="autor">Autor: <strong>'.$nome_usuario.'</strong></span>';
            echo '<span id="titulo">'.utf8_encode($titulo_postagem).'</span>';
            echo '<hr>';
            echo '<div id="mensagem">'.utf8_encode($mensagem_postagem).'</div>';
            echo '<span id="data_hora">'.$data_postagem.'</span>';
            echo  '</div>';

        }
    }

//-------------------------------------------------------------------------
//RODAPÉ
include 'rodape.php';

?>