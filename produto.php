<?php
  require_once "topo.php";
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
    }
    else if(isset($_POST['acao'])){
      $acao=$_POST['acao'];
      $id=$_POST['id'];
      $descricao=$_POST['descricao'];
      $quantidade=$_POST['quantidade'];
      $preco=$_POST['preco'];
      $desconto=$_POST['desconto'];
      $idcategoria=$_POST['idcategoria'];
      $idstatus=$_POST['idstatus'];
    } 
    else if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $acao="novo";
      $id=0;
      $descricao=$_POST['descricao'];
      $quantidade=$_POST['quantidade'];
      $preco=$_POST['preco'];
      $desconto=$_POST['desconto'];
      $idcategoria=$_POST['idcategoria'];
      $idstatus=$_POST['idstatus'];
    } else {
      $id=0;
      $acao="novo";
      $descricao="";
      $quantidade="";
      $preco="";
      $desconto="";
      $idcategoria="";
      $idstatus="";
    }
    
    //buscar o registro a ser exibido
    require_once "bd/conexao.php";
    if($acao=="novo" && $id==0 && $idstatus!="" && $idcategoria!=""){
      echo "<script>window.alert('Salvo com sucesso')</script>";
      $sql = "insert into tbprodutos (idmodulo,idusuario,validade,
      nivel) values(".$idmodulo.",".$idusuario.",'".$validade."','".
      $nivel."')";
      //echo $sql;
      $conn->exec($sql);
      $id=0;
      $acao="novo";
      $descricao="";
      $quantidade="";
      $preco="";
      $desconto="";
      $idcategoria="";
      $idstatus="";
    }

    if ($acao == "editar") {
      // Consulta SQL para selecionar o registro específico a ser editado
      $sql = "SELECT tbpermissoes.id, tbmodulos.descricao AS modulo_descricao, 
      tbusuarios.nome AS usuario_nome, 
      tbpermissoes.validade, tbpermissoes.nivel 
      FROM tbpermissoes 
      JOIN tbmodulos ON tbpermissoes.idmodulo = tbmodulos.id 
      JOIN tbusuarios ON tbpermissoes.idusuario = tbusuarios.id 
      WHERE tbpermissoes.id = $id";
      $sql3 = "SELECT * FROM tbusuarios ORDER BY nome";
      $resultado = $conn->query($sql);
      foreach($resultado as $registro) {
        $idmodulo = $registro['idmodulo']; // nomes da tabela
        $usuario_nome = $registro['usuario_nome'];
        $validade = $registro['validade'];
        $nivel = $registro['nivel'];
      }
    }

    if($acao=="excluir"){
      echo "<script>window.alert('Excluído')</script>";
      $sql = "delete from tbprodutos where id=".$id;
      $conn->exec($sql);
      $id=0;
      $descricao="";
      $quantidade="";
      $preco="";
      $desconto="";
      $idcategoria="";
      $idstatus="";
    }
    if($acao=="atualizar"){
      echo "<script>window.alert('Atualizado')</script>";
      $sql = "update tbprodutos set descricao='".$descricao."', quantidade=".$quantidade.
      ", preco=". $preco.", desconto=".$desconto.", idcategoria=".$idcategoria. 
      ", idstatus=".$idstatus." where id=".$id;
      //echo $sql;
      $conn->exec($sql);
      $id=0;
      $descricao="";
      $quantidade="";
      $preco="";
      $desconto="";
      $idcategoria="";
      $idstatus="";
    }
  ?>
</body>

      
<main class="w-100 m-auto" style="min-height: 300px;">
  <form action="permissao.php" method="post">
    <div class="container justify-content-center">
      <div class="left"><br><br>
        <h1 class="h4 mb-3 fw-normal text-center">Cadastrar Permissões</h1>
        <div class="form-floating">
          <?php
          if($id>0 && $idstatus!="" && $idcategoria!="")
          $acao="atualizar"; ?>
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
          <input type="text" name="quantidade" class="form-control" 
          id="floatingInput" placeholder="Quantidade"
          value="<?php echo $quantidade; ?>" required>
          <label for="floatingInput">Quantidade</label>
        </div>
        <div class="form-floating">
          <input type="text" name="preco" class="form-control" 
          id="floatingInput" placeholder="Preço"
          value="<?php echo $preco; ?>" required>
          <label for="floatingInput">Preço</label>
        </div>
        <div class="form-floating">
          <input type="text" name="desconto" class="form-control" 
          id="floatingInput" placeholder="desconto"
          value="<?php echo $desconto; ?>" required>
          <label for="floatingInput">Desconto</label>
        </div>
        <div >
          <label>Categoria</label><br>
          <select name="idcategoria" required>
          <?php
            $sql2 = "select * FROM tbcategorias order by descricao";
            $resultado2 = $conn->query($sql2);
            foreach($resultado2 as $registro2) {
              echo "<option value='".$registro2['id']."' ".(($registro2['id'] == $idcategoria) ? 'selected' : '').">".$registro2['descricao']."</option>";
            }   
          ?>
          </select><br> 
        </div><br>
        <div >
          <label>Status</label><br>
          <select name="idstatus" required>
          <?php
            $sql3 = "select * FROM tbstatus order by descricao";
            $resultado3 = $conn->query($sql3);
            foreach($resultado3 as $registro3) {
              echo "<option value='".$registro3['id']."' ".(($registro3['id'] == $idstatus) ? 'selected' : '').">".$registro3['descricao']."</option>";
            }   
          ?>
          </select><br> 
        </div><br>
        
        <div class="form-floating"></div>
        <button class="w-100 btn btn-lg btn-primary" type="submit"><?php echo strtoupper($acao); ?></button>
        
        <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
      </div>
    </div>
  </form>
</main>


<main class="w-100 m-auto" style="min-height: 400px;">
<div id="listagem">
  <form action="produto.php" method="post">
    <div class="container">
      <div class="row">
        <h1 class="h4 mb-3 fw-normal text-center">Permissões Cadastradas</h1>
        <?php
        $sql="SELECT p.*, c.descricao as categoria, st.descricao as status FROM tbpermissoes p
        JOIN tbcategorias c ON tbprodutos.idcategoria = tbcategorias.id 
        JOIN tbstatus st ON tbprodutos.idstatus = tbstatus.id ORDER BY tbprodutos.descricao";
        
        echo "<table><tr><th>ID</th><th>Produto</th><th>Quantidade</th><th>Preço</th><th>Desconto</th><th>Categoria</th><th>Status</th><th>Ações</th></tr>";
    
        $resultado = $conn->query($sql);
        foreach($resultado as $registro) {
          echo "<tr><td>".$registro["id"]."</td><td>".
          $registro["descricao"]."</td><td>".
          $registro["quantidade"]."</td><td>".
          $registro["preco"]."</td><td>".
          $registro["desconto"]."</td><td>".
          $registro["categoria"]."</td><td>".
          $registro["status"]."</td><td>

          <a href='produto.php?id=".$registro["id"]."&acao=editar'><span class='material-symbols-outlined'>
          edit</span></a>
          <a href='produto.php?id=".$registro["id"]."&acao=excluir'><span class='material-symbols-outlined'>
          delete</span></a>
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