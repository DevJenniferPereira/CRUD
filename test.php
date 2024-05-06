<?php
require_once "topo.php";
require_once "bd/conexao.php";

//verificar a variavel ação
$acao = "";
if(isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if(isset($_GET['codigo']))
        $id = $_GET['codigo'];
} elseif(isset($_POST['acao'])) {
    $acao = $_POST['acao'];
    $id = $_POST['id'];
}

$id =0;
$statuss = "";
$preco = "";

//acesso ao BD
if($acao == "editar") {
    $sql = "select * FROM papelaria where id=".$id;
    $resultado = $conn->query($sql);
    foreach($resultado as $registro) {
        $statuss = $registro['statuss'];
        $preco = $registro['preco'];
    }
}

if($acao == "excluir") {
    echo "<script>window.alert('Excluído')</script>";
    $sql = "delete from papelaria where codigo=".$id;
    $conn->exec($sql);
    $acao = "novo";
}

if($acao == "atualizar") {
    echo "<script>window.alert('Cadastro atualizado')</script>";
    $sql = "update papelaria set statuss='".$statuss."', preco='".$preco."' where codigo=".$id;
    $conn->exec($sql);
    $acao = "novo";
}

if($acao == "novo") {
    // Verifica se a conexão é válida
    if($conn) {
        // Prepara a consulta SQL com Prepared Statements
        $sql = "INSERT INTO papelaria (statuss, preco) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        // Executa a consulta passando os valores como parâmetros
        if($stmt->execute([$statuss, $preco])) {
            echo "<script>window.alert('Salvo com sucesso')</script>";
        } else {
            echo "<script>window.alert('Erro ao salvar os dados')</script>";
        }
    } else {
        echo "<script>window.alert('Erro na conexão com o banco de dados')</script>";
    }
    $acao = "novo";
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>CRUD </♥></title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<main class="w-100 m-auto" style="min-height: 400px;">
    <form action="test.php" method="post">
        <div class="container justify-content-center">
            <div class="left">
                <h1 class="h4 mb-3 fw-normal text-center">Cadastrar</h1>
                <div class="form-floating">
                    <input type="hidden" name="acao" value="<?php echo $acao;?>">
                    <input type="text" name="id" class="form-control" id="floatingInput" placeholder="ID" readonly
                           value="<?php echo $id; ?>">
                    <label for="floatingInput">Codigo</label>
                </div>

                <div class="form-floating">
                    <input type="text" name="statuss" class="form-control" id="floatingInput" placeholder="statuss"
                           value="<?php echo $statuss; ?>" required>
                    <label for="floatingInput">Status</label>
                </div>

                <div class="form-floating">
                    <input type="text" name="preco" class="form-control" id="floatingInput" placeholder="Preço"
                        value="<?php echo $preco; ?>" required>
                    <label for="floatingInput">Preço</label>
                </div><br>

                <button class="w-100 btn btn-lg btn-primary" type="submit"><?php echo ($acao == 'novo') ? 'novo' : strtoupper($acao); ?>Salvar</button><br><br>

                <p class="mt-5 mb-3 text-muted">CRUD Jennifer Pereira &copy; 2024</p>
            </div>
        </div>
    </form>
</main>

<main class="w-100 m-auto" style="min-height: 100px;">
    <button class="w-100 btn btn-primary" onclick="mostrarListagem()">VER CADASTROS</button>
    <div id="listagem" style="display: none;">
        <form action="test.php" method="post">
            <?php
            $sql="Select * from papelaria order by codigo";
            echo "<table><tr><th>Código</th><th>Status</th><th>Preço</th><th>Ações</th></tr>";
            $resultado = $conn->query($sql);
            foreach($resultado as $registro) {
                echo "<tr><td>".$registro["codigo"]."</td><td>".
                    $registro["statuss"]."</td><td>".
                    $registro["preco"]."</td><td>
                    <a href='test.php?id=".$registro["codigo"]."&acao=editar'><span class='material-symbols-outlined'>edit</span></a>
                    <a href='test.php?id=".$registro["codigo"]."&acao=excluir'><span class='material-symbols-outlined'>delete</span></a>
                    </td></tr>";
            }
            echo "</table>";
            ?>
            <button class="w-100 btn btn-primary" onclick="alternarListagem()">OCULTAR LISTAGEM</button>
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

</body>
</html>

<?php
require_once "rodape.php";
?>
