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
    <title>SIS COmpletão - Login</title>

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
      $descricao=$_POST['descricao'];
      $link=$_POST['link'];
      //echo "entrou no post";
    } else {
      $acao="novo";
      $id=0;
      $descricao="";
      $link="";
    }
    //acesso ao BD
    if($acao=="editar"){
      $sql = "select * FROM tbmodulos where id=".$id;
      $resultado = $conn->query($sql);
      foreach($resultado as $registro) {
        $descricao = $registro['descricao'];
        $link = $registro['link'];
        //echo $descricao;
      }
    }
    if($acao=="excluir"){
      echo "<script>window.alert('Excluído')</script>";
      $sql = "delete from tbmodulos where id=".$id;
      $conn->exec($sql);
      $id=0;
      $descricao="";
      $link="";
      $acao="novo";
    }
    if($acao=="atualizar"){
      echo "<script>window.alert('Atualizado')</script>";
      $sql = "update tbmodulos set descricao='".$descricao."', link='".$link."' where id=".$id;
      //echo $sql;
      $conn->exec($sql);
      $id=0;
      $descricao="";
      $link="";
      $acao="novo";
    }
      
    if($acao=="novo" && $id==0 && $descricao!=""){
    echo "<script>window.alert('Salvo com sucesso')</script>";
    $sql = "insert into tbmodulos (descricao,link) values('".$descricao."','".$link."')";
    //echo $sql;
    $conn->exec($sql);
    $id=0;
    $acao="novo";
    $descricao="";
    $link="";
    }
  ?>
</body>



<main class="w-100 m-auto" style="min-height: 400px;">
  <form action="modulo.php" method="post">
    <div class="container justify-content-center">
      <div class="left">
        <h1 class="h4 mb-3 fw-normal text-center">Cadastrar Módulos</h1>
        <div class="form-floating">
          <?php
            if($id>0 && $descricao!="")
            $acao="atualizar"; 
          ?>
          <input type="hidden" name="acao" value="<?php echo $acao;?>">
          <input type="text" name="id" class="form-control" 
          id="floatingInput" placeholder="ID" readonly
          value="<?php echo $id; ?>">
          <label for="floatingInput">Id</label>
        </div>
      
      <div class="form-floating">
        <input type="text" name="descricao" class="form-control" 
        id="floatingInput" placeholder="Descrição"
        value="<?php echo $descricao; ?>" required>
        <label for="floatingInput">Descrição</label>
      </div>

      <div class="form-floating">
        <input type="text" name="link" class="form-control" 
        id="floatingInput" placeholder="link"
        value="<?php echo $link; ?>" required>
        <label for="floatingInput">Link</label>
      </div><br>

      <div class="form-floating"></div>
      <button class="w-100 btn btn-lg btn-primary" type="submit"><?php echo strtoupper($acao); ?></button>
      <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
    </div>
  </form>
</main>


<main class="w-100 m-auto" style="min-height: 100px;">
<div id="listagem">
  <form action="modulo.php" method="post">
    <div class="container">
      <div class="row ">
        <h1 class=" mb-3 fw-normal text-center">Módulos Cadastrados</h1>

        <?php
          $sql="Select * from tbmodulos order by id";
          echo "<table><tr><th>ID</th><th>Descrição</th><th>Link</th><th>Acoes</th></tr>";
          $resultado = $conn->query($sql);
          foreach($resultado as $registro) {
            echo "<tr><td>".$registro["id"]."</td><td>".
            $registro["descricao"]."</td><td>".
            $registro["link"]."</td><td>
            
            <a href='modulo.php?id=".$registro["id"]."&acao=editar'><span class='material-symbols-outlined'>edit</span></a>
            <a href='modulo.php?id=".$registro["id"]."&acao=excluir'><span class='material-symbols-outlined'>delete</span></a>
            </td></tr>";
          }
          echo "</table>";
        ?>
      </div>
    </div>
  </form>
</main>

</html>
<?php
require_once "rodape.php";
?>