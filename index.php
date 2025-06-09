<?php
/* echo 'Diretório atual: ' . __DIR__; */

/* ob_start(); */ // Armazena os dados em cache
session_start();

if (isset($_SESSION['loginUser']) && isset($_SESSION['senhaUser'])) {
  header("Location: paginas/home.php");
}

include('config/conexao.php');

//Método de acesso a ação negada
if (isset($_GET['acao'])) {
  $acao = $_GET['acao'];
  if ($acao == 'negado') {
    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Erro ao Acessar o sistema!</strong> Efetue o login ;(</div>';
    header("Refresh: 5, index.php");
  }
  /*  else if ($acao == 'sair') {
     echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>
     <strong>Você saiu da Agenda Eletrônica!</strong> Esperamos que você volte ;(</div>';
     header("Refresh: 5, index.php");
   } */
}

if (isset($_POST['botao'])) {
  $email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
  $senha = base64_encode(filter_input(INPUT_POST, 'senha', FILTER_DEFAULT));

  $dados = "SELECT * FROM tb_user WHERE email_user=:email AND senha_user=:senha";

  try {
    $result = $conexao->prepare($dados);
    $result->bindParam(":email", $email, PDO::PARAM_STR);
    $result->bindParam(":senha", $senha, PDO::PARAM_STR);
    $result->execute();

    if ($result->rowCount() > 0) {
      $user = $result->fetch(PDO::FETCH_ASSOC);
      /*  echo "Logado como: " . $user['email_user']; */
      $login = $_POST['email'];
      $senha = base64_encode($_POST['senha']);
      $foto = $user['foto_user'];
      $nome = $user['nome_user'];
      //Cria a sessao
      $_SESSION['loginUser'] = $login;
      $_SESSION['senhaUser'] = $senha;
      $_SESSION['foto_user'] = $foto;
      $_SESSION['nome_user'] = $nome;

      header("Refresh: 1, paginas/home.php?acao=bemvindo");
    } else {
      echo '<div class="container">
              <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-check"></i> Não Logou!</h5>
              Email ou senha incorreta, Se não tiver cadastro crie uma conta abaixo em Criar Conta !!!
            </div>
          </div>';
      /* header("Refresh: 7, index.php"); */
    }
  } catch (Exception $e) {
    echo '<strong>ERRO DE PDO= </strong>' . $e->getMessage();
  }
}
/* else { */
/*  header("Refresh: 5, index.php"); */
/* } */

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Agenda</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />
</head>


<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Login da Agenda</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Insira seus dados para logar.</p>

        <form action="index.php" method="post">
          <div class="input-group mb-3">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="senha" id="senha" class="form-control" placeholder="senha" current-password />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <div class="col-12">
              <button type="submit" name="botao" id="botao" class="btn btn-primary btn-block">
                Logar
              </button>
            </div>
          </div>
          <div class="input-group mb-3">
            <div class="col-12">
              <a href="cad_usuario.php" class="btn btn-secondary btn-block">
                Criar conta
              </a>
            </div>
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>