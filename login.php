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
    <link href="css/style.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    
    
<main class="form-signin w-100 m-auto">

    <form action="validarlogin.php" method="POST">
    <img class="mb-4" src="assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Faça seu login</h1>

    <div class="form-floating">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">E-mail</label>
    </div>
    <div class="form-floating">
      <input type="password" name="senha" class="form-control" id="floatingPassword" placeholder="Senha">
      <label for="floatingPassword">Senha</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <a href="cadastrousuario.php">Cadastrar</a>
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Acesso</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
  </form>
</main>


    
  </body>
</html>
