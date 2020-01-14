<?php

//FORMULÁRIO DE LOGIN
echo '
    <form class="form_login" method="post" action="login.php">
    
    <h3>Login<br><hr></h3>
    Para ter acesso ao fórum é necessário possuir uma conta de usuário.<br>
    Caso ainda não possua uma conta de usuário, <a href="registro.php">registre-se</a> agora.<br><br>
    
    <label for="txt_usuario">Usuário:</label><br>
    <input type="text" name="txt_usuario" id="txt_usuario" size="20"><br><br>

    <label for="txt_senha">Senha:</label><br>
    <input type="password" name="txt_senha" id="txt_senha" size="20"><br><br>

    <input type="submit" name="btn_entrar" value="Entar">

    </form>
';

?>