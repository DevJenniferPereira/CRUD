<?php
  require_once "topo.php";
  require_once "bd/conexao.php";
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>SIS COmpletão</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
  </head>

<body class="text-center">
  <?php
    //verificar a variavel ação
    $acao="";
    if(isset($_GET['acao'])){
      $acao=$_GET['acao'];
      if(isset($_GET['id']))
      $id=$_GET['id'];
      //echo "entrou no get";
    }else if(isset($_POST['acao'])){
      $acao=$_POST['acao'];
      $id=$_POST['id'];
      $nome=$_POST['nome'];
      $email=$_POST['email'];
      $senha=$_POST['senha'];
      //echo "entrou no post";
    } else {
      $acao="novo";
      $id=0;
      $nome="";
      $email="";
      $senha="";
    }
    //acesso ao BD
    if($acao=="editar"){
      $sql = "select * FROM tbusuarios where id=".$id;
      $resultado = $conn->query($sql);
      foreach($resultado as $registro) {
        $nome = $registro['nome'];
        $email = $registro['email'];
        $senha = $registro['senha'];
        //echo $descricao;
      }
    }
    if($acao=="excluir"){
      echo "<script>window.alert('Excluído')</script>";
      $sql = "delete from tbusuarios where id=".$id;
      $conn->exec($sql);
      $id=0;
      $nome="";
      $email="";
      $senha="";
      $acao="novo";
    }
    if($acao=="atualizar"){
      echo "<script>window.alert('Cadastro atualizado')</script>";
      $sql = "update tbusuarios set nome='".$nome."', email='".$email."', senha='".$senha."' where id=".$id;
      //echo $sql;
      $conn->exec($sql);
      $id=0;
      $nome="";
      $email="";
      $senha="";
      $acao="novo";
    }
      
    if($acao=="novo" && $id==0 && $nome!=""){
    echo "<script>window.alert('Salvo com sucesso')</script>";
    $sql = "insert into tbusuarios (nome,email,senha) values('".$nome."','".$email."','".$senha."')";
    //echo $sql;
    $conn->exec($sql);
    $id=0;
    $acao="novo";
    $nome="";
    $email="";
    $senha="";
    }
  ?>
</body>



<main class="w-100 m-auto" style="min-height: 400px;">
  <form action="cadastrousuario.php" method="post">
    <div class="container justify-content-center">
      <div class="left">
        <h1 class="h4 mb-3 fw-normal text-center">Cadastre-se</h1>
        <div class="form-floating">
          <?php
            if($id>0 && $nome!="")
            $acao="atualizar"; 
          ?>
          <input type="hidden" name="acao" value="<?php echo $acao;?>">
          <input type="text" name="id" class="form-control" 
          id="floatingInput" placeholder="ID" readonly
          value="<?php echo $id; ?>">
          <label for="floatingInput">Id</label>
        </div>

        <div class="form-floating">
        <input type="text" name="nome" class="form-control" 
        id="floatingInput" placeholder="nome"
        value="<?php echo $nome; ?>" required>
        <label for="floatingInput">Nome</label>
      </div>
      
      <div class="form-floating">
        <input type="text" name="email" class="form-control" 
        id="floatingInput" placeholder="Email"
        value="<?php echo $email; ?>" required>
        <label for="floatingInput">Email</label>
      </div>

      <div class="form-floating">
        <input type="text" name="senha" class="form-control" 
        id="floatingInput" placeholder="senha"
        value="<?php echo $senha; ?>" required>
        <label for="floatingInput">Senha</label>
      </div><br>

      <div class="form-floating"></div>
      <button class="w-100 btn btn-lg btn-primary" type="submit"><?php echo strtoupper($acao); ?></button><br><br>

      <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
    </div>
  </form>
</main>

<main class="w-100 m-auto" style="min-height: 100px;">
<button class="w-100 btn btn-primary" onclick="mostrarListagem()">VER CADASTROS</button>
  <div id="listagem" style="display: none;">
    <form action="cadastrousuario.php" method="post">

        <?php
          $sql="Select * from tbusuarios order by id";
          echo "<table><tr><th>ID</th><th>Nome</th><th>Email</th><th>Senha</th><th>Acoes</th></tr>";
          $resultado = $conn->query($sql);
          foreach($resultado as $registro) {
            echo "<tr><td>".$registro["id"]."</td><td>".
            $registro["nome"]."</td><td>".
            $registro["email"]."</td><td>".
            $registro["senha"]."</td><td>
            
            <a href='cadastrousuario.php?id=".$registro["id"]."&acao=editar'><span class='material-symbols-outlined'>edit</span></a>
            <a href='cadastrousuario.php?id=".$registro["id"]."&acao=excluir'><span class='material-symbols-outlined'>delete</span></a>
            </td></tr>";
          }
          echo "</table>";
        ?>
        <button class="w-100 btn btn-primary" onclick="alternarListagem()">OCULTAR LISTAGEM</button>

      </div>
    </div>
  </form>
</main>

</div>
      </div>
    </form>
  </div>
</main>

<script>
function mostrarListagem() {
  var listagemDiv = document.getElementById("listagem");
  listagemDiv.style.display = "block";
}

function alternarListagem() {
  var listagemDiv = document.getElementById("listagem");
  if (listagemDiv.style.display === "none") {
    listagemDiv.style.display = "block";
  } else {
    listagemDiv.style.display = "none";
  }
}
</script>

</html>
<?php
require_once "rodape.php";
?>