<?php
require_once "bd/conexao.php";
//pegar e validar os campos de usuario e senha do login.php
if(isset($_POST['email']) && isset($_POST['senha'])){
    $email=$_POST['email'];
    $senha=$_POST['senha'];
    //buscar o usuário na tabela
    $sql="Select * from tbusuarios where email='".$email.
    "' and senha='".$senha."'";
    $resultado = $conn->query($sql);
    foreach($resultado as $registro) {
       
        //se tiver registros
        //veja o status
        //status que pode já acessar o sistema é o 1
        if($registro['idStatus']==1){
            echo "<p>Login deu certo</p>";
            //vida que segue... verificar as permissões ...
            $sql2 = "select * from tbpermissoes p, tbmodulos m 
            where p.idModulo = m.id and 
            idUsuario=". $registro['id'];
            $resultado2 = $conn->query($sql2);
            foreach($resultado2 as $registroPermissoes) {
               //percorrer os registros do select das permissoes
               echo "<p><a href='".$registroPermissoes['link']."'>".
               $registroPermissoes['descricao']."</a></p>";
            }
            //criar sessão do usuário, para verificar se 
            //está logando quando entrar em outras páginas
            session_start();
            $_SESSION['idUsuario']=$registro['id'];
            $_SESSION['nomeUsuario']=$registro['nome'];
            exit;
        }else {
            echo "<h3>Você precisa verificar seu login, status = ".$registro['idStatus']."</h3>";
        }
    }//fim do for para encontrar o registro
    echo "<h3>Usuário ou senha inválidos</h3>";
}//fim do if isset
else {
    echo "<h3>Preencha o e-mail e a senha.</h3>";
}
?>