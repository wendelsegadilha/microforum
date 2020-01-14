<?php

//VERIFICAÇÃO DE LOGIN
session_start();
$sessao_usuario = null;
if (isset($_SESSION['usuario'])) {
    //CABEÇALHO
    include 'cabecalho.php';
    echo '
        <div class="mensagem">
            Olá, você já está logado.<br><br>
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

//-------------------------------------------------------------------------
//RECEBENDO VALORES DO FORMULÁRIO
$nome_usuario = isset($_POST['txt_usuario']) ? $_POST['txt_usuario'] : "";
$senha_usuario = isset($_POST['txt_senha']) ? $_POST['txt_senha'] : "";
//VERIFICAÇÃO DE PREENCHIMENTO DOS CAMPOS
if($nome_usuario == "" || $senha_usuario == ""){
    echo '<div class="erro">
        Não foram preenchidos os campos necessários.<br><br>
        <a href="index.php">Tente novamente</a>
        </div>';
    //RODAPÉ
    include 'rodape.php';
    exit();
}
//VERIFICAÇÃO DOS DADOS DE LOGIN
$senha_usuario_encriptada =  md5($senha_usuario);
include 'config.php';
$conexao = new PDO("mysql:dbname=$banco_dados;host=$servidor", $usuario, $senha);
$stmt = $conexao->prepare("SELECT * FROM usuarios WHERE nome_usuario = ? AND senha_usuario = ?");
$stmt->bindParam(1, $nome_usuario, PDO::PARAM_STR);
$stmt->bindParam(2, $senha_usuario_encriptada, PDO::PARAM_STR);
$stmt->execute();
$conexao = null;
//VERIFICA SE RETORNOU RESULTADOS
if ($stmt->rowCount() == 0) {
    echo '<div class="erro">
        Dados de login inválidos.<br><br>
        <a href="index.php">Tente novamente</a>
        </div>';
    //RODAPÉ
    include 'rodape.php';
    exit();
}else{
    
    //DINIÇÃO DOS DADOS DA SESSÃO
    $_SESSION['usuario'] = $stmt->fetch(PDO::FETCH_ASSOC)['nome_usuario'];
    $_SESSION['avatar'] =  $stmt->fetch(PDO::FETCH_ASSOC)['avatar_usuario'];
    echo '<div class="login_sucesso">
    Bem-vindo ao fórum, <strong>'.$_SESSION['usuario'].'</strong>.<br><br>
    Clique <a href="forum.php">aqui</a> para Continuar.
    </div>';

}


//-------------------------------------------------------------------------
//RODAPÉ
include 'rodape.php';



?>