<?php
  require_once "topo.php";
  require_once "bd/conexao.php";
  session_start();
  if(isset($_SESSION['idUsuario']) 
  && $_SESSION['idUsuario']<>0) { //se login ok
    echo "</p>Você está logado como: "
    .$_SESSION['nomeUsuario'];
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
        //echo "entrou no post";
      } else {
        $acao="novo";
        $id=0;
        $descricao="";
      }
      //acesso ao BD
      if($acao=="editar"){
        $sql = "select * FROM tbcategorias where id=".$id;
        $resultado = $conn->query($sql);
        foreach($resultado as $registro) {
          $descricao = $registro['descricao'];
        }
      }
      if($acao=="excluir"){
        echo "<script>window.alert('Excluído')</script>";
        $sql = "delete from tbcategorias where id=".$id;
        $conn->exec($sql);
        $id=0;
        $descricao="";
        $link="";
        $acao="novo";
      }
      if($acao=="atualizar"){
        echo "<script>window.alert('Atualizado')</script>";
        $sql = "update tbcategorias set descricao='".$descricao."' where id=".$id;
        //echo $sql;
        $conn->exec($sql);
        $id=0;
        $descricao="";
        $acao="novo";
      }
        
      if($acao=="novo" && $id==0 && $descricao!=""){
      echo "<script>window.alert('Salvo com sucesso')</script>";
      $sql = "insert into tbcategorias (descricao) values('".$descricao."')";
      //echo $sql;
      $conn->exec($sql);
      $id=0;
      $acao="novo";
      $descricao="";
      }
    ?>
  </body>



  <main class="w-100 m-auto" style="min-height: 400px;">
    <form action="categoria.php" method="post">
      <div class="container justify-content-center">
        <div class="left">
          <h1 class="h4 mb-3 fw-normal text-center">Cadastrar Categorias</h1>
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
          <h1 class=" mb-3 fw-normal text-center">Categorias Cadastradas</h1>

          <?php
            $sql="Select * from tbcategorias order by descricao";
            echo "<table><tr><th>ID</th><th>Descrição</th><th>Ações</th></tr>";
            $resultado = $conn->query($sql);
            foreach($resultado as $registro) {
              echo "<tr><td>".$registro["id"]."</td><td>".
              $registro["descricao"]."</td><td>            
              <a href='categoria.php?id=".$registro["id"]."&acao=editar'><span class='material-symbols-outlined'>edit</span></a>
              <a href='categoria.php?id=".$registro["id"]."&acao=excluir'><span class='material-symbols-outlined'>delete</span></a>
              </td></tr>";
            }
            echo "</table>";
          ?>
        </div>
      </div>
    </form>
  </main>
<?php 
} //fim do if que verificar se o usuário está logado
else{
  echo "<p>Você não possui permissão para acessar esta
  página, verifique seu login</p>";
}
require_once "rodape.php";
?>