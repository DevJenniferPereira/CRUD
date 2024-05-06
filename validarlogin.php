
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>SIS COmpletão - Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
  </head>


<?php
require_once "bd/conexao.php";
require_once "topo.php";


//pegar e validar os campos de usuario e senha do login.php
if(isset($_POST['email']) && isset($_POST['senha'])){
    $email=$_POST['email'];
    $senha=$_POST['senha'];
    //buscar o usuário na tabela
    $sql="Select * from tbusuarios where email='".$email.
    "' and senha='".$senha."'";
    $resultado=$conn->query($sql);
    foreach($resultado as $registro) {
        
        //se tiver registros
        //veja o status
        //status que pode já acessar o sistema é o 1
        if($registro['idStatus']==1){
            echo "<p>Login deu certo</p>";
            //exit;
            //vida que segue.. verificar permissoes...
            $sql2 = "select * from tbpermissoes p, tbmodulos m 
            where p.idModulo = m.id and
            idUsuario=". $registro['id'];
            $resultado2 = $conn->query($sql2);
            
            foreach($resultado2 as $registroPermissoes) {
                echo "<p><a href='".$registroPermissoes['link']."'>".
            $registroPermissoes['descricao']."</a></p>";
            }
            //criar sessão do usuario, para verificar se está logando quando entrar em outras páginas
            session_start();
            $_SESSION['idUsuario']=$registro['id'];
            $_SESSION['nomeUsuario']=$registro['nome'];

            exit;
            



            // ? => $registro['id]; //veio do select de cima
            //$permissoes['nivel']
            //echo "<p>a href='$permissoes['link']>$permissoes
            //percorrer registros do select das permissoes
        }else{
            echo "<h3>Você precisa verificar seu login, status = ".$registro['idStatus']."')</h3>";
        }
    }//fim do FOR para encontrar o registro
    echo "<h3>Usuário ou senha inválidos<h3>";
}//fim do if isset
else {
    echo "<script>window.alert('Preencha o e-mail e a senha.')</script>";
}
?>


