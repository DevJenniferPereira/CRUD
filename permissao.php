<?php
  require_once "topo.php";
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
    }
    else if(isset($_POST['acao'])){
      $acao=$_POST['acao'];
      $id=$_POST['id'];
      $idmodulo=$_POST['idmodulo'];//nomes do formulário
      $idusuario=$_POST['idusuario'];
      $validade=$_POST['validade'];
      // Processar os níveis de permissão
      $nivel = ""; // Inicializa a variável $nivel
      if(isset($_POST['Incluir'])) $nivel .= "I"; // Se Incluir foi selecionado, adiciona "I" ao $nivel
      if(isset($_POST['Excluir'])) $nivel .= "E"; // Se Excluir foi selecionado, adiciona "E" ao $nivel
      if(isset($_POST['Listar'])) $nivel .= "L"; // Se Listar foi selecionado, adiciona "L" ao $nivel
      if(isset($_POST['Editar'])) $nivel .= "D"; // Se Editar foi selecionado, adiciona "D" ao $nivel
      // Se nenhum checkbox foi selecionado, $nivel será uma string vazia
      //echo "entrou no post";
    } 
    else {
      $acao="novo";
      $id=0;
      $idmodulo="";//nomes do formulário
      $idusuario="";
      $validade="";
      $nivel="";
    }
    
    //buscar o registro a ser exibido
    require_once "bd/conexao.php";
    if($acao=="novo" && $id==0 && $idmodulo!=""){
      echo "<script>window.alert('Salvo com sucesso')</script>";
      $sql = "insert into tbpermissoes (idmodulo,idusuario,validade,
      nivel) values(".$idmodulo.",".$idusuario.",'".$validade."','".
      $nivel."')";
      //echo $sql;
      $conn->exec($sql);
      $id=0;
      $acao="novo";
      $idmodulo="";
      $idusuario="";
      $validade="";
      $nivel="";
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
        $idmodulo = $registro['modulo_descricao']; // nomes da tabela
        $usuario_nome = $registro['usuario_nome'];
        $validade = $registro['validade'];
        $nivel = $registro['nivel'];
      }
    }

    if($acao=="excluir"){
      echo "<script>window.alert('Excluído')</script>";
      $sql = "delete from tbpermissoes where id=".$id;
      $conn->exec($sql);
      $id=0;
      $idmodulo="";
      $idusuario="";
      $validade="";
      $nivel="";
    }
    if($acao=="atualizar"){
      echo "<script>window.alert('Atualizado')</script>";
      $sql = "update tbpermissoes set idmodulo=".$idmodulo.
      ", idusuario=".$idusuario.
      ", validade='".$validade.
      "', nivel='".$nivel."' where id=".$id;
      //echo $sql;
      $conn->exec($sql);
      $id=0;
      $idmodulo="";
      $idusuario="";
      $validade="";
      $nivel="";
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
          if($id>0 && $idmodulo!="")
          $acao="atualizar"; ?>
          <input type="hidden" name="acao" value="<?php echo $acao;?>">
          <input type="text" name="id" class="form-control" 
          id="floatingInput" placeholder="ID" readonly
          value="<?php echo $id; ?>">
          <label for="floatingInput">Id</label>
        </div>

        <div >
          <label>Módulo</label><br>
          <select name="idmodulo" required>
          <option value="" <?php if(empty($idmodulo)) echo 'selected'; ?>>
            <?php echo empty($idmodulo) ? "Selecione um módulo" : $idmodulo; ?>
          </option> 
          <?php
            $sql2 = "select * FROM tbmodulos order by id";
            $resultado2 = $conn->query($sql2);
            foreach($resultado2 as $registro2) {
              echo "<option value='".$registro2['id']."' ".(($registro2['descricao'] == $idmodulo) ? 'selected' : '').">".$registro2['descricao']."</option>";
            }   
          ?>
          </select><br> 
        </div><br>
       
        <div>
          <label for="floatingInput">Usuário</label><br>
          <select name="idusuario" required><br>
            <?php
              // Verifica se o nome do usuário não está vazio
              if (!empty($usuario_nome)) {
                // Exibe o nome do usuário como opção selecionada
                echo "<option value='".$usuario_nome."' selected>".$usuario_nome."</option>";
              } else {
                // Exibe a opção padrão "Escolha um usuário"
                echo "<option value='' selected>Escolha um usuário</option>";
              }
              
              // Itera sobre os resultados da consulta dos usuários
              $sql3 = "SELECT * FROM tbusuarios ORDER BY nome";
              $resultado3 = $conn->query($sql3);
              foreach($resultado3 as $registro3) {
                // Exibe a opção, com o atributo "selected" definido se for o usuário selecionado
                echo "<option value='".$registro3['id']."' ".(($registro3['nome'] == $usuario_nome) ? 'selected' : '').">".$registro3['nome']."</option>";
              }
            ?>
          </select>
        </div><br>

        <div class="form-floating">
          <input type="date" name="validade" class="form-control" 
          id="floatingInput" placeholder="Validade"
          value="<?php echo $validade; ?>">
          <label for="floatingInput">Validade</label>
        </div>

        <div>
          <label for="incluir">Permissões</label><br>
          <input type="checkbox" name="Incluir" <?php echo (strpos($nivel, "I") !== false ? "checked" : ""); ?>>Incluir
          <input type="checkbox" name="Excluir" <?php echo (strpos($nivel, "E") !== false ? "checked" : ""); ?>>Excluir
          <input type="checkbox" name="Listar" <?php echo (strpos($nivel, "L") !== false ? "checked" : ""); ?>>Listar
          <input type="checkbox" name="Editar" <?php echo (strpos($nivel, "D") !== false ? "checked" : ""); ?>>Editar<br><br>
        </div>

        <div class="form-floating"></div>
        <button class="w-100 btn btn-lg btn-primary" type="submit"><?php echo strtoupper($acao); ?></button>
        
        <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
      </div>
    </div>
  </form>
</main>


<main class="w-100 m-auto" style="min-height: 400px;">
<div id="listagem">
  <form action="permissao.php" method="post">
    <div class="container">
      <div class="row">
        <h1 class="h4 mb-3 fw-normal text-center">Permissões Cadastradas</h1>
        <?php
        $sql="SELECT tbpermissoes.id, tbmodulos.descricao AS modulo_descricao, 
        tbusuarios.nome AS usuario_nome, 
        tbpermissoes.validade, tbpermissoes.nivel FROM tbpermissoes 
        JOIN tbmodulos ON tbpermissoes.idmodulo = tbmodulos.id 
        JOIN tbusuarios ON tbpermissoes.idusuario = tbusuarios.id ORDER BY tbpermissoes.id";
        
        echo "<table><tr><th>ID</th><th>Módulo</th><th>Usuário</th><th>Validade</th><th>Nível</th><th></th></tr>";
    
        $resultado = $conn->query($sql);
        foreach($resultado as $registro) {
          echo "<tr><td>".$registro["id"]."</td><td>".
          $registro["modulo_descricao"]."</td><td>".
          $registro["usuario_nome"]."</td><td>".
          $registro["validade"]."</td><td>".
          $registro["nivel"]."</td><td>

          <a href='permissao.php?id=".$registro["id"]."&acao=editar'><span class='material-symbols-outlined'>
          edit</span></a>
          <a href='permissao.php?id=".$registro["id"]."&acao=excluir'><span class='material-symbols-outlined'>
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
require_once "rodape.php";
?>